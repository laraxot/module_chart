<?php

declare(strict_types=1);

namespace Modules\Chart\Actions;

use Amenadiel\JpGraph\Graph\Graph;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Modules\Chart\Datas\AnswerData;
use Modules\Chart\Datas\ChartData;
use Spatie\LaravelData\DataCollection;
use Spatie\QueueableAction\QueueableAction;

class GetJpGraphImgAction {
    use QueueableAction;

    /**
     * Undocumented function.
     *
     * @param DataCollection<AnswerData> $answers
     */
    public function execute(DataCollection $answers, ChartData $chart): string {
        if (Str::startsWith($chart->type, 'mixed')) {
            $parz = \array_slice(explode(':', $chart->type), 1);
            $parz = implode('|', $parz);
            // $res = $this->mixed(...$parz);
            $class = __NAMESPACE__.'\JpGraph\\MixedAction';
            $graph = app($class)->execute($parz, $answers, $chart);
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

    public function save(string $filename, Graph $graph) {
        if (File::exists(public_path($filename))) {
            File::delete(public_path($filename));
        }

        /*
        if (\count($this->imgs) > 0) {

            //https://github.com/Intervention/image/issues/376

            $imgs = collect($this->imgs);
            $width = $imgs->sum('width');
            $height = $imgs->max('height');
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
            $img_canvas->save(public_path($this->filename), 100);
        } else {
            try {
                $this->graph->Stroke(public_path($this->filename));
            } catch (\Exception $e) {
                dddx([$e->getMessage(), $e->getFile(), $e->getLine(), $e]);
            }
        }
        */

        try {
            $graph->Stroke(public_path($filename));
        } catch (\Exception $e) {
            dddx([$e->getMessage(), $e->getFile(), $e->getLine(), $e]);
        }
    }
}
