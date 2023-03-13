<?php

declare(strict_types=1);

namespace Modules\Chart\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use Modules\Cms\Actions\GetViewAction;
use Illuminate\Contracts\Support\Renderable;

// use Modules\Cms\Services\PanelService;

/**
 * Class Chart.
 */
class Graph extends Component {
    public string $tpl;
    public string $url;
    public string $graph_id;
    public array $colors = [];
    public string $type;

    public function __construct(string $id, string $url, string $type, string $tpl = 'graph') {
        $this->graph_id = $id;
        $this->type = $type;
        $this->url = '#';
        $user = Auth::user();
        if (Auth::check() && null != $user) {
            $this->url = url_queries(['api_token' => $user->api_token], $url);
        }
        $this->tpl = $tpl;
        $colors = config('graph.colors', []);
        if (! is_array($colors)) {
            throw new \Exception('['.__LINE__.']['.__FILE__.']');
        }
        $this->colors = $colors;
    }

    public function render(): Renderable {
        /**
         * @phpstan-var view-string
         */
        // $view = 'chart::components.graph.'.$this->type;
        $view = app(GetViewAction::class)->execute($this->tpl);

        $view_params = [];

        return view($view, $view_params);
    }
}
