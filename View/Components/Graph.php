<?php

declare(strict_types=1);

namespace Modules\Chart\View\Components;

use Exception;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;

// use Modules\Cms\Services\PanelService;

/**
 * Class Chart.
 */
class Graph extends Component {
    public string $type;
    public string $url;
    public string $graph_id;
    public array $colors = [];

    public function __construct(string $id, string $url, string $type = 'graph') {
        $this->graph_id = $id;
        $this->url = '#';
        $user=Auth::user();
        if (Auth::check() && $user!=null) {
            $this->url = url_queries(['api_token' => $user->api_token], $url);
        }
        $this->type = $type;
        $colors=config('graph.colors', []);
        if(!is_array($colors)){
            throw new Exception('['.__LINE__.']['.__FILE__.']');
        }
        $this->colors = $colors;
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
