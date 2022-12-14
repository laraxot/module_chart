<?php

declare(strict_types=1);

namespace Modules\Chart\View\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

// use Modules\Xot\Services\PanelService;

/**
 * Class Chart.
 */
class Graph extends Component {
    public string $type;
    public string $url;
    public string $graph_id;

    public function __construct(string $id, string $url, ?string $type = 'graph') {
        $this->graph_id = $id;
        $this->url = '#';
        if (Auth::check()) {
            $this->url = url_queries(['api_token' => Auth::user()->api_token], $url);
        }
        $this->type = $type;
        $this->colors = config('graph.colors', []);
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
