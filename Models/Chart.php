<?php

declare(strict_types=1);

namespace Modules\Chart\Models;

use ErrorException;
use Modules\Quaeris\Models\SurveyPdf;
use Modules\Xot\Services\PanelService;

/**
 * Modules\Chart\Models\Chart
 *
 * @property int $id
 * @property string|null $post_type
 * @property int|null $post_id
 * @property string|null $color
 * @property string|null $bg_color
 * @property int $font_family
 * @property int $font_style
 * @property int $font_size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property int|null $y_grace
 * @property int|null $yaxis_hide
 * @property string|null $list_color
 * @property string|null $x_label_angle
 * @property int|null $show_box
 * @property int|null $x_label_margin
 * @property int|null $width
 * @property int|null $height
 * @property string|null $type
 * @property int|null $plot_perc_width
 * @property int|null $plot_value_show
 * @property string|null $plot_value_format
 * @property int|null $plot_value_pos
 * @property string|null $plot_value_color
 * @property string|null $group_by
 * @property string|null $sort_by
 * @property string|null $lang
 * @property string|null $grace
 * @property string $transparency
 * @method static \Modules\Chart\Database\Factories\ChartFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Chart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Chart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Chart query()
 * @method static \Illuminate\Database\Eloquent\Builder|Chart whereBgColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chart whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chart whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chart whereFontFamily($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chart whereFontSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chart whereFontStyle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chart whereGrace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chart whereGroupBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chart whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chart whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chart whereListColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chart wherePlotPercWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chart wherePlotValueColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chart wherePlotValueFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chart wherePlotValuePos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chart wherePlotValueShow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chart wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chart wherePostType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chart whereShowBox($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chart whereSortBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chart whereTransparency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chart whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chart whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chart whereWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chart whereXLabelAngle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chart whereXLabelMargin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chart whereYGrace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chart whereYaxisHide($value)
 * @mixin \Eloquent
 */
class Chart extends BaseModel {
    /**
     * Undocumented variable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'id',
        'post_id',
        'post_type',
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
        'transparency',
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

        if (null == $panel) {
            return $this->attributes[$name] ?? null;
        }
        $parent = $panel->getParent();

        if (null == $parent) {
            return $this->attributes[$name] ?? null;
        }
        $parent = $parent->row;
        if (! method_exists($parent, 'chart')) {
            return $this->attributes[$name] ?? null;
        }
        // dddx([$name, $panel->row, $parent->{$name}]);
        // $value = $parent->chart->{$name};

        // if (! $parent instanceof SurveyPdf) { //outside Quae

        $value = $parent->chart->attributes[$name] ?? null;

        $this->{$name} = $value;
        $this->save();
        if (! is_string($value) && ! is_integer($value)) {
            return null;
        }

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
            // echo '<pre>'.print_r($msg,true).'</pre>';
            $value = null;
        }

        return $value;
    }

    // ---------- Getter
    public function getColorAttribute(?string $value): ?string {
        if (null !== $value) {
            // return $value;
        }

        return (string) $this->getParentStyle('color');
    }

    public function getListColorAttribute(?string $value): ?string {
        if (null !== $value) {
            return $value;
        }

        return (string) $this->getParentStyle('list_color');
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
        return (string) $this->getParentStyle('x_label_angle');
    }

    public function getFontFamilyAttribute(?int $value): int {
        if (null !== $value && 0 !== $value) {
            return (int) $value;
        }

        return (int) $this->getParentStyle('font_family');
    }

    public function getFontStyleAttribute(?int $value): int {
        if (null !== $value && 0 !== $value) {
            return (int) $value;
        }

        return (int) $this->getParentStyle('font_style');
    }

    public function getFontSizeAttribute(?int $value): int {
        if (null !== $value && 0 !== $value) {
            return (int) $value;
        }

        return (int) $this->getParentStyle('font_size');
    }

    public function getTypeAttribute(?string $value): ?string {
        if (null !== $value) {
            return $value;
        }
        if (isset($this->attributes['type'])) {
            return $this->attributes['type'];
        }

        return (string) $this->getPanelRow('chart_type', 'type');
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
