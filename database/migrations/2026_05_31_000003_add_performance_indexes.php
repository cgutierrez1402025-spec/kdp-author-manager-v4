<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('works', function (Blueprint $table) {
            $table->index(['status', 'user_id'], 'works_status_user_index');
        });

        Schema::table('publications', function (Blueprint $table) {
            $table->index(['asin', 'marketplace_id'], 'publications_asin_marketplace_index');
            $table->index(['status', 'platform_id'], 'publications_status_platform_index');
            $table->index(['work_id', 'status'], 'publications_work_status_index');
        });

        Schema::table('royalty_entries', function (Blueprint $table) {
            $table->index(['publication_id', 'year', 'month'], 'royalty_entries_pub_year_month_index');
        });

        Schema::table('royalty_payments', function (Blueprint $table) {
            $table->index(['platform_id', 'status'], 'royalty_payments_platform_status_index');
            $table->index(['expected_date', 'received_date'], 'royalty_payments_dates_index');
        });

        Schema::table('book_promotions', function (Blueprint $table) {
            $table->index(['status', 'start_date', 'end_date'], 'book_promotions_status_dates_index');
        });

        Schema::table('promotion_daily_results', function (Blueprint $table) {
            $table->index(['book_promotion_id', 'date'], 'promotion_daily_results_promo_date_index');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->index(['assigned_to', 'status', 'due_date'], 'tasks_assigned_status_due_index');
            $table->index(['status', 'due_date'], 'tasks_status_due_index');
        });

        Schema::table('checklist_items', function (Blueprint $table) {
            $table->index(['checklist_id', 'is_checked'], 'checklist_items_checklist_checked_index');
        });

        Schema::table('import_batches', function (Blueprint $table) {
            $table->index(['status', 'finished_at'], 'import_batches_status_finished_index');
        });

        Schema::table('ocr_jobs', function (Blueprint $table) {
            $table->index(['status', 'started_at', 'finished_at'], 'ocr_jobs_status_times_index');
        });

        Schema::table('stock_movements', function (Blueprint $table) {
            $table->index(['work_id', 'movement_date'], 'stock_movements_work_date_index');
            $table->index(['to_location_id', 'movement_date'], 'stock_movements_to_location_index');
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->index(['action', 'created_at'], 'activity_logs_action_created_index');
        });
    }

    public function down(): void
    {
        Schema::table('works', function (Blueprint $table) {
            $table->dropIndex('works_status_user_index');
        });

        Schema::table('publications', function (Blueprint $table) {
            $table->dropIndex('publications_asin_marketplace_index');
            $table->dropIndex('publications_status_platform_index');
            $table->dropIndex('publications_work_status_index');
        });

        Schema::table('royalty_entries', function (Blueprint $table) {
            $table->dropIndex('royalty_entries_pub_year_month_index');
        });

        Schema::table('royalty_payments', function (Blueprint $table) {
            $table->dropIndex('royalty_payments_platform_status_index');
            $table->dropIndex('royalty_payments_dates_index');
        });

        Schema::table('book_promotions', function (Blueprint $table) {
            $table->dropIndex('book_promotions_status_dates_index');
        });

        Schema::table('promotion_daily_results', function (Blueprint $table) {
            $table->dropIndex('promotion_daily_results_promo_date_index');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropIndex('tasks_assigned_status_due_index');
            $table->dropIndex('tasks_status_due_index');
        });

        Schema::table('checklist_items', function (Blueprint $table) {
            $table->dropIndex('checklist_items_checklist_checked_index');
        });

        Schema::table('import_batches', function (Blueprint $table) {
            $table->dropIndex('import_batches_status_finished_index');
        });

        Schema::table('ocr_jobs', function (Blueprint $table) {
            $table->dropIndex('ocr_jobs_status_times_index');
        });

        Schema::table('stock_movements', function (Blueprint $table) {
            $table->dropIndex('stock_movements_work_date_index');
            $table->dropIndex('stock_movements_to_location_index');
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropIndex('activity_logs_action_created_index');
        });
    }
};