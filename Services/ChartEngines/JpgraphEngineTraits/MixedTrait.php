<?php

declare(strict_types=1);

namespace Modules\Chart\Services\ChartEngines\JpgraphEngineTraits;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\Chart\Models\MixedChart;
use Modules\Quaeris\Services\LimeModelService;
use Modules\Xot\Services\FileService;

// use Modules\Chart\Services\LimeModelService;

trait MixedTrait {
    public function mixed(string $id): self {
        // dddx($this);
        $mixed = MixedChart::findOrFail($id);

        $charts = $mixed->charts()->get(); // ->take(1);
        if (0 === $charts->count()) {
            $rows = $mixed->charts();
            // $sql = Str::replaceArray('?', $rows->getBindings(), $rows->toSql());
            $sql = str_replace('?', $rows->getBindings(), $rows->toSql());
            throw new Exception('charts vuoto sql:['.$sql.']');
        }

        $imgs = [];
        foreach ($charts as $chart) {
            $vars = $this->vars;
            $vars = array_merge($vars, $chart->toArray());
            if (Str::startsWith($vars['type'], 'mixed')) {
                throw new Exception('crei un loop infinito['.__LINE__.']['.__FILE__.']');
            }
            $tmp = LimeModelService::make()->mergeVars($vars)->getImg();
            $imgs[] = [
                'img_path' => FileService::fixPath(public_path($tmp)),
                'width' => $vars['width'],
                'height' => $vars['height'],
            ];
        }
        $this->imgs = $imgs;

        return $this;
    }

    public function pieMonthBarWeekBar(): self {
        $imgs = [];
        $vars = $this->vars;
        $vars['type'] = 'pie1';
        $vars['width'] = 300;
        $vars['height'] = 300;
        dddx($this);
        $tmp = LimeModelService::make()->mergeVars($vars)->getImg();

        $imgs[] = [
            'img_path' => FileService::fixPath(public_path($tmp)),
            'width' => $vars['width'],
            'height' => $vars['height'],
        ];

        // -------------------
        $vars = $this->vars;
        $vars['type'] = 'bar2';
        $vars['width'] = 400;
        $vars['height'] = 400;
        $vars['x_label_angle'] = 50;
        $vars['group_by'] = 'date:Y-M'; // M = mar,april,giu
        $vars['sort_by'] = 'date:Y-m'; // m=1,2,3
        $vars['take'] = -4;

        $tmp = LimeModelService::make()->mergeVars($vars)->getImg();
        $imgs[] = [
            'img_path' => FileService::fixPath(public_path($tmp)),
            'width' => $vars['width'],
            'height' => $vars['height'],
        ];

        // -------------------
        $vars['group_by'] = 'date:o-W';
        $vars['sort_by'] = 'date:o-W';
        $vars['chart_type'] = 'bar2';
        $vars['take'] = -4;
        $vars['width'] = 400;
        $vars['height'] = 400;

        $tmp = LimeModelService::make()->mergeVars($vars)->getImg();
        $imgs[] = [
            'img_path' => FileService::fixPath(public_path($tmp)),
            'width' => $vars['width'],
            'height' => $vars['height'],
        ];

        $this->imgs = $imgs;

        return $this;
    }

    public function pieMonthBarWeekBarSiNo(): self {
        $row = $this->vars['row'];

        $imgs = [];
        // -------------------------------
        $row->group_by = null;
        $row->chart_type = 'pie1';
        $row->take = null;
        $row->width = 300;
        $row->height = 300;
        $tmp = LimeModelService::make()->mergeVars(get_object_vars($row))->getImg();
        $imgs[] = [
            'img_path' => FileService::fixPath(public_path($tmp)),
            'width' => $row->width,
            'height' => $row->height,
        ];
        // -------------------------------

        $row->group_by = 'date:Y-M'; // M = mar,april,giu
        $row->sort_by = 'date:Y-m'; // m=1,2,3
        $row->chart_type = 'barYesNo';
        $row->take = -4;
        $row->width = 400;
        $row->height = 400;
        $tmp = LimeModelService::make()->mergeVars(get_object_vars($row))->getImg();
        $imgs[] = [
            'img_path' => FileService::fixPath(public_path($tmp)),
            'width' => $row->width,
            'height' => $row->height,
        ];

        // -------------------------------
        $row->group_by = 'date:o-W';
        $row->sort_by = 'date:o-W';
        $row->chart_type = 'barYesNo';
        $row->take = -4;
        $row->width = 400;
        $row->height = 400;
        $tmp = LimeModelService::make()->mergeVars(get_object_vars($row))->getImg();
        $imgs[] = [
            'img_path' => FileService::fixPath(public_path($tmp)),
            'width' => $row->width,
            'height' => $row->height,
        ];
        // -------------------------------

        $this->imgs = $imgs;

        return $this;
    }

    public function pieMonthBarWeekBarNoSi(): self {
        $row = $this->vars['row'];

        $imgs = [];
        // -------------------------------
        $row->group_by = null;
        $row->chart_type = 'pie1';
        $row->take = null;
        $row->width = 300;
        $row->height = 300;
        $tmp = LimeModelService::make()->mergeVars(get_object_vars($row))->getImg();
        $imgs[] = [
            'img_path' => FileService::fixPath(public_path($tmp)),
            'width' => $row->width,
            'height' => $row->height,
        ];
        // -------------------------------

        $row->group_by = 'date:Y-M'; // M = mar,april,giu
        $row->sort_by = 'date:Y-m'; // m=1,2,3
        $row->chart_type = 'barNoYes';
        $row->take = -4;
        $row->width = 400;
        $row->height = 400;
        $tmp = LimeModelService::make()->mergeVars(get_object_vars($row))->getImg();
        $imgs[] = [
            'img_path' => FileService::fixPath(public_path($tmp)),
            'width' => $row->width,
            'height' => $row->height,
        ];

        // -------------------------------
        $row->group_by = 'date:o-W';
        $row->sort_by = 'date:o-W';
        $row->chart_type = 'barNoYes';
        $row->take = -4;
        $row->width = 400;
        $row->height = 400;
        $tmp = LimeModelService::make()->mergeVars(get_object_vars($row))->getImg();
        $imgs[] = [
            'img_path' => FileService::fixPath(public_path($tmp)),
            'width' => $row->width,
            'height' => $row->height,
        ];
        // -------------------------------

        $this->imgs = $imgs;

        return $this;
    }

    public function lineHorizontalBar(): self {
        $imgs = [];
        $vars = $this->vars;

        $vars['group_by'] = 'date:Y-M';
        $vars['sort_by'] = 'date:o-W';
        $vars['type'] = 'line1';
        $vars['take'] = -4;
        $vars['width'] = 550;
        $vars['height'] = 400;
        $tmp = LimeModelService::make()->mergeVars($vars)->getImg();
        $imgs[] = [
            'img_path' => FileService::fixPath(public_path($tmp)),
            'width' => $vars['width'],
            'height' => $vars['height'],
        ];

        // ------------------------------------
        $vars['subquestion'] = null;
        $vars['group_by'] = 'field:Q41';
        $vars['sort_by'] = 'field:Q41';
        $vars['type'] = 'horizbar1';
        $vars['take'] = -4;
        $vars['width'] = 500;
        $vars['height'] = 400;
        $vars['yaxis_hide'] = 0;
        $vars['x_label_margin'] = 10;
        $tmp = LimeModelService::make()->mergeVars($vars)->getImg();
        $imgs[] = [
            'img_path' => FileService::fixPath(public_path($tmp)),
            'width' => $vars['width'],
            'height' => $vars['height'],
        ];
        // */

        $this->imgs = $imgs;

        return $this;
    }

    public function getDataYesNo(Collection $data): Collection {
        // dddx($data);

        // Sì No
        $data = $data->map(
            function ($item, $group) {
                $item = collect($item);

                $yes = $item->firstWhere('label', 'Sì');
                $no = $item->firstWhere('label', 'No');

                $yes_perc = $yes['value'] ?? 0;
                $no_perc = $no['value'] ?? 0;

                $yes_count = $yes['value1'] ?? 0;
                $no_count = $no['value1'] ?? 0;

                // $yes_perc = $yes['value'] ?? 0;
                // $no_perc = $no['value'] ?? 0;

                // --non metto gli astenuti
                $tot = $yes_count + $no_count;

                // if (0 == $tot) {
                //    $value = 0;
                // } else {
                //    $value = $yes_count * 100 / $tot;
                // }

                return [
                    'label' => $group,
                    'value' => $yes_perc,
                    'value1' => $tot,
                ];
            }
        )
        ->filter(
            function ($item) {
                return $item['value1'] > 0;
            }
        );

        return $data;
    }

    public function getDataNoYes(Collection $data): Collection {
        $data = $this->getDataYesNo($data);
        $data = $data->map(
            function ($item) {
                $item['value'] = 100 - $item['value'];

                return $item;
            }
        );

        return $data;
    }

    public function barYesNo(): self {
        $this->data = $this->getDataYesNo($this->data);

        $this->bar2();

        return $this;
    }

    public function barNoYes(): self {
        $this->data = $this->getDataNoYes($this->data);
        $this->bar2();

        return $this;
    }

    public function pieYesNo(): self {
        // $this->data = $this->getDataYesNo($this->data);

        $this->pie1();

        return $this;
    }

    public function pieNoYes(): self {
        // $this->data = $this->getDataNoYes($this->data);

        $this->pie1();

        return $this;
    }
}