<?php

declare(strict_types=1);

namespace Modules\Chart\Datas;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class AnswersData extends Data {
    public string $title = 'no_set';
    /**
     *  @var DataCollection<AnswerData>
     */
    public DataCollection $answers;
}
