<?php
/**
 * https://it.scribd.com/document/27111189/Jpgraph-Manual.
 */

declare(strict_types=1);

namespace Modules\Chart\Services\ChartEngines;

// use Amenadiel\JpGraph\Graph;

use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Themes\UniversalTheme;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

/**
 * ---.
 * */
class JpgraphEngine2 extends BaseChartEngine {
    use Traits\ChartEngineTrait;

    use JpgraphEngineTraits\BarTrait;
    use JpgraphEngineTraits\CommonTrait;
    use JpgraphEngineTraits\HorizbarTrait;
    use JpgraphEngineTraits\LineTrait;
    use JpgraphEngineTraits\MixedTrait;
    use JpgraphEngineTraits\PieTrait;
    use JpgraphEngineTraits\TableTrait;

    private static ?self $instance = null;

    private Graph $graph;

    public int $width = 250;
    public int $height = 250;

    // private string $type = ''; // quale tipo di grafico andiamo a fare a barre a linee orizzontale, verticale

    public string $title = ''; // 'Lei ha appena svolto una pratica con BIM GSP S.p.A. o utilizzato un canale di contatto di BIM GSP S.p.A. può indicarci il motivo del contatto? ';

    public string $filename;

    public array $vars = [];

    public array $imgs = [];

    public Collection $data;

    // --- FONT
    public string $color;
    public string $family;
    public string $style;
    public int $size;

    /**
     * @return void
     */
    public function __construct() {
        $xot_autoload = realpath(__DIR__.'/../../../Xot/Services/vendor/autoload.php');
        include_once $xot_autoload;
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

    /*
    public function default() {
    }
    */

    public function getGraph(): Graph {
        // Create the graph. These two calls are always required
        $graph = new Graph($this->width, $this->height, 'auto');
        $graph->SetScale('textlin');
        // .$this->vars['title']
        // $graph->title->Set('aaa');
        $graph->SetShadow();
        $theme_class = new UniversalTheme();
        // Setup font for axis
        /*$graph->xaxis->SetFont(FF_VERDANA, FS_NORMAL, 10);
        $graph->yaxis->SetFont(FF_VERDANA, FS_NORMAL, 10);*/

        // $graph->xaxis->setFont($this->family, $this->style, $this->size);
        // $graph->yaxis->setFont($this->family, $this->style, $this->size);

        // $graph->setColor($this->color);

        $graph->SetTheme($theme_class);

        /*
        if (isset($this->vars['min'])) {
            $graph->yscale->SetAutoMin($this->vars['min']);
        }
        if (isset($this->vars['max'])) {
            $graph->yscale->SetAutoMax($this->vars['max']);
        }
        */

        $this->graph = $graph;

        return $graph;
    }

    public function save(string $filename): self {
        $this->filename = $filename;
        // Finally send the graph to the browser
        if (File::exists(public_path($this->filename))) {
            File::delete(public_path($this->filename));
        }

        if (\count($this->imgs) > 0) {
            /*
            https://github.com/Intervention/image/issues/376
            */
            $imgs = collect($this->imgs);
            $width = $imgs->sum('width');
            $height = $imgs->max('height');
            // 172    Parameter #1 $width of static method Intervention\Image\ImageManager::canvas()
            // expects int, mixed given.
            if (! is_numeric($width) || ! is_numeric($height)) {
                throw new Exception('['.__LINE__.']['.class_basename(__CLASS__).']');
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
            } catch (Exception $e) {
                dddx([$e->getMessage(), $e->getFile(), $e->getLine(), $e]);
            }
        }

        return $this;
    }
}