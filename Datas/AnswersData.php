<?php

declare(strict_types=1);

namespace Modules\Chart\Datas;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class AnswersData extends Data {
    public int $tot = 0;
    public string $title = 'no_set';
    public string $footer = 'no_set';
    /**
     *  @var DataCollection<AnswerData>
     */
    public DataCollection $answers;
}
