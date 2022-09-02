<?php
/*
https://jpgraph.net/download/manuals/chunkhtml/ch19s05.html
*/

declare(strict_types=1);

namespace Modules\Chart\Services\ChartEngines\JpgraphEngineTraits;

use Amenadiel\JpGraph\Graph\CanvasGraph;
use Amenadiel\JpGraph\Text\GTextTable;

trait TableTrait {
    // https://jpgraph.net/download/manuals/chunkhtml/example_src/table_mex00.html
    public function table1(): self {
        // dddx($this->vars);

        // Setup a basic canvas to use as graph to add the table
        $graph = new CanvasGraph(500, 200);

        // dddx($this->vars['votes']);

        $votes = ['', 10, 9, 8, 7, 6, 5, 4, 3, 2, 1, 0, 'N'];
        // Setup the basic table
        $data = [
            /* array_merge([''], $this->vars['votes']), */
            $votes,
        ];

        /* $max=0; */
        $totals = ['Totale', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        foreach ($this->vars['answers'] as $week => $items) {
            $array_to_push = [
                @\count($this->vars['answers'][$week][10]),
                @\count($this->vars['answers'][$week][9]),
                @\count($this->vars['answers'][$week][8]),
                @\count($this->vars['answers'][$week][7]),
                @\count($this->vars['answers'][$week][6]),
                @\count($this->vars['answers'][$week][5]),
                @\count($this->vars['answers'][$week][4]),
                @\count($this->vars['answers'][$week][3]),
                @\count($this->vars['answers'][$week][2]),
                @\count($this->vars['answers'][$week][1]),
                @\count($this->vars['answers'][$week][0]),
                @\count($this->vars['answers'][$week]['']), ];

            $totals[1] += @\count($this->vars['answers'][$week][10]);
            $totals[2] += @\count($this->vars['answers'][$week][9]);
            $totals[3] += @\count($this->vars['answers'][$week][8]);
            $totals[4] += @\count($this->vars['answers'][$week][7]);
            $totals[5] += @\count($this->vars['answers'][$week][6]);
            $totals[6] += @\count($this->vars['answers'][$week][5]);
            $totals[7] += @\count($this->vars['answers'][$week][4]);
            $totals[8] += @\count($this->vars['answers'][$week][3]);
            $totals[9] += @\count($this->vars['answers'][$week][2]);
            $totals[10] += @\count($this->vars['answers'][$week][1]);
            $totals[11] += @\count($this->vars['answers'][$week][0]);
            $totals[12] += @\count($this->vars['answers'][$week]['']);

            /*$max_current_array=max($array_to_push);
            if($max<$max_current_array){
                $max=$max_current_array;
            }*/

            $data[] =
                /*array_merge([$week], collect($items)->map(function ($el) {
                   return count($el);
                })->toArray()*/
                array_merge([$week], $array_to_push)
            ;
        }

        $data[] = $totals;

        // dddx($data);

        // Create a basic table and default fonr
        $table = new GTextTable();
        $table->Set($data);
        $table->SetFont(FF_TIMES, FS_NORMAL, 11);

        $rows_number = collect($this->vars['votes'])->count();
        $cols_number = collect($this->vars['weeks'])->count();

        // Adjust the font for row 0 and 6
        $table->SetColFont(0, FF_ARIAL, FS_BOLD, 12);
        $table->SetRowFont($cols_number + 1, FF_ARIAL, FS_BOLD, 12);

        // Set the minimum heigth/width
        /*$table->SetMinRowHeight(2, 10);
        $table->SetMinColWidth(70);*/

        // Add some padding (in pixels)
        /* $table->SetRowPadding(2, 0);

         $table->SetRowGrid($rows_number, 1, 'darkgray', TGRID_DOUBLE2);*/

        // Setup the grid
        /*$table->SetGrid(0);
        $table->SetRowGrid($rows_number-1, 1, 'black', TGRID_DOUBLE2);*/

        // Merge all cells in row 0
        /* $table->MergeRow(0); */

        // Set aligns
        /* $table->SetAlign(3, 0, 6, 6, 'right');
         $table->SetRowAlign(1, 'center');
         $table->SetRowAlign(2, 'center');*/

        foreach ($votes as $c => $vote) {
            $r = 0;
            $partecipants = 0;

            // dddx(count($this->vars['answers'][$week][$vote]));
            $i = 0;
            foreach ($this->vars['answers'] as $week) {
                if (@\count($week[$vote]) > $partecipants) {
                    $partecipants = @\count($week[$vote]);

                    $r = $i;

                    // dddx([$r, $c]);
                }

                ++$r;
            }
            // dddx([$r, $i]);
            $table->SetFillColor($r, $c, $r, $c, 'yellow@0');
        }

        // $table->SetFillColor(2, 2, 2, 2, 'yellow@0');

        // Set background colors
        $table->SetRowFillColor(0, 'lightgray@0.5');
        $table->SetColFillColor(0, 'lightgray@0.5');

        // Add the country flags in row 1
        /* $n = count($countries);
         for ($i = 0; $i < $n; ++$i) {
             $table->SetCellCountryFlag(1, $i + 1, $countries[$i], 0.5);
             $table->SetCellImageConstrain(1, $i + 1, TIMG_HEIGHT, 20);
         }*/

        // Add the table to the graph
        $graph->Add($table);

        // Send back the table graph to the client
        // $graph->Stroke();

        $this->graph = $graph;

        return $this;
    }

    // https://jpgraph.net/download/manuals/chunkhtml/example_src/table_mex3.html
    public function table2(): self {
        $graph = new CanvasGraph(500, 200);

        $data = [
            ['',        'w631', 'w632', 'w633', 'w634', 'w635', 'w636'],
            ['Critical (sum)', 13, 17, 15, 8, 3, 9],
            ['High (sum)', 34, 35, 26, 20, 22, 16],
            ['Low (sum)', 41, 43, 49, 45, 51, 47],
            ['Sum:', 88, 95, 90, 73, 76, 72],
        ];

        // Setup the basic table and font
        $table = new GTextTable();
        $table->Set($data);
        $table->SetFont(FF_ARIAL, FS_NORMAL, 11);

        // Set default minimum color width
        $table->SetMinColWidth(40);

        // Set default table alignment
        $table->SetAlign('right');

        // Turn off grid
        $table->setGrid(0);

        // Set table border
        $table->SetBorder(2);

        // Setup font
        $table->SetRowFont(4, FF_ARIAL, FS_BOLD, 11);
        $table->SetRowFont(0, FF_ARIAL, FS_BOLD, 11);
        $table->SetFont(1, 2, 1, 3, FF_ARIAL, FS_BOLD, 11);

        // Setup grids
        // 191    Constant TGRID_SINGLE not found.
        // $table->SetRowGrid(4, 2, 'black', TGRID_SINGLE);
        // $table->SetColGrid(1, 1, 'black', TGRID_SINGLE);
        // $table->SetRowGrid(1, 1, 'black', TGRID_SINGLE);

        // Setup colors
        $table->SetFillColor(0, 1, 0, 6, 'black');
        $table->SetRowColor(0, 'white');
        $table->SetRowFillColor(4, 'lightgray@0.3');
        $table->SetFillColor(2, 0, 2, 6, 'lightgray@0.6');
        $table->SetFillColor(1, 2, 1, 3, 'lightred');

        // Add table to graph
        $graph->Add($table);

        // Send back to the client
        // $graph->Stroke();

        $this->graph = $graph;

        return $this;
    }
}
