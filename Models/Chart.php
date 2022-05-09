<?php

declare(strict_types=1);

namespace Modules\Chart\Models;

use ErrorException;
use Modules\Xot\Services\PanelService;

class Chart extends BaseModel {
    /**
     * Undocumented variable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'post_id', 'post_type',
        'type',
        'width', 'height',
        'color',
        'bg_color',
        'font_family',
        'font_size',
        'font_style',
        'y_grace',
        'yaxis_hide',
        'list_color',
        'grace',
        'x_label_angle',
        'show_box',
        'x_label_margin',
        'plot_perc_width',
        'plot_value_show',
        'plot_value_format',
        'plot_value_pos',
        'plot_value_color',
        'group_by',
        'sort_by',
    ];

    /**
     * Undocumented variable.
     *
     * @var array
     */
    protected $attributes = [
        'list_color' => '#d60021',
        'color' => '#d60021',
        'font_family' => 15,
        'font_style' => 9002,
        'font_size' => 12,
        'x_label_angle' => 0,
        'show_box' => false,
        'x_label_margin' => 10,
        'plot_perc_width' => 90,
        'plot_value_show' => 1,
        'plot_value_pos' => 1,
        'plot_value_color' => '#000000',
    ];

    /**
     * @return int|string|null
     */
    public function getParentStyle(string $name) {
        $panel = PanelService::make()->getRequestPanel();
        $parent = $panel->getParent()->row;
        if (! method_exists($parent, 'chart')) {
            return $this->attributes[$name] ?? null;
        }
        //dddx([$name, $panel->row, $parent->{$name}]);
        $value = $parent->chart->{$name};
        $this->{$name} = $value;
        $this->save();

        return $value;
    }

    /**
     * @return int|string|null
     */
    public function getPanelRow(string $parent_field, string $my_field) {
        $panel = PanelService::make()->getRequestPanel();
        if (! \is_object($panel)) {
            return null;
        }
        $panel_row = $panel->row;

        try {
            $value = $panel_row->{$parent_field};
            $this->{$my_field} = $value;
            $this->save();
        } catch (ErrorException $e) {
            $msg = [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'panel_row_class' => \get_class($panel_row),
            ];
            //echo '<pre>'.print_r($msg,true).'</pre>';
            $value = null;
        }

        return $value;
    }

    //---------- Mutator
    public function getColorAttribute(?string $value): ?string {
        if (null !== $value) {
            return $value;
        }

        return $this->getParentStyle('color');
    }

    public function getListColorAttribute(?string $value): ?string {
        if (null !== $value) {
            return $value;
        }

        return $this->getParentStyle('list_color');
    }

    public function getXLabelAngleAttribute(?string $value): ?string {
        if (null !== $value) {
            return $value;
        }
        /*
        $this->x_label_angle = 0;
        $this->save();
        $value = $this->x_label_angle;

        return $value;
*/
        return $this->getParentStyle('x_label_angle');
    }

    public function getFontFamilyAttribute(?int $value): int {
        if (null !== $value && 0 !== $value) {
            return (int) $value;
        }

        return $this->getParentStyle('font_family');
    }

    public function getFontStyleAttribute(?int $value): int {
        if (null !== $value && 0 !== $value) {
            return (int) $value;
        }

        return $this->getParentStyle('font_style');
    }

    public function getFontSizeAttribute(?int $value): int {
        if (null !== $value && 0 !== $value) {
            return (int) $value;
        }

        return $this->getParentStyle('font_size');
    }

    public function getTypeAttribute(?string $value): ?string {
        if (null !== $value) {
            return $value;
        }
        if (isset($this->attributes['type'])) {
            return $this->attributes['type'];
        }

        return $this->getPanelRow('chart_type', 'type');
    }

    public function getWidthAttribute(?string $value): ?int {
        if (null !== $value && 0 !== $value) {
            return (int) $value;
        }

        return (int) $this->getPanelRow('width', 'width');
    }

    public function getHeightAttribute(?string $value): ?int {
        if (null !== $value && 0 !== $value) {
            return (int) $value;
        }

        return (int) $this->getPanelRow('height', 'height');
    }
}
