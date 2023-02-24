<?php

declare(strict_types=1);

namespace Modules\Chart\Http\Livewire;

use Auth;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Request;

// use Modules\Cms\Services\PanelService;
//TODO:
/**
 * Class Chart.
 */
class Graph2 extends Component {
    public string $type;
    public string $url;
    public string $graph_id;
    public array $colors = [];
    public $readyToLoadGraph = false;

    public function loadGraph(){
        $this->readyToLoadGraph = true;

    }
    public function mount(string $id, string $url, string $type = 'graph') {
        $this->graph_id = $id;
        $this->url = '#';
        $user = Auth::user();
        if (Auth::check() && null != $user) {
            $this->url = url_queries(['api_token' => $user->api_token], $url."?id=".$this->graph_id);
           // dddx($this->config);
        }
        $this->type = $type;
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
        $view = 'chart::livewire.graph2.'.$this->type;

        return view($view, []);
    }
}
