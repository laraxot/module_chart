<?php

declare(strict_types=1);

namespace Modules\Chart\Models\Panels;

use Illuminate\Http\Request;
//--- Services --

use Illuminate\Support\Str;
use Modules\Chart\Models\Panels\Traits\ChartTrait;
use Modules\Xot\Models\Panels\XotBasePanel;

class ChartPanel extends XotBasePanel {
    use ChartTrait;

    /**
     * The model the resource corresponds to.
     */
    public static string $model = 'Modules\Quaeris\Models\Chart';

    /**
     * The single value that should be used to represent the resource when being displayed.
     */
    public static string $title = 'title';

    /**
     * Get the fields displayed by the resource.
        'value'=>'..',
     */
    public function fields(): array {
        $fields = $this->chartFields();
        $fields = collect($fields)->map(
            function ($item) {
                $item->name = Str::after($item->name, 'chart.');

                return $item;
            }
        )->all();

        return $fields;
    }

    /**
     * Get the tabs available.
     */
    public function tabs(): array {
        $tabs_name = [];

        return $tabs_name;
    }

    /**
     * Get the cards available for the request.
     */
    public function cards(Request $request): array {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function filters(Request $request = null): array {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     */
    public function lenses(Request $request): array {
        return [];
    }

    /**
     * Get the actions available for the resource.
     */
    public function actions(): array {
        return [];
    }
}
