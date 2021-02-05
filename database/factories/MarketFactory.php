<?php namespace Tipoff\Locations\Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Locations\Models\Market;

class MarketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Market::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $city = $this->faker->city;

        return [
            'slug'                => Str::slug($city),
            'name'                => $city,
            'title'               => $city,
            'state'               => $this->faker->stateAbbr,
            'timezone'            => 'EST',
            'content'             => $this->faker->sentences(3, true),
            'entered_at'          => $this->faker->date(),
            'rooms_content'       => $this->faker->sentences(7, true),
            'faq_content'         => $this->faker->sentences(7, true),
            'competitors_content' => $this->faker->sentences(7, true),
            'creator_id'          => randomOrCreate(config('tipoff.model_class.user')),
            'updater_id'          => randomOrCreate(config('tipoff.model_class.user')),
        ];
    }
}