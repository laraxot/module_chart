<?php

declare(strict_types=1);

namespace Modules\Chart\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Chart\Models\Chart;

class ChartFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Chart::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        return [
            'id' => $this->faker->randomNumber(5, false),
            'post_id' => $this->faker->randomNumber(5, false),
            'post_type' => $this->faker->word,
            'type' => $this->faker->word,
            'width' => $this->faker->randomNumber(5, false),
            'height' => $this->faker->randomNumber(5, false),
            'color' => $this->faker->word,
            'bg_color' => $this->faker->word,
            'font_family' => $this->faker->randomNumber(5, false),
            'font_size' => $this->faker->randomNumber(5, false),
            'font_style' => $this->faker->randomNumber(5, false),
            'y_grace' => $this->faker->randomNumber(5, false),
            'yaxis_hide' => $this->faker->boolean,
            'list_color' => $this->faker->word,
            'grace' => $this->faker->word,
            'x_label_angle' => $this->faker->word,
            'show_box' => $this->faker->boolean,
            'x_label_margin' => $this->faker->randomNumber(5, false),
            'plot_perc_width' => $this->faker->randomNumber(5, false),
            'plot_value_show' => $this->faker->boolean,
            'plot_value_format' => $this->faker->word,
            'plot_value_pos' => $this->faker->boolean,
            'plot_value_color' => $this->faker->word,
            'group_by' => $this->faker->word,
            'sort_by' => $this->faker->word,
        ];
    }
}
