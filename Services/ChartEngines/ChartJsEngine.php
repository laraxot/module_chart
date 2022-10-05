<?php
/**
 * https://it.scribd.com/document/27111189/Jpgraph-Manual.
 */

declare(strict_types=1);

namespace Modules\Chart\Services\ChartEngines;

use Exception;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
// use Amenadiel\JpGraph\Graph;

/**
 * ---.
 * */
class ChartJsEngine extends BaseChartEngine {
    use Traits\ChartEngineTrait;

    use ChartJsEngineTraits\BarTrait;
    use ChartJsEngineTraits\CommonTrait;
    use ChartJsEngineTraits\HorizbarTrait;
    use ChartJsEngineTraits\LineTrait;
    use ChartJsEngineTraits\MixedTrait;
    use ChartJsEngineTraits\PieTrait;
    //use ChartJsEngineTraits\TableTrait;

    public int $width = 250;
    public int $height = 250;

    // :$type is never read, only written.
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

    private static ?self $instance = null;

    /**
     * @return void
     */
    public function __construct() {
        // $xot_autoload = realpath(__DIR__.'/../../../Xot/Services/vendor/autoload.php');
        // include_once $xot_autoload;
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

    public function getGraph() {

        //qui è dove deve costruire il grafico anche per chartjs
        //$graph = new Graph($this->width, $this->height, 'auto');

        dddx("getGraph");

        //$graph={$this->vars}();

        $graph->SetScale('textlin');
        $graph->SetShadow();
        $theme_class = new UniversalTheme();

        $graph->SetTheme($theme_class);

        $this->graph = $graph;

        return $graph;
    }

    public function save(string $filename): self {

        return $this;
    }
}