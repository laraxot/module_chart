<?php
/**
 * --.
 */
declare(strict_types=1);

namespace Modules\Chart\Models\Panels\Actions;

// -------- services --------

use Modules\Cms\Models\Panels\Actions\XotBasePanelAction;
use Modules\UI\Services\ThemeService;

// -------- bases -----------

/**
 * Class TestAction.
 */
class TestAction extends XotBasePanelAction {
    public bool $onItem = true;
    public string $icon = '<i class="fas fa-vial"></i>';

    /**
     * @return mixed
     */
    public function handle() {
        $drivers = [
            'google_charts',
            'google_charts.v1',
            'highcharts',
            'apexcharts',
            'jpchart',
            'phpwkhtmltopdf',
        ];
        $i = request('i');

        $driver = isset($drivers[$i]) ? $drivers[$i] : null;

        //$view = ThemeService::getView();
$view = $this->panel->getView();

        $view_params = [
            'view' => $view,
            'drivers' => $drivers,
            'driver' => $driver,
        ];

        // return view($view, $view_params);
        // Parameter #1 $view of function view expects view-string|null, mixed given.
        // The custom 'view-string' type class. It's a subset of the string type. Every string that passes the
        // view()->exists($string) test is a valid view-string type.

        // if (view()->exists($view)) {
        return view($view, $view_params);
        // }

        // return 'not exists ['.$view.']';
    }
}
