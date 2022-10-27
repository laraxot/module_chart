<?php

declare(strict_types=1);

namespace Modules\Chart\Models\Panels\Traits;

use Modules\Chart\Models\MixedChart;

/**
 * Undocumented trait.
 */
trait ChartTrait {
    /**
     * Undocumented function.
     */
    public function optionsChartType(): array {
        $options = [
            'pie1' => 'torta',
            'pieAvg' => 'torta con media',
            'horizbar1' => 'barre orizzontali',
            'bar2' => 'barre verticali',
            'bar1' => 'bar1',
            'line1' => 'linea',
            'lineSubQuestion' => 'linea da usare con subquestion',
            // 'barYesNo' => 'barre si/no',
            // 'barNoYes' => 'barre no/si',
            // 'pieMonthBarWeekBar' => 'torta/mese/settimana',
            // 'pieMonthBarWeekBarSiNo' => 'torta/mese/settimana si/no',
            // 'pieMonthBarWeekBarNoSi' => 'torta/mese/settimana no/si',
            // 'lineHorizontalBar' => 'linea/barre orizzontali',
            // 'pieYesNo' => 'torta si/no',
            // 'pieNoYes' => 'torta no/si',
        ];

        $mixed = MixedChart::get()->pluck('name', 'id')->all();
        $data = [];
        foreach ($mixed as $k => $v) {
            $k1 = 'mixed:'.$k;
            $data[$k1] = 'mixed:'.$v;
        }
        $options = array_merge($options, $data);

        return $options;
    }

    public function chartFields(): array {
        return [
            (object) [
                'type' => 'Select',
                'name' => 'chart.type',
                'comment' => null,
                'col_size' => 4,
                'rules' => 'required',
                'options' => $this->optionsChartType(),
            ],
            (object) [
                'type' => 'Select',
                'name' => 'chart.group_by',
                'comment' => null,
                'col_size' => 4,
                'options' => [null => '---', 'date:o-W' => 'Settimanale', 'date:Y-M' => 'Mensile', 'date:Y-M-d' => 'Giornaliero', 'field:Q41' => 'field:Q41'],
            ],
            (object) [
                'type' => 'Select',
                'name' => 'chart.sort_by',
                'comment' => null,
                'col_size' => 4,
                'options' => [null => '---', 'date:o-W' => 'Settimanale', 'date:Y-m' => 'Mensile', 'date:Y-m-d' => 'Giornaliero', '_value' => '_value', 'field:Q41' => 'field:Q41'],
            ],
            (object) [
                'type' => 'Integer',
                'name' => 'chart.width',
                'col_size' => 4,
                'rules' => 'required',
            ],
            (object) [
                'type' => 'Integer',
                'name' => 'chart.height',
                'col_size' => 4,
                'rules' => 'required',
                'value' => '400',
            ],
            (object) [
                'type' => 'CheckboxBoolean',
                'name' => 'chart.show_box',
                'col_size' => 4,
            ],

            (object) [
                'type' => 'Select',
                // 'type' => 'String',
                'name' => 'chart.font_family',
                'comment' => null,
                'col_size' => 4,
                'options' => [
                    10 => 'FF_COURIER',
                    11 => 'FF_VERDANA',
                    12 => 'FF_TIMES',
                    14 => 'FF_COMIC',
                    15 => 'FF_ARIAL',
                    16 => 'FF_GEORGIA',
                    17 => 'FF_TREBUCHE',
                    // 18 => 'FF_COLIBRI',
                ],
            ],

            (object) [
                'type' => 'Select',
                'name' => 'chart.font_style',
                'comment' => null,
                'col_size' => 4,

                'options' => [
                    9001 => 'FS_NORMAL',
                    9002 => 'FS_BOLD',
                    9003 => 'FS_ITALIC',
                    // 9004 => 'FS_BOLDIT',
                    9004 => 'FS_BOLDITALIC',
                ],
            ],

            (object) [
                'type' => 'Select',
                'name' => 'chart.font_size',
                'comment' => null,
                'col_size' => 4,

                'options' => [
                    '8' => '8',
                    '10' => '10',
                    '12' => '12',
                    '14' => '14',
                    '16' => '16',
                    '18' => '18',
                ],
            ],

            (object) [
                'type' => 'SelectColor',
                'name' => 'chart.color',
                'comment' => null,
                'col_size' => 4,
            ],

            (object) [
                'type' => 'ListColor',
                'name' => 'chart.list_color',
                'comment' => null,
                'col_size' => 4,
            ],

            (object) [
                'type' => 'Select',
                'name' => 'chart.transparency',
                'comment' => null,
                'col_size' => 4,
                // 'rules' => 'required',
                'options' => $this->optionsTransparency(),
            ],

            (object) [
                'type' => 'Integer',
                'name' => 'chart.y_grace',
                'comment' => null,
                'col_size' => 4,
            ],
            (object) [
                'type' => 'CheckboxBoolean',
                'name' => 'chart.yaxis_hide',
                'comment' => null,
                'col_size' => 4,
            ],
            (object) [
                'type' => 'Integer',
                'name' => 'chart.x_label_angle',
                'comment' => null,
                'col_size' => 4,
            ],

            (object) [
                'type' => 'Integer',
                'name' => 'chart.x_label_margin',
                'comment' => null,
                'col_size' => 4,
            ],

            (object) [
                'type' => 'Integer',
                'name' => 'chart.plot_perc_width',
                'comment' => null,
                'col_size' => 4,
            ],

            (object) [
                'type' => 'CheckboxBoolean',
                'name' => 'chart.plot_value_show',
                'comment' => null,
                'col_size' => 4,
            ],
            (object) [
                'type' => 'Select',
                'name' => 'chart.plot_value_format',
                'comment' => null,
                'col_size' => 4,
                'options' => $this->optionsUrlDecode(),
            ],
            (object) [
                'type' => 'CheckboxBoolean',
                'name' => 'chart.plot_value_pos',
                'comment' => null,
                'col_size' => 4,
            ],
            (object) [
                'type' => 'SelectColor',
                'name' => 'chart.plot_value_color',
                'comment' => null,
                'col_size' => 4,
            ],
        ];
    }

    public function optionsUrlDecode(): array {
        return [
            1 => 'percentuale',
            2 => '2 cifre decimali',
            3 => '0 cifre decimali',
        ];
    }

    public function pdfStyleFields(): array {
        return [
            /*
            (object) [
                'type' => 'Select',
                //'type' => 'String',
                'name' => 'pdfStyle.font_family',
                'comment' => null,
                'col_size' => 4,

                'options' => [
                    'FF_ARIAL' => 'FF_ARIAL',
                    'FF_TIMES' => 'FF_TIMES',
                    'FF_COURIER' => 'FF_COURIER',
                    'FF_VERDANA' => 'FF_VERDANA',
                    'FF_BOOK' => 'FF_BOOK',
                    'FF_HANDWRT' => 'FF_HANDWRT',
                    'FF_COMIC' => 'FF_COMIC',
                ],
            ],

            (object) [
                'type' => 'Select',
                'name' => 'pdfStyle.font_style',
                'comment' => null,
                'col_size' => 4,

                'options' => [
                    'FS_NORMAL' => 'FS_NORMAL',
                    'FS_BOLD' => 'FS_BOLD',
                    'FS_ITALIC' => 'FS_ITALIC',
                    'FS_BOLDITALIC' => 'FS_BOLDITALIC',
                ],
            ],
            */

            (object) [
                'type' => 'Select',
                'name' => 'pdfStyle.font_size',
                'comment' => null,
                'col_size' => 4,
                // 'value' => 12,

                'options' => [
                    '8' => '8',
                    '10' => '10',
                    '12' => '12',
                    '14' => '14',
                    '16' => '16',
                    '18' => '18',
                    '20' => '20',
                    '22' => '22',
                ],
            ],

            (object) [
                'type' => 'Select',
                'name' => 'pdfStyle.font_size_question',
                'comment' => null,
                'col_size' => 4,
                // 'value' => 12,

                'options' => [
                    '100' => '100',
                    '110' => '110',
                    '120' => '120',
                    '130' => '130',
                    '140' => '140',
                    '150' => '150',
                    '160' => '160',
                ],
            ],

            (object) [
                'type' => 'ListColor',
                'name' => 'pdfStyle.color',
                'comment' => null,
                'col_size' => 4,
            ],

            (object) [
                'type' => 'Integer',
                'name' => 'pdfStyle.backtop',
                'comment' => null,
                // 'value' => 35,
                'default' => 35,
                'col_size' => 4,
            ],
            (object) [
                'type' => 'Integer',
                'name' => 'pdfStyle.backbottom',
                'comment' => null,
                'default' => 14,
                'col_size' => 4,
            ],
            (object) [
                'type' => 'Integer',
                'name' => 'pdfStyle.backleft',
                'comment' => null,
                'default' => 2,
                'col_size' => 4,
            ],
            (object) [
                'type' => 'Integer',
                'name' => 'pdfStyle.backright',
                'comment' => null,
                'default' => 2,
                'col_size' => 4,
            ],
            /*
            (object) [
                'type' => 'Integer',
                'name' => 'chart.x_label_angle',
                'comment' => null,
                'col_size' => 4,
            ],
            */
        ];
    }

    public function optionsTransparency(): array {
        // 1 è totalmente invisibile
        // 0 è senza trasparenza
        $tmp = [
            '0.0' => '0%',
            '0.1' => '10%',
            '0.2' => '20%',
            '0.3' => '30%',
            '0.4' => '40%',
            '0.5' => '50%',
            '0.6' => '60%',
            '0.7' => '70%',
            '0.8' => '80%',
            '0.9' => '90%',
            '1.0' => '100%',
        ];

        return $tmp;
    }
}
