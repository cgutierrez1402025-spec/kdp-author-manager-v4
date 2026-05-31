<?php

namespace Database\Factories;

use App\Models\ManuscriptVersion;
use App\Models\Work;
use App\Models\WorkLanguage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ManuscriptVersion>
 */
class ManuscriptVersionFactory extends Factory
{
    /**
     * The model associated with the factory.
     *
     * @var string
     */
    protected $model = ManuscriptVersion::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'work_id' => Work::factory(),
            'work_language_id' => WorkLanguage::factory(),
            'version_number' => $this->faker->randomElement(['1', '2', '3', '1.1', '1.2', '2.0']),
            'name' => $this->faker->sentence(2),
            'status' => $this->faker->randomElement(['draft', 'review', 'final', 'published', 'archived']),
            'is_candidate' => $this->faker->boolean(30), // 30% chance
            'is_final' => $this->faker->boolean(20),    // 20% chance
            'is_published' => $this->faker->boolean(10), // 10% chance
            'html_content' => $this->faker->paragraphs(5, true),
            'change_summary' => $this->faker->sentence(),
            'words_added' => $this->faker->numberBetween(0, 1000),
            'words_deleted' => $this->faker->numberBetween(0, 500),
        ];
    }

    /**
     * Indicate that this is a final version.
     */
    public function final(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_final' => true,
            'status' => 'final',
        ]);
    }

    /**
     * Indicate that this is a published version.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => true,
            'status' => 'published',
        ]);
    }

    /**
     * Indicate that this is a candidate version.
     */
    public function candidate(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_candidate' => true,
        ]);
    }

    /**
     * Indicate that this is a draft version.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_draft' => true,
            'status' => 'draft',
            'is_final' => false,
            'is_published' => false,
        ]);
    }
}