<?php
/**
* https://it.scribd.com/document/27111189/Jpgraph-Manual.
* https://jpgraph.net/download/manuals/classref/.
* https://jpgraph.net/download/manuals/chunkhtml/index.html.
*/

declare(strict_types=1);

namespace Modules\Chart\Services\ChartEngines;

//use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Plot\BarPlot;
use Amenadiel\JpGraph\Plot\LinePlot;
use Amenadiel\JpGraph\Plot\PlotBand;
use Amenadiel\JpGraph\Themes\UniversalTheme;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

/**
 * ---.
 * */
class JpgraphEngine3 {
    private static ?self $instance = null;

    public int $width = 250;
    public int $height = 250;

    public string $filename;

    public static function getInstance(): self {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function make(): self {
        return static::getInstance();
    }

    public function setWidthHeight(int $width, int $height) {
        $this->width = $width;
        $this->height = $height;

        return $this;
    }

    public function setData(Collection $data): self {
        $this->data = $data;

        return $this;
    }

    public function getGraph() {
        // Create the graph. These two calls are always required
        $graph = new Graph($this->width, $this->height, 'auto');
        $graph->SetScale('textlin');

        return $graph;
    }

    public function save(string $filename) {
        $this->filename = $filename;

        return $this->test();
    }

    public function test() {
        // We need some data
        $datay = $this->data->pluck('value')->all();
        $datax = $this->data->pluck('label')->all();

        // Setup the graph.

        $graph = $this->getGraph();
        //$graph->img->SetMargin(60, 20, 35, 75);
        $graph->SetScale('textlin', 5, 10);
        //$graph->SetScale('lin', 5, 10);
        //$graph->SetY2Scale('lin', 0, 10);
        $graph->SetY2Scale('int', 5, 10);
        $graph->SetY2OrderBack(false);

        $graph->SetMarginColor('lightblue:1.1');
        $graph->SetShadow();

        $theme_class = new UniversalTheme();
        $graph->SetTheme($theme_class);

        // Set up the title for the graph
        //$graph->title->Set('Bar gradient with left reflection');
        $graph->title->SetMargin(8);
        $graph->title->SetFont(FF_VERDANA, FS_BOLD, 12);
        $graph->title->SetColor('darkred');

        // Setup font for axis
        $graph->xaxis->SetFont(FF_VERDANA, FS_NORMAL, 10);
        $graph->yaxis->SetFont(FF_VERDANA, FS_NORMAL, 10);

        // Show 0 label on Y-axis (default is not to show)
        $graph->yscale->ticks->SupressZeroLabel(false);

        // Setup X-axis labels
        $graph->xaxis->SetTickLabels($datax);
        $graph->xaxis->SetLabelAngle(50);

        // Create the bar pot
        $bplot = new BarPlot($datay);
        $bplot->SetWidth(0.6);

        // Setup color for gradient fill style
        //$bplot->SetFillGradient('navy:0.9', 'navy:1.85', GRAD_LEFT_REFLECTION);
        $bplot->SetFillColor('darkgreen');

        // Set color for the frame of each bar
        $bplot->SetColor('white');

        //----------------------------------------------------------------
        // Setup values
        //http://www.digialliance.com/docs/jpgraph/html/exframes/frame_example20.5.html
        $bplot->value->Show();
        $bplot->value->setColor('white');
        $bplot->value->setAngle(50);
        $bplot->value->SetFormat('%01.2f');
        //$bplot->value->SetFont(FF_FONT1, FS_BOLD);
        $bplot->value->SetFont(FF_VERDANA, FS_ITALIC);
        //http://www.digialliance.com/docs/jpgraph/html/exframes/frame_listfontsex1.html
        $bplot->value->SetFont(FF_ARIAL, FS_BOLD);

        // Center the values in the bar
        $bplot->SetValuePos('center');

        // Make the bar a little bit wider
        $bplot->SetWidth(0.7);
        //----------------------------------------------------------------

        $graph->Add($bplot);

        //line1
        $data6y = [7.5, 7.5, 7.5, 7.5, 7.5, 7.5, 7.5, 7.5, 7.5, 7.5, 7.5];

        $lplot = new LinePlot($data6y);

        $graph->AddY2($lplot);

        $lplot->SetBarCenter();
        $lplot->SetColor('navy');
        $lplot->SetLegend('Riferimento');
        //$lplot->mark->SetType(MARK_X, '', 1.0);
        $lplot->mark->SetWeight(12);
        $lplot->mark->SetWidth(18);
        $lplot->mark->setColor('yellow');
        $lplot->mark->setFillColor('yellow');
        /*
        $band = new PlotBand(VERTICAL, BAND_RDIAG, 5, 'max', 'khaki4');
        $band->ShowFrame(true);
        $band->SetOrder(DEPTH_BACK);
        $graph->Add($band);

        $uband = new PlotBand(HORIZONTAL, BAND_RDIAG, -2, 'max', 'green');
        $uband->ShowFrame(false);
        $uband->SetDensity(50); // 50% line density
        $graph->AddBand($uband);
        */



        // Finally send the graph to the browser
        if (File::exists(public_path($this->filename))) {
            File::delete(public_path($this->filename));
        }

        $graph->Stroke($this->filename);
    }
}
