<?php
/**
 * --.
 */
declare(strict_types=1);

namespace Modules\Chart\Models\Panels\Actions;

// -------- services --------

use Modules\Cms\Models\Panels\Actions\XotBasePanelAction;

// -------- bases -----------

/**
 * Class AmChartAction.
 *
 * https://www.amcharts.com/demos/
 */
class AmChartAction extends XotBasePanelAction {
    public bool $onItem = true;
    public string $icon = '<i class="fas fa-vial"></i>';

    /**
     * @return mixed
     */
    public function handle() {
        $view = $this->panel->getView();
        $view_params = [
            // 'chart_axis' => $counter,
            'view' => $view,
        ];

        return view()->make($view, $view_params);
    }

    /**
     * @return mixed
     */
    public function postHandle() {
    }
}
