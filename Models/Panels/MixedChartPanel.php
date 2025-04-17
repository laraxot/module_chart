<?php

declare(strict_types=1);

namespace Modules\Chart\Models\Panels;

use Illuminate\Http\Request;
use Modules\Chart\Models\MixedChart;
// --- Services --

use Modules\Cms\Models\Panels\XotBasePanel;

/**
 * MixedChartPanel.
 */
class MixedChartPanel extends XotBasePanel {


    public MixedChart $row;
    /**
     * The model the resource corresponds to.
     */
    public static string $model = 'Modules\Chart\Models\MixedChart';

    /**
     * The single value that should be used to represent the resource when being displayed.
     */
    public static string $title = 'title';

    /**
     * Undocumented function.
     *
     * @param \Modules\Chart\Models\MixedChart $row
     */
    public function optionLabel($row): string {
        return $row->name;
    }

    public function title(): ?string {
        // Cannot access property $name on mixed.
        $value = $this->row->getAttributeValue('name');
        if (! \is_string($value)) {
            return null;
        }

        return $value;
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
