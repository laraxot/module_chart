<?php

declare(strict_types=1);

namespace Modules\Chart\Datas;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class AnswerMultiData extends Data {
    public string $key;
    public DataCollection $answer_data;
}
