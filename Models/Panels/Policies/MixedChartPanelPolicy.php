<?php
namespace Modules\Chart\Models\Panels\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\LU\Models\User as User;
use Modules\Chart\Models\Panels\Policies\MixedChartPanelPolicy as Panel;

use Modules\Xot\Models\Panels\Policies\XotBasePanelPolicy;

class MixedChartPanelPolicy extends XotBasePanelPolicy {
}
