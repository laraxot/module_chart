<?php

declare(strict_types=1);

/*
 * This file is inspired by Builder from Laravel ChartJS - Brian Faust
 * @link https://github.com/fxcosta/laravel-chartjs/blob/master/src/Builder.php
 */

namespace Modules\Chart\Services;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Arr;

class ChartJsBuilder {
    private static ?self $_instance = null;

    /**
     * Undocumented function.
     */
    public static function getInstance(): self {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Undocumented function.
     */
    public static function make(): self {
        return static::getInstance();
    }

    private array $charts = [];

    private string $name;

    /**
     * Undocumented variable.
     *
     * @var array<string, array<string,null>|string>
     */
    private array $defaults = [
        'datasets' => [],
        'labels' => [],
        'type' => 'line',
        'options' => [],
        'size' => ['width' => null, 'height' => null],
    ];

    /**
     * Undocumented variable.
     *
     * @var array<string>
     */
    private array $types = [
        'bar',
        'horizontalBar',
        'bubble',
        'scatter',
        'doughnut',
        'line',
        'pie',
        'polarArea',
        'radar',
    ];

    public function name(string $name): self {
        $this->name = $name;
        $this->charts[$name] = $this->defaults;

        return $this;
    }

    /**
     * @param mixed $element
     */
    public function element($element): self {
        return $this->set('element', $element);
    }

    public function labels(array $labels): self {
        return $this->set('labels', $labels);
    }

    public function datasets(array $datasets): self {
        return $this->set('datasets', $datasets);
    }

    public function type(string $type): self {
        if (! \in_array($type, $this->types, true)) {
            throw new \InvalidArgumentException('Invalid Chart type.');
        }

        return $this->set('type', $type);
    }

    public function size(array $size): self {
        return $this->set('size', $size);
    }

    public function options(array $options): self {
        foreach ($options as $key => $value) {
            $this->set('options.'.$key, $value);
        }

        return $this;
    }

    public function optionsRaw(string $optionsRaw): self {
        /*if (is_array($optionsRaw)) {
            $this->set('optionsRaw', json_encode($optionsRaw, true));
            return $this;
        }
        */
        $this->set('optionsRaw', $optionsRaw);

        return $this;
    }

    public function render(): Renderable {
        $chart = $this->charts[$this->name];

        /**
         * @phpstan-var view-string
         */
        $view = 'chart::chartjs.template';
        $optionsRaw = isset($chart['optionsRaw']) ? $chart['optionsRaw'] : '';
        $options = isset($chart['options']) ? $chart['options'] : [];
        if ('' === $optionsRaw) {
            $optionsRaw = json_encode($options, JSON_FORCE_OBJECT);
            // $optionsRaw=str_replace(':{"0":{',':{',$optionsRaw);
        }

        $view_params = [
            'view' => $view,
            'datasets' => $chart['datasets'],
            'element' => $this->name,
            'labels' => $chart['labels'],
            'optionsRaw' => $optionsRaw,
            'type' => $chart['type'],
            'size' => $chart['size'],
        ];

        return view()->make($view, $view_params);
    }

    /**
    private function get(string $key) {
        return Arr::get($this->charts[$this->name], $key);
    }
     * @param mixed $value
     *
     * @return mixed
     *               Method Modules\Chart\Services\ChartJsBuilder::get() is unused
     */

    /**
     * @param mixed $value
     */
    private function set(string $key, $value): self {
        Arr::set($this->charts[$this->name], $key, $value);

        return $this;
    }
}
