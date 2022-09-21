<?php

declare(strict_types=1);

namespace Modules\Chart\View\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

// use Modules\Xot\Services\PanelService;

/**
 * Class Chart.
 */
class Graph extends Component {
    public string $type;
    public string $url;
    public string $graph_id;

    public function __construct(string $id, string $url, ?string $type = null) {
        $this->graph_id = $id;
        $this->url = $url;
        $this->type = $type ?? 'graph';
    }

    public function render(): Renderable {
        /**
         * @phpstan-var view-string
         */
        $view = 'chart::components.graph.'.$this->type;

        $view_params = [];

        return view($view, $view_params);
    }
}