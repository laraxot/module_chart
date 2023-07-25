<?php

namespace Modules\Chart\Tables\Columns;

use Filament\Tables\Columns\Column;
use Illuminate\Contracts\View\View;

class ChartColumn extends Column
{

    protected ?array $cachedData = null;

    public string $dataChecksum;

    public ?string $filter = null;

    protected static ?string $heading = null;

    protected static ?string $maxHeight = null;

    protected static ?array $options = null;

    protected string $view = 'chart::tables.columns.chart-column';
    //protected string $view='filament::widgets.chart-widget';



    public function render():View{
        $view_params=[
            'obj'=>$this,
        ];
        return view($this->view,$view_params);
    }


     protected function generateDataChecksum(): string
    {
        return md5(json_encode($this->getCachedData()));
    }

    public function getCachedData(): array
    {
        return $this->cachedData ??= $this->getData();
    }

    protected function getData(): array
    {
         return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getFilters(): ?array
    {
        return null;
    }

    protected function getHeading(): ?string
    {
        return static::$heading;
    }

    public function getMaxHeight(): ?string
    {
        return static::$maxHeight;
    }

    public function getOptions(): ?array
    {
        return static::$options;
    }

    public function getType():string{



        return 'bar';

    }

    public function updateChartData()
    {
        $newDataChecksum = $this->generateDataChecksum();

        if ($newDataChecksum !== $this->dataChecksum) {
            $this->dataChecksum = $newDataChecksum;

            $this->emitSelf('updateChartData', [
                'data' => $this->getCachedData(),
            ]);
        }
    }

    public function updatedFilter(): void
    {
        $newDataChecksum = $this->generateDataChecksum();

        if ($newDataChecksum !== $this->dataChecksum) {
            $this->dataChecksum = $newDataChecksum;

            $this->emitSelf('filterChartData', [
                'data' => $this->getCachedData(),
            ]);
        }
    }
}
