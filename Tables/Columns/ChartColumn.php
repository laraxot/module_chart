<?php

namespace Modules\Chart\Tables\Columns;

use Filament\Tables\Columns\Column;
use Illuminate\Contracts\View\View;
use Modules\Chart\Datas\AnswersData;

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

    public array $chartData = [

        'datasets' => [
            [
                'label' => 'loading...',
                'data' => [],
            ],
        ],
        'labels' => [],

    ];

    public string $chartType = 'bar';
    public array $chartOptions = [];

    public function setAnswersData(AnswersData $answersData){
        $this->chartData = $answersData->getChartJsData();
        $this->chartType = $answersData->getChartJsType();
        $this->chartOptions = $answersData->getChartJsOptions();
        return $this;
    }

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
        return $this->chartData;
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
        return $this->chartOptions;
    }

    public function getType():string{
        return $this->chartType;
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
