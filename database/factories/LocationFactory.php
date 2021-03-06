<?php

declare(strict_types=1);

namespace Tipoff\Locations\Database\Factories;

use DrewRoberts\Blog\Models\Layout;
use DrewRoberts\Blog\Models\Page;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Locations\Models\Location;

class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition()
    {
        $city = $this->faker->unique()->city;

        return [
            'name'                  => $city,
            'slug'                  => Str::slug($city),
            'title_part'            => $city,
            'page_id'               => Page::factory()->create([
                'layout_id' =>  Layout::query()->where('view', 'locations::page.location.base')->firstOrFail()->id,
            ]),
            'market_id'             => randomOrCreate(app('market')),
            'timezone_id'           => randomOrCreate(app('timezone')),
            'contact_email_id'      => randomOrCreate(app('email_address')),
            'domestic_address_id'   => randomOrCreate(app('domestic_address')),
            'phone_id'              => randomOrCreate(app('phone')),
            'creator_id'            => randomOrCreate(app('user')),
            'updater_id'            => randomOrCreate(app('user'))
        ];
    }
}
