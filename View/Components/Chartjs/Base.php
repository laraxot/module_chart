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

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $type) {
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): Renderable {
        $view = 'chart::components.chartjs.'.$this->type;

        $view_params = [
            'view' => $view,
        ];

        return view()->make($view, $view_params);
    }
}
