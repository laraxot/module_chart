<?php

declare(strict_types=1);

namespace Modules\Chart\Datas;

use Spatie\LaravelData\Data;

class AnswerData extends Data {
    public ?string $label;
    public int $gid = 0;
    public float|array $value = 0;
    public float|array|string $value1 = '';
    public ?string $_key;
    // public ?array $sub_labels;
    // public $values; NO ! NO ! NO !
}