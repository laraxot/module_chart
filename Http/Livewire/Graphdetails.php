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
class Graphdetails extends Component {
    public string $type;
    public string $url;
    public string $graph_id;
    public array $colors = [];
    public array $config = [];
    public int $num = 1;

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
        $view = 'chart::livewire.graphdetails.'.$this->type;

            $request = Request::create($this->url, "GET");
            $response = app()->handle($request);

            $tmp= json_decode($response->getContent(), true);
            if ($tmp != null) {
                $this->config = $tmp;
                $this->num = count($this->config);
            }else{
                Log::error("fetch data error for $this->graph_id");
            }
        return view($view, []);
    }
}
