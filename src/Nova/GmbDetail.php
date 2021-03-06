<?php

declare(strict_types=1);

namespace Tipoff\Locations\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Tipoff\Support\Nova\BaseResource;

class GmbDetail extends BaseResource
{
    public static $model = \Tipoff\Locations\Models\GmbDetail::class;
    
    public static function label()
    {
        return 'GMB Details';
    }

    public static function singularLabel()
    {
        return 'GMB Detail';
    }

    public static $title = 'id';

    public static $search = [
        'id', 'name', 'latitude', 'longitude',
    ];
    
    public static $group = 'Locations';

    public function fieldsForIndex(NovaRequest $request)
    {
        return array_filter([
            ID::make()->sortable(),
            Text::make('name')->sortable(),
            Text::make('opened_at')->sortable(),
            Text::make('address')->sortable(),
            Text::make('address2')->sortable(),
            Text::make('city')->sortable(),
            Text::make('state')->sortable(),
            Text::make('zip')->sortable(),
            Text::make('phone')->sortable(),
            Text::make('latitude')->sortable(),
            Text::make('longitude')->sortable(),
            nova('location') ? BelongsTo::make('Location', 'location', nova('location'))->sortable() : null,
            nova('webpage') ? BelongsTo::make('Webpage', 'webpage', nova('webpage'))->sortable() : null,
        ]);
    }

    public function fields(Request $request)
    {
        return array_filter([
            ID::make()->sortable(),
            Text::make('name')->sortable(),
            Text::make('opened_at')->sortable(),
            Text::make('address')->sortable(),
            Text::make('address2')->sortable(),
            Text::make('city')->sortable(),
            Text::make('state')->sortable(),
            Text::make('zip')->sortable(),
            Text::make('phone')->sortable(),
            Text::make('latitude')->sortable(),
            Text::make('longitude')->sortable(),
            nova('location') ? BelongsTo::make('Location', 'location', nova('location'))->sortable() : null,
            nova('webpage') ? BelongsTo::make('Webpage', 'webpage', nova('webpage'))->sortable() : null,
        ]);
    }

    protected function dataFields(): array
    {
        return array_merge(
            parent::dataFields(),
            $this->creatorDataFields(),
        );
    }
}
