<?php

declare(strict_types=1);

namespace Modules\Chart\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Modules\Cms\Actions\GetViewAction;
use Illuminate\Contracts\Support\Renderable;
use function Safe\json_decode;

// use Modules\Cms\Services\PanelService;

/**
 * Class Chart.
 */
class Graphdetails extends Component {
    public string $tpl;
    public string $url;
    public string $graph_id;
    public array $colors = [];
    public array $config = [];
    public int $num = 1;

    /**
     * @return void
     */
    public function mount(string $id, string $url, string $tpl = 'graph') {
        $this->graph_id = $id;
        $this->url = '#';
        $user = \Auth::user();
        if (\Auth::check() && null != $user) {
            $this->url = url_queries(['api_token' => $user->api_token], $url.'?id='.$this->graph_id);
            // dddx($this->config);
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
        $view = app(GetViewAction::class)->execute($this->tpl);

        $request = \Request::create($this->url, 'GET');
        $response = app()->handle($request);

        $tmp = json_decode($response->getContent(), true);
        if (null != $tmp) {
            $this->config = $tmp;
            $this->num = count($this->config);
        } else {
            Log::error("fetch data error for $this->graph_id");
        }

        return view($view, []);
    }
}
