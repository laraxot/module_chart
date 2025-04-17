<?php

declare(strict_types=1);

namespace Modules\Chart\Actions;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Modules\Chart\Datas\AnswersChartData;
use Spatie\LaravelData\DataCollection;
use Spatie\QueueableAction\QueueableAction;

class GetImgByAnswersChartCollAction {
    use QueueableAction;

    /**
     * Undocumented function.
     * @param DataCollection<AnswersChartData>
     */
    public function execute(DataCollection $coll): string {
        $graphs = [];
        foreach ($coll as $v) {
            $class = 'Modules\Chart\Actions\JpGraph\\'.Str::studly($v->chart->type).'Action';
            /*if(false==str_contains($class,'PieAvgAction'))
            dddx($class);*/
            $graphs[] = app($class)->execute($v->answers, $v->chart);
        }
        $img = 'chart/'.Str::uuid().'.png';

        $this->save($img, collect($graphs));

        return $img;
    }

    /**
     * @var Collection<Graph>
     */
    public function save(string $filename, Collection $graphs) {
        if (File::exists(public_path($filename))) {
            File::delete(public_path($filename));
        }

        // https://github.com/Intervention/image/issues/376

        // dddx([get_class_methods($imgs->first()->img), $imgs->first()->img, get_class_methods($imgs->first())]);
        // dddx($imgs->last()->img->original_width);

        // dddx($graphs);
        $imgs = [];
        $width = 0;
        $height = 0;

        if ($graphs->isEmpty()) {
            throw new \Exception('$graphs is an empty collection ['.__LINE__.']['.class_basename(__CLASS__).']');
        }
        // $graphs = $graphs->shuffle();
        foreach ($graphs as $graph) {
            $filename1 = 'chart/'.Str::uuid().'.png';
            // dddx($graph);
            // $graph->SetScale("textlin",0,65);


            $graph->Stroke(public_path($filename1));

            $img = Image::make(public_path($filename1));
            $imgs[] = $img;
            $width += $img->width();
            $height = max($height, $img->height());

        }
        // $imgs = collect($imgs);
        // dddx
        // $width = $imgs->sum('width');
        // $height = $imgs->max('height');
        // dddx([$width, $height]);
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
            // $img = Image::make($v['img_path']);
            $img_canvas->insert($v, 'top-left ', $delta, 0);
            $delta += $v->width();
        }
        // $img_canvas->save(public_path($filename), 100);
        $img_canvas->save(public_path().'/'.$filename, 100);
        /*  } else {
              try {
                  $graph->Stroke(public_path($filename));
              } catch (\Exception $e) {
                  dddx([$e->getMessage(), $e->getFile(), $e->getLine(), $e]);
              }

        try {
          $graph->Stroke(public_path($filename));
        } catch (\Exception $e) {
          dddx([$e->getMessage(), $e->getFile(), $e->getLine(), $e]);
        }
        */
    }
}