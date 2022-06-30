<?php

declare(strict_types=1);

namespace Modules\Chart\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;
use Modules\Xot\Services\BladeService;

class ChartServiceProvider extends XotBaseServiceProvider {
    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    public string $module_name = 'chart';

    public function bootCallback(): void {
        BladeService::registerComponents($this->module_dir.'/../View/Components', 'Modules\\Chart');

        if(class_exists(\ConsoleTVs\Charts\Registrar::class)){
            app(\ConsoleTVs\Charts\Registrar::class)->register([
                \Modules\LU\Charts\DailyUsersChart::class,
                \Modules\Chart\Charts\ExampleBarChart::class,
            ]);
        }

    }

    public function registerCallback(): void {
    }
}
