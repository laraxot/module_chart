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
    public array $config = [];
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
        $this->config = json_decode('{
  "type": "bar",
  "data": {
            "labels": [
                ""
            ],
    "datasets": [

            ]
  },
  "options": {
            "indexAxis": "",
    "plugins": {
                "title": {
                    "display": true,
        "text": "",
        "font": {
                        "size": 20
        }
      },
      "subtitle": {
                    "display": true,
        "text": "",
        "font": {
                        "size": 15
        }
      }
    }
  }
}', true);
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

            $tmp= json_decode($response->getContent(), true);
            if ($tmp != null) {
                $this->config = $tmp;
                $this->emit('updateChart'.$this->graph_id, $this->config

                );
            }else{
                Log::error("fetch data error for $this->graph_id");
            }

         /*   $this->emit('updateChart'.$this->graph_id, [
                    "data"=>$this->config['data'],
                    "type"=>$this->config['type'],
                    "options"=>$this->config['options'],
            ]

            );*/



        }
        $view_params = ["load" => $this->readyToLoadGraph];
        return view($view, $view_params);
    }
}
