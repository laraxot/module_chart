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
 * Class ChartJsAction.
 *
 * https://codepen.io/jordanwillis/pen/peqVOM
 */
class ChartJsAction extends XotBasePanelAction {
    public bool $onItem = true;
    public string $icon = '<i class="fas fa-vial"></i>';

    /**
     * @return mixed
     */
    public function handle() {
        $view = $this->panel->getView();
        $view_params = [
            'view' => $view,
        ];

        return view()->make($view, $view_params);
    }

    public function postHandle() {
    }
}
