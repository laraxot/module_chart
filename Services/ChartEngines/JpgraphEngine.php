<?php

declare(strict_types=1);

namespace Modules\Chart\Services\ChartEngines;

use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Themes\UniversalTheme;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Spatie\LaravelData\DataCollection;
use function Safe\realpath;

class JpgraphEngine extends BaseChartEngine {
    use JpgraphEngineTraits\BarTrait;
    use JpgraphEngineTraits\CommonTrait;
    use JpgraphEngineTraits\HorizbarTrait;
    use JpgraphEngineTraits\LineTrait;
    use JpgraphEngineTraits\MixedTrait;
    use JpgraphEngineTraits\PieTrait;

    // use JpgraphEngineTraits\TableTrait;

    private static ?self $instance = null;

    private Graph $graph;

    public int $width = 250;
    public int $height = 250;

    // Property Modules\Chart\Services\ChartEngines\JpgraphEngine::$type is never read, only written.
    private string $type; // quale tipo di grafico andiamo a fare a barre a linee orizzontale, verticale

    public string $title = ''; // 'Lei ha appena svolto una pratica con BIM GSP S.p.A. o utilizzato un canale di contatto di BIM GSP S.p.A. può indicarci il motivo del contatto? ';

    public string $filename;

    public array $vars = [];

    public array $imgs = [];
    public DataCollection $data;

    // --- FONT91
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

    public function setWidthHeight(int $width, int $height): self {
        $this->width = $width;
        $this->height = $height;

        return $this;
    }

    public function mergeVars(array $vars): self {
        $this->vars = array_merge($this->vars, $vars);

        return $this;
    }

    public function getVars(): array {
        return $this->vars;
    }

    public function setData(DataCollection $data): self {
        $this->data = $data;

        return $this;
    }

    public function setType(string $type): self {
        $this->type = $type;

        return $this;
    }

    public function setColor(string $color): self {
        $this->color = $color;

        return $this;
    }

    public function setFont(string $family, string $style, int $size): self {
        $this->family = $family;
        $this->style = $style;
        $this->size = $size;

        return $this;
    }

    public function build(): self {
        $this->setWidthHeight((int) $this->vars['width'], (int) $this->vars['height']);

        if (Str::startsWith($this->vars['type'], 'mixed')) {
            $parz = \array_slice(explode(':', $this->vars['type']), 1);
            $res = $this->mixed(...$parz);
        } else {
            $res = $this->{$this->vars['type']}();
        }
        if (! isset($this->vars['extras'])) {
            $this->vars['extras'] = [];
        }
        $extras = $this->vars['extras'];
        foreach ($extras as $extra) {
            $var = get_object_vars($extra);
            unset($var['type']);
            $var = array_values($var);
            $res = $this->{$extra->type}(...$var);
        }

        return $this;
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

        return $this;
    }

    // diventato GetGraphAction
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

        if (isset($this->vars['min'])) {
            $graph->yscale->SetAutoMin($this->vars['min']);
        }
        if (isset($this->vars['max'])) {
            $graph->yscale->SetAutoMax($this->vars['max']);
        }

        if (isset($this->vars['title'])) {
            $graph->title->Set($this->vars['title']);
            $graph->title->SetFont($this->vars['font_family'], $this->vars['font_style'], 11);
        }
        if (isset($this->vars['subtitle'])) {
            $graph->subtitle->Set($this->vars['subtitle']);
            $graph->subtitle->SetFont($this->vars['font_family'], $this->vars['font_style'], 11);
        }
        if (isset($this->vars['footer'])) {
            $graph->footer->center->Set($this->vars['footer']);
            $graph->footer->center->SetFont($this->vars['font_family'], $this->vars['font_style'], 10);
        }

        $this->graph = $graph;

        return $graph;
    }
}
