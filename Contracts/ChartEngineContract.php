<?php

declare(strict_types=1);

namespace Modules\Chart\Contracts;

use Spatie\LaravelData\DataCollection;

/**
 * Undocumented interface.
 *
 * @property array $vars
 */
interface ChartEngineContract {
    public function setData(DataCollection $data): self;

    public function setWidthHeight(int $width, int $height): self;

    public function setColor(string $color): self;

    public function setFont(string $family, string $style, int $size): self;

    public function mergeVars(array $vars): self;

    public function getVars(): array;

    public function setType(string $type): self;

    public function build(): self;

    public function save(string $filename): self;

    // public function horizontalLine(float $y, string $string): self;

    // public function mixed(string $id): self;
}
