<?php

declare(strict_types=1);

namespace Tipoff\Locations\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Tipoff\Support\Nova\BaseResource;

class GmbHour extends BaseResource
{
    public static $model = \Tipoff\Locations\Models\GmbHour::class;

    public static $title = 'id';

    public static $search = [
        'id'
    ];

    public function fieldsForIndex(NovaRequest $request)
    {
        return array_filter([
            ID::make()->sortable(),
            Text::make('monday_open')->sortable(),
            Text::make('monday_close')->sortable(),
            Text::make('tuesday_open')->sortable(),
            Text::make('tuesday_close')->sortable(),
            Text::make('wednesday_open')->sortable(),
            Text::make('wednesday_close')->sortable(),
            Text::make('thursday_open')->sortable(),
            Text::make('thursday_close')->sortable(),
            Text::make('friday_open')->sortable(),
            Text::make('friday_close')->sortable(),
            Text::make('saturday_open')->sortable(),
            Text::make('saturday_close')->sortable(),
            Text::make('sunday_open')->sortable(),
            Text::make('sunday_close')->sortable(),
            nova('location') ? BelongsTo::make('Location', 'location', nova('location'))->sortable() : null,
        ]);
    }

    public function fields(Request $request)
    {
        return array_filter([
            Text::make('monday_open')->sortable(),
            Text::make('monday_close')->sortable(),
            Text::make('tuesday_open')->sortable(),
            Text::make('tuesday_close')->sortable(),
            Text::make('wednesday_open')->sortable(),
            Text::make('wednesday_close')->sortable(),
            Text::make('thursday_open')->sortable(),
            Text::make('thursday_close')->sortable(),
            Text::make('friday_open')->sortable(),
            Text::make('friday_close')->sortable(),
            Text::make('saturday_open')->sortable(),
            Text::make('saturday_close')->sortable(),
            Text::make('sunday_open')->sortable(),
            Text::make('sunday_close')->sortable(),
            nova('location') ? BelongsTo::make('Location', 'location', nova('location'))->sortable() : null,
        ]);
    }

    protected function dataFields(): array
    {
        return [
            ID::make(),
            DateTime::make('Created At')->exceptOnForms(),
            nova('user') ? BelongsTo::make('Creator', 'creator', nova('user'))->exceptOnForms() : null,
        ];
    }
}
