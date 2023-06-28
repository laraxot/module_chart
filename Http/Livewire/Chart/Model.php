<?php
/**
 * @see https://dev.to/nasrulhazim/livewire-chartjs-3ch5
 */

declare(strict_types=1);

namespace Modules\Chart\Http\Livewire\Chart;

use Illuminate\Contracts\Support\Renderable;
use Livewire\Component;
use Modules\Cms\Actions\GetViewAction;
use Modules\Xot\Actions\GetModelTypeByModelAction;
use Modules\Xot\Contracts\ModelContract;

// use Modules\Cms\Services\PanelService;
// TODO:
/**
 * Class Chart.
 */
class Model extends Component
{
    public string $tpl;
    public string $model_type;
    public string $model_id;

    public function mount(ModelContract $model, string $tpl = 'v1')
    {
        $this->model_type = app(GetModelTypeByModelAction::class)->execute($model);
        $this->model_id = strval($model->getKey());
        $this->tpl = $tpl;
    }

    public function render(): Renderable
    {
        $labels = [
            'a' => 'a',
            'b' => 'b',
        ];
        /**
         * @phpstan-var view-string
         */
        $view = app(GetViewAction::class)->execute($this->tpl);
        $view_params = [
            'view' => $view,
            'labels' => $labels,
        ];

        return view($view, $view_params);
    }
}
