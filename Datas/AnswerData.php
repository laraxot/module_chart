<?php

declare(strict_types=1);

namespace Modules\Chart\Datas;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class AnswerData extends Data {
    public ?string $label;
    public int $gid = 0;
    public float|array $value;
    public float|array|string $value1 = '';
    public ?Collection $values;
    public ?string $_key;
}
