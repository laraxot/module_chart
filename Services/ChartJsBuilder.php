<?php

/*
 * This file is inspired by Builder from Laravel ChartJS - Brian Faust
 * @link https://github.com/fxcosta/laravel-chartjs/blob/master/src/Builder.php
 */

namespace Modules\Chart\Services;

use Illuminate\Support\Arr;
use Illuminate\Contracts\Support\Renderable;

class ChartJsBuilder {

    private static ?self $_instance = null;

    /**
     * Undocumented function
     *
     * @return self
     */
    public static function getInstance(): self {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Undocumented function
     *
     * @return self
     */
    public static function make(): self {
        return static::getInstance();
    }
    /**
     * @var array
     */
    private array $charts = [];

    /**
     * @var string
     */
    private string $name;

    /**
     * @var array
     */
    private array $defaults = [
        'datasets' => [],
        'labels'   => [],
        'type'     => 'line',
        'options'  => [],
        'size'     => ['width' => null, 'height' => null]
    ];

    /**
     * @var array
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
        'radar'
    ];

    /**
     * @param $name
     *
     * @return $this|Builder
     */
    public function name($name):self {
        $this->name          = $name;
        $this->charts[$name] = $this->defaults;
        return $this;
    }

    /**
     * @param $element
     *
     * @return Builder
     */
    public function element($element):self {
        return $this->set('element', $element);
    }

    /**
     * @param array $labels
     *
     * @return Builder
     */
    public function labels(array $labels):self {
        return $this->set('labels', $labels);
    }

    /**
     * @param array $datasets
     *
     * @return Builder
     */
    public function datasets(array $datasets):self {
        return $this->set('datasets', $datasets);
    }

    /**
     * @param $type
     *
     * @return Builder
     */
    public function type(string $type):self  {
        if (!in_array($type, $this->types)) {
            throw new \InvalidArgumentException('Invalid Chart type.');
        }
        return $this->set('type', $type);
    }

    /**
     * @param array $size
     *
     * @return Builder
     */
    public function size(array $size):self {
        return $this->set('size', $size);
    }

    /**
     * @param array $options
     *
     * @return $this|Builder
     */
    public function options(array $options)  {
        foreach ($options as $key => $value) {
            $this->set('options.' . $key, $value);
        }

        return $this;
    }

    /**
     *
     * @param string|array $optionsRaw
     * @return \self
     */
    public function optionsRaw(string $optionsRaw):self {
        /*if (is_array($optionsRaw)) {
            $this->set('optionsRaw', json_encode($optionsRaw, true));
            return $this;
        }
        */
        $this->set('optionsRaw', $optionsRaw);
        return $this;
    }

    /**
     * @return mixed
     */
    public function render():Renderable {
        $chart = $this->charts[$this->name];

        $view='chart::chartjs.template';
        $optionsRaw=isset($chart['optionsRaw']) ? $chart['optionsRaw'] : '';
        $options=isset($chart['options']) ? $chart['options'] : [];
        if($optionsRaw==''){
            $optionsRaw=json_encode($options,JSON_FORCE_OBJECT);
            //$optionsRaw=str_replace(':{"0":{',':{',$optionsRaw);
        }

        $view_params=[
            'view'=>$view,
            'datasets'=> $chart['datasets'],
            'element'=>$this->name,
            'labels'=>$chart['labels'],
            'optionsRaw'=>$optionsRaw,
            'type'=>$chart['type'],
            'size'=>$chart['size'],
        ];


        return view()->make($view,$view_params);

    }

    /**
     * @param $key
     *
     * @return mixed
     */
    private function get(string $key) {
        return Arr::get($this->charts[$this->name], $key);
    }

    /**
     * @param $key
     * @param $value
     *
     * @return $this|Builder
     */
    private function set(string $key, $value):self {
        Arr::set($this->charts[$this->name], $key, $value);

        return $this;
    }
}
