<?php

declare(strict_types=1);

namespace Modules\Chart\Services\ChartEngines\JpgraphEngineTraits;

trait OdometerTrait {
    /**
     * Undocumented function.
     * https://jpgraph.net/download/manuals/chunkhtml/ch20s02.html.
     */
    public function odometer1() {
        // Create a new odometer graph (width=250, height=200 pixels)
        $graph = new OdoGraph(250, 140);

        // Now we need to create an odometer to add to the graph.
        // By default the scale will be 0 to 100
        $odo = new Odometer();

        // Set display value for the odometer
        $odo->needle->Set(30);

        // Add the odometer to the graph
        $graph->Add($odo);

        // ... and finally stroke and stream the image back to the client
        $graph->Stroke();
    }
}
