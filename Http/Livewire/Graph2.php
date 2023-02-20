<?php

declare(strict_types=1);

namespace Modules\Chart\Http\Livewire;

use Auth;
use Illuminate\Contracts\Support\Renderable;
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
        $this->config =[];
        $user = Auth::user();
        dddx("ciao");
        if (Auth::check() && null != $user) {
            $this->url = url_queries(['api_token' => $user->api_token], $url);
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
        if ( $this->readyToLoadGraph) {
            $request = Request::create($this->url, "GET");
            $response = app()->handle($request);

            $this->config = json_decode($response->getContent());
        }
        $view_params = ["config"=> json_encode($this->config)];
        return view($view, $view_params);
    }
}
