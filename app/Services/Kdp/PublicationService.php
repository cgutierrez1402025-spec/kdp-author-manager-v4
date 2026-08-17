<?php namespace App\Services\Kdp;
use App\Models\{Work, Publication, Platform}; use App\DTOs\KdpPublicationPayload; use App\Jobs\SyncPublicationJob; use Illuminate\Support\Facades\DB;
class PublicationService {
    public function createPublication(Work $work, Platform $platform, array $formData): Publication {
        return DB::transaction(function () use ($work, $platform, $formData) {
            $publication = $work->publications()->create(['platform_id' => $platform->id, 'format' => $formData['format'], 'rights' => $formData['rights'] ?? 'exclusive', 'price' => $formData['price'] ?? null, 'currency' => $formData['currency'] ?? 'USD', 'status' => 'draft']);
            $payload = KdpPublicationPayload::fromWorkAndData($work, $formData);
            SyncPublicationJob::dispatch($publication)->onQueue('kdp-sync');
            return $publication->fresh();
        });
    }
    public function syncPublication(Publication $publication): bool {
        $publication->update(['status' => 'published', 'last_sync_at' => now()]); return true;
    }
}
