<?php

declare(strict_types=1);

namespace Modules\Chart\Actions;

use Amenadiel\JpGraph\Graph\Graph;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Modules\Chart\Datas\AnswerData;
use Modules\Chart\Datas\ChartData;
use Modules\Quaeris\Datas\QuestionData;
use Spatie\LaravelData\DataCollection;
use Spatie\QueueableAction\QueueableAction;

class GetJpGraphImgAction {
    use QueueableAction;

    /**
     * Undocumented function.
     *
     * @param DataCollection<AnswerData> $answers
     */
    public function execute(DataCollection $answers, ChartData $chart, ?QuestionData $question = null): string {
        if (Str::startsWith($chart->type, 'mixed')) {
            $parz = \array_slice(explode(':', $chart->type), 1);
            $parz = implode('|', $parz);
            // $res = $this->mixed(...$parz);
            $class = 'Modules\Quaeris\Actions\Question\\MixedAction';
            $graph = app($class)->execute($parz, $answers, $chart, $question);
        } else {
            // $res = $this->{$chart->type}();
            $class = __NAMESPACE__.'\JpGraph\\'.Str::studly($chart->type).'Action';
            $graph = app($class)->execute($answers, $chart);
        }
        $img = 'chart/'.Str::uuid().'.png';
        // $filename = public_path($img);

        $this->save($img, $graph);

        return $img;
    }

    /**
     * @var Graph|array<Graph>
     */
    public function save(string $filename, $graph) {
        if (File::exists(public_path($filename))) {
            File::delete(public_path($filename));
        }

        if (\count($graph) > 0) {
            // https://github.com/Intervention/image/issues/376

            $imgs = collect($graph);
            // dddx([get_class_methods($imgs->first()->img), $imgs->first()->img, get_class_methods($imgs->first())]);

            $width = $imgs->sum('width');
            $height = $imgs->max('height');
            dddx([$width, $height]);
            // 172    Parameter #1 $width of static method Intervention\Image\ImageManager::canvas()
            // expects int, mixed given.
            if (! is_numeric($width) || ! is_numeric($height)) {
                throw new \Exception('['.__LINE__.']['.class_basename(__CLASS__).']');
            }
            $width = (int) $width;
            $height = (int) $height;
            $img_canvas = Image::canvas($width, $height);
            $delta = 0;
            foreach ($imgs as $v) {
                $img = Image::make($v['img_path']);
                $img_canvas->insert($img, 'top-left ', $delta, 0);
                $delta += $img->width();
            }
            $img_canvas->save(public_path($filename), 100);
        } else {
            try {
                $graph->Stroke(public_path($filename));
            } catch (\Exception $e) {
                dddx([$e->getMessage(), $e->getFile(), $e->getLine(), $e]);
            }
        }

        try {
            $graph->Stroke(public_path($filename));
        } catch (\Exception $e) {
            dddx([$e->getMessage(), $e->getFile(), $e->getLine(), $e]);
        }
    }
}
