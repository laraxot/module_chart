<?php
/**
 * https://github.com/szymach/c-pchart.
 * https://apitemplate.io/blog/embedding-charts-into-a-pdf/
 * https://codepen.io/jordanwillis/pen/peqVOM.
 * https://github.com/kartik-v/mpdf/blob/master/graph.php.
 * https://mpdf.github.io/reference/mpdf-variables/usegraphs.html.
 * https://keepcoding.ehsanabbasi.com/php/convert-google-chart-to-png-and-pdf/.
 * https://codingexplained.com/coding/php/using-google-visualization-with-wkhtmltopdf.
 * https://www.webslesson.info/2018/07/how-to-convert-google-chart-to-pdf-using-php.html.
 * https://developers.google.com/chart/interactive/docs/printing.
 */

declare(strict_types=1);

namespace Modules\Chart\Services;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Modules\Chart\Contracts\ChartEngineContract;
use Modules\Chart\Services\ChartEngines\ChartJsEngine;
use Modules\Chart\Services\ChartEngines\JpgraphEngine2;
use Modules\Xot\Services\FileService;
use Modules\Xot\Services\HtmlService;

/**
 * ChartService.
 * */
class ChartService {
    private static ?self $instance = null;
    private ChartEngineContract $chart_engine; // dobbiamo fare interfaccia e poi metterla
    // private string $type = 'default'; // quale tipo di grafico andiamo a fare a barre a linee orizzontale, verticale
    private int $type = 0;

    public function __construct() {

        //ne setti uno di default e semmai cambi tipo
        $this->chart_engine = JpgraphEngine2::make();

        

    }

    public static function getInstance(): self {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function make(): self {
        return static::getInstance();
    }

    public function setData(Collection $data): self {
        // $this->data = $data;
        $this->chart_engine->setData($data);

        return $this;
    }

    public function setWidthHeight(int $width, int $hight): self {
        $this->chart_engine->setWidthHeight($width, $hight);

        return $this;
    }

    public function setColor(string $color): self {
        $this->chart_engine->setColor($color);

        return $this;
    }

    public function setFont(string $family, string $style, int $size): self {
        $this->chart_engine->setFont($family, $style, $size);

        return $this;
    }

    public function mergeVars(array $vars): self {
        $this->chart_engine->mergeVars($vars);

        
        return $this;
    }

    /*
    public function horizontalLine(float $y, string $string): self {
        $this->chart_engine->horizontalLine($y, $string);

        return $this;
    }
    */

    public function getVars(): array {
        return $this->chart_engine->getVars();
    }

    public function setType(string $type): self {
        // $this->type = $type;
        $this->chart_engine->setType($type);

        return $this;
    }

    /**
     * Undocumented function.
     */
    public function toHtml(): Renderable {
        $img = $this->getImg();

        /**
         * @phpstan-var view-string
         */
        $view = 'chart::tests.four';

        $view_params = [
            'title' => '',
            'subtitle' => '',
            'img_src' => asset($img),
        ];

        $view_params = array_merge($view_params, $this->getVars());

        return view()->make($view, $view_params);
    }


    public function setEngine(?string $type="jpgraph"):self{

        $this->mergeVars(['engine_type'=>$type]);

        //dddx($this); 

        if($this->chart_engine->vars['engine_type']==="jpgraph"){
            $type_number = config('chart.type', 0);
        }else if($this->chart_engine->vars['engine_type']==="chartjs"){
            $type_number = config('chart.type', 1);
        }else{
            $type_number = config('chart.type', 0);
        }
        
        //dddx([$this->chart_engine->vars['engine_type'],$type_number]);

        if (! is_int($type_number)) {
            throw new Exception('config chart.type is not an Integer');
        }
        $this->type_number = $type_number;
        switch ($this->type_number) {
            case 0:
                $this->chart_engine = JpgraphEngine2::make();
            break;
            case 1:
                $this->chart_engine = ChartJsEngine::make();
            break;
            default:
                throw new Exception('type ['.$this->type.'] not exists ['.__LINE__.']['.class_basename(__CLASS__).']');
        }

        return $this;
    }

    public function getImg(): string {

        $img = 'chart/'.Str::uuid().'.png';
        $filename = public_path($img);

        FileService::createDirectoryForFilename($filename);

        //dddx($this->chart_engine->data);

        $this->chart_engine
            ->build()
            ->save($img);

            //dddx($img);

        // if (count($this->chart_engine->imgs) > 0) {
        //    dddx($this->chart_engine->imgs);
        // }

        return $img;
    }

    public function toPdf(): self {
        $html = $this->toHtml()->render();
        $content = HtmlService::toPdf(['html' => $html, 'out' => 'content_PDF']);
        if (! \is_string($content)) {
            throw new Exception('['.__LINE__.']['.class_basename(__CLASS__).']');
        }

        File::put(storage_path('test.pdf'), $content);

        return $this;
    }

    /*
    public function getGraph() {
        return $this->chart_engine->getGraph();
    }
    */
}
