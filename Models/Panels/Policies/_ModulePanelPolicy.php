<?php

declare(strict_types=1);

namespace Modules\Chart\Models\Panels\Policies;

use Modules\Cms\Contracts\PanelContract;
use Modules\Cms\Models\Panels\Policies\XotBasePanelPolicy;
use Modules\Xot\Contracts\UserContract;

/**
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
class _ModulePanelPolicy extends XotBasePanelPolicy {
    public function test(UserContract $user, PanelContract $panel): bool {
        // $user is not used
        // $panel is not used
        return true;
    }

    public function choosePubTheme(UserContract $user, PanelContract $panel): bool {
        return true;
    }

    public function activatePubTheme(UserContract $user, PanelContract $panel): bool {
        return true;
    }

    public function chooseAdmTheme(UserContract $user, PanelContract $panel): bool {
        return true;
    }

    public function activateAdmTheme(UserContract $user, PanelContract $panel): bool {
        return true;
    }

    public function chooseIcons(UserContract $user, PanelContract $panel): bool {
        return true;
    }

    public function showAllIcons(UserContract $user, PanelContract $panel): bool {
        return true;
    }

    public function manageLangModule(UserContract $user, PanelContract $panel): bool {
        return true;
    }

    public function testVideo(UserContract $user, PanelContract $panel): bool {
        return true;
    }

    public function testVideoEditor(UserContract $user, PanelContract $panel): bool {
        return true;
    }

    public function testContentSelectionAndHighlighting(UserContract $user, PanelContract $panel): bool {
        return true;
    }

    public function TestSelectHighlight(UserContract $user, PanelContract $panel): bool {
        return true;
    }

    public function testSlider(UserContract $user, PanelContract $panel): bool {
        return true;
    }

    public function populateVideo(UserContract $user, PanelContract $panel): bool {
        return true;
    }
}
