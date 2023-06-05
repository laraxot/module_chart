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
    public ?string $key;
    // public ?array $sub_labels;
    // public $values; NO ! NO ! NO !
<<<<<<< HEAD
<<<<<<< HEAD
    public float|array|string $avg = 0;
=======
    public float|array $avg = 0;
>>>>>>> 7ed4080 (.)
=======
    public float|array|string $avg = 0;
>>>>>>> d8e62bc (.)
    // public int $tot = 1;
    // public int $tot_nulled = 0;
    public ?string $title;
    public ?string $subtitle;
}
