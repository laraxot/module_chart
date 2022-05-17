<?php

declare(strict_types=1);

namespace Modules\Chart\Models\Panels;

use Illuminate\Http\Request;
// --- Services --

use Modules\Xot\Models\Panels\XotBasePanel;

/**
 * MixedChartPanel.
 */
class MixedChartPanel extends XotBasePanel {
    /**
     * The model the resource corresponds to.
     */
    public static string $model = 'Modules\Chart\Models\MixedChart';

    /**
     * The single value that should be used to represent the resource when being displayed.
     */
    public static string $title = 'title';

    public function optionLabel($row): string {
        return $row->name;
    }

    public function title(): ?string {
        return optional($this->row)->name;
    }

    /**
     * Get the fields displayed by the resource.
        'value'=>'..',
     */
    public function fields(): array {
        return [
            (object) [
                'type' => 'Id',
                'name' => 'id',
                'comment' => null,
            ],

            (object) [
                'type' => 'String',
                'name' => 'name',
                'rules' => 'required',
                'comment' => null,
            ],
        ];
    }

    /**
     * Get the tabs available.
     */
    public function tabs(): array {
        $tabs_name = ['charts'];

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
