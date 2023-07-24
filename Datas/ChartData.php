<?php

declare(strict_types=1);

namespace Modules\Chart\Datas;

use Illuminate\Support\Str;
use Spatie\Color\Hex;
use Spatie\LaravelData\Data;

class ChartData extends Data
{
    public string $type; // horizbar1, pie ecc
    public float $max;
    public float $min;
    public int $width;
    public int $height;
    public ?string $title;
    public ?string $subtitle;
    public string $list_color;
    // public string $color; // #000000 // non si deve più usare, sostituito da list_color
    public ?string $bg_color; // #000000
    public string $font_family;
    public string $font_size;
    public string $font_style;
    public ?int $y_grace;
    public ?int $yaxis_hide;
    public string $x_label_angle;
    public int $show_box;
    public int $x_label_margin;
    public int $plot_perc_width;
    public int $plot_value_show;
    public ?string $plot_value_format;
    public ?string $plot_value_color = '#000000';
    public string $transparency;
    public ?string $engine_type;
    public ?string $footer;
    public int $plot_value_pos = 0;
    public ?string $answer_value_no_txt;
    public ?string $answer_value_txt;
    // public ?string $legend;
    public ?array $legend;
    public ?array $sublabels;
    public ?float $avg;

    public function getColors()
    {
        return explode(',', $this->list_color);
    }

    public function getColorsRgba(float $alpha = 1): array
    {
        $colors = $this->getColors();

        return collect($colors)->map(function ($item) use ($alpha) {
            if (! Str::startsWith($item, '#')) {
                return $item;
            }
            $hex = Hex::fromString($item);

            return (string) $hex->toRgba($alpha);
        })->all();
    }


    public function getActionClass(): string
    {
        $type=$this->type;
        $engine = 'JpGraph\V1';

        $action = Str::studly($type).'Action';

        $actionClass = '\Modules\Chart\Actions\\'.$engine.'\\'.$action;
        return $actionClass;
    }
}
