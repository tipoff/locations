<?php

namespace Tipoff\Locations\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Place;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tipoff\Support\Nova\BaseResource;

class Location extends BaseResource
{
    public static $model = \Tipoff\Locations\Models\Location::class;

    public static $orderBy = ['id' => 'asc'];

    public static $title = 'name';

    public static $search = [
        'id',
    ];

    public static $group = 'Escape Rooms';

    public function fieldsForIndex(NovaRequest $request)
    {
        return array_filter([
            ID::make()->sortable(),
            Text::make('Name')->sortable(),
            Text::make('Phone'),
        ]);
    }

    public function fields(Request $request)
    {
        return array_filter([
            nova('market') ? BelongsTo::make('Market', 'market', nova('market'))->required() : null,
            Text::make('Name')->required(),
            Slug::make('Slug')->from('Name'),
            Text::make('Title')->required(),
            Text::make('Abbreviation')->required(),
            Text::make('Timezone')->required(),
            Boolean::make('Corporate'),

            new Panel('Address Information', $this->addressFields()),

            new Panel('Location Team', $this->teamFields()),

            nova('room') ? HasMany::make('Rooms', 'rooms', nova('room')) : null,

            new Panel('Review Data', $this->reviewFields()),

            new Panel('Hours of Operation', $this->hoursFields()),

            nova('order') ? HasMany::make('Orders', 'orders', nova('order')) : null,

            nova('snapshot') ? HasMany::make('Snapshots', 'snapshots', nova('snapshot')) : null,

            nova('review') ? HasMany::make('Reviews', 'reviews', nova('review')) : null,

            nova('insight') ? HasMany::make('Insights', 'insights', nova('insight')) : null,

            new Panel('Waiver Agreements', $this->waiverFields()),

            new Panel('Configuration', $this->configurationFields()),

            nova('user') ? BelongsTo::make('Manager', 'manager', nova('user'))->searchable()->withSubtitles()->withoutTrashed() : null,
            nova('tax') ? BelongsTo::make('Booking Tax', 'bookingTax', nova('tax')) : null,
            nova('tax') ? BelongsTo::make('Product Tax', 'productTax', nova('tax')) : null,
            nova('fee') ? BelongsTo::make('Booking Fee', 'bookingFee', nova('fee')) : null,
            nova('fee') ? BelongsTo::make('Product Fee', 'productFee', nova('fee')) : null,

            new Panel('Data Fields', $this->dataFields()),
        ]);
    }

    protected function addressFields()
    {
        return [
            Place::make('Address', 'address')->nullable(),
            Text::make('Address Line 2', 'address2')->nullable(),
            Text::make('City')->nullable(),
            Text::make('State')->nullable(),
            Text::make('ZIP')->nullable(),
            Text::make('Phone')->nullable(),
        ];
    }

    protected function teamFields()
    {
        return array_filter([
            Text::make('Team Names')->nullable(),
            nova('image') ? BelongsTo::make('Team Photo', 'teamPhoto', nova('image'))->nullable()->showCreateRelationButton() : null,
        ]);
    }

    protected function reviewFields()
    {
        return [
            Text::make('Reviews', 'gmb_reviews')->nullable(),
            Text::make('Rating', 'gmb_rating')->nullable(),
            Text::make('Map Link', function () {
                return '<a href="' . $this->maps_url . '">' . $this->maps_url . '</a>';
            })->asHtml()->nullable(),
            Text::make('Review Link', function () {
                return '<a href="' . $this->review_url . '">' . $this->review_url . '</a>';
            })->asHtml()->nullable(),
            Text::make('Latitude')->nullable(),
            Text::make('Longitude')->nullable(),
            Text::make('GMB ID', 'gmb_location')->required(),
            Text::make('GMB Account')->nullable(),
            Text::make('Place ID', 'place_location')->nullable(),
            Text::make('Facebook')->nullable(),
            Text::make('Tripadvisor')->nullable(),
            Text::make('Yelp')->nullable(),
        ];
    }

    protected function hoursFields()
    {
        return [
            Text::make('Monday Open')->nullable(),
            Text::make('Monday Close')->nullable(),
            Text::make('Tuesday Open')->nullable(),
            Text::make('Tuesday Close')->nullable(),
            Text::make('Wednesday Open')->nullable(),
            Text::make('Wednesday Close')->nullable(),
            Text::make('Thursday Open')->nullable(),
            Text::make('Thursday Close')->nullable(),
            Text::make('Friday Open')->nullable(),
            Text::make('Friday Close')->nullable(),
            Text::make('Saturday Open')->nullable(),
            Text::make('Saturday Close')->nullable(),
            Text::make('Sunday Open')->nullable(),
            Text::make('Sunday Close')->nullable(),
        ];
    }

    protected function bookingFields()
    {
        return [
            Boolean::make('Covid'),
            Boolean::make('Use Iframe?', 'use_iframe'),
            Textarea::make('Booking Iframe')->nullable(),
            Date::make('Opened At')->required(),
            Date::make('Closed At')->required(),
        ];
    }

    protected function waiverFields()
    {
        return [
            Textarea::make('Waiver Agreement', 'waiver'),
            Textarea::make('Minor Agreement', 'waiver_minor'),
        ];
    }

    protected function dataFields(): array
    {
        return array_filter([
            ID::make(),
            nova('user') ? BelongsTo::make('Created By', 'creator', nova('user'))->exceptOnForms() : null,
            DateTime::make('Created At')->exceptOnForms(),
            nova('user') ? BelongsTo::make('Updated By', 'updater', nova('user'))->exceptOnForms() : null,
            DateTime::make('Updated At')->exceptOnForms(),
        ]);
    }

    protected function configurationFields()
    {
        return [
            Text::make('Stripe Publishable Key', 'stripe_publishable')
                ->nullable()
                ->hideFromDetail()
                ->canSee(function ($request) {
                    return $request->user()->hasRole(['Admin', 'Owner']);
                }),
            Text::make('Stripe Secret Key', 'stripe_secret')
                ->nullable()
                ->hideFromDetail()
                ->canSee(function ($request) {
                    return $request->user()->hasRole(['Admin', 'Owner']);
                }),
        ];
    }
}