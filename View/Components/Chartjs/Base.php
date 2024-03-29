<?php

declare(strict_types=1);

namespace Modules\Chart\View\Components\Chartjs;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

/**
 * Class Base.
 */
class Base extends Component {
    public string $type;
    public string $title;
    public array $labels;
    public array $data;
    public string $chartid;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $chartid, string $type, array $labels, array $data, string $title) {
        $this->type = $type;
        $this->labels = $labels;
        $this->data = $data;
        $this->chartid = $chartid;
        $this->title = $title;
        // dddx([$type, $labels, $data]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): Renderable {
        /**
         * @phpstan-var view-string
         */
        $view = 'chart::components.chartjs.'.$this->type;

        $view_params = [
            'view' => $view,
            'labels' => $this->labels,
            'data' => $this->data,
            'chartid' => $this->chartid,
            'title' => $this->title,
        ];

        return view($view, $view_params);
    }
}
