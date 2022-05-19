<?php

declare(strict_types=1);

namespace Modules\Chart\Services\ChartEngines\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Undocumented trait.
 */
trait ChartEngineTrait {
    /**
     * Undocumented function.
     */
    public function setWidthHeight(int $width, int $height): self {
        $this->width = $width;
        $this->height = $height;

        return $this;
    }

    public function mergeVars(array $vars): self {
        $this->vars = array_merge($this->vars, $vars);

        return $this;
    }

    public function getVars(): array {
        return $this->vars;
    }

    public function setData(Collection $data): self {
        $this->data = $data;

        return $this;
    }

    public function setType(string $type): self {
        $this->type = $type;

        return $this;
    }

    public function setColor(string $color): self {
        $this->color = $color;

        return $this;
    }

    public function setFont(string $family, string $style, int $size): self {
        $this->family = $family;
        $this->style = $style;
        $this->size = $size;

        return $this;
    }

    /**
     * Undocumented function.
     */
    public function build(): self {
        $this->setWidthHeight((int) $this->vars['width'], (int) $this->vars['height']);
        // dddx($this->vars['type']);

        if (Str::startsWith($this->vars['type'], 'mixed')) {
            $parz = \array_slice(explode(':', $this->vars['type']), 1);

            $res = $this->mixed(...$parz);
        } else {
            $res = $this->{$this->vars['type']}();
        }
        if (! isset($this->vars['extras'])) {
            $this->vars['extras'] = [];
        }
        $extras = $this->vars['extras'];
        foreach ($extras as $extra) {
            $var = get_object_vars($extra);
            unset($var['type']);
            $var = array_values($var);
            $res = $this->{$extra->type}(...$var);
        }

        // $res1 = $this->horizontalLine(70, 'riferimento');

        return $this;
    }
}