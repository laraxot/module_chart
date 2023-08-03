<?php

namespace Modules\Chart\Tables\Columns;

use Carbon\Carbon;
use Filament\Tables\Columns\Column;
use Illuminate\Contracts\View\View;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Webmozart\Assert\Assert;

class ChartsColumn extends Column
{
    protected string $view = 'chart::tables.columns.charts-column';

    /**
     * @var array<string, string>
     */
    protected $listeners = ['updateFilter' => 'updateFilter'];


    /*
    public $tableFilters;
    public $filters;

    protected $queryString = [
        'isTableReordering' => ['except' => false],
        'tableFilters' => ['as' => 'filters'], // `tableFilters` is now replaced with `filters` in the query string
        'tableSortColumn' => ['except' => ''],
        'tableSortDirection' => ['except' => ''],
        'tableSearchQuery' => ['except' => '', 'as' => 'search'], // `tableSearchQuery` is now replaced with `search` in the query string
    ];


    protected $queryString = [
        'isTableReordering' => ['except' => false],
        'tableFilters',
        'tableSortColumn' => ['except' => ''],
        'tableSortDirection' => ['except' => ''],
        'tableSearchQuery' => ['except' => ''],
    ];
    */
    public function getComponents(): array
    {
        $filters=session('tableFilters');
        if(!is_array($filters)) {
            $filters=[];
        }
        //$charts=$this->record->charts;
        //$data=request()->all(); // vedere se c'e' qualche trait per i filtri
        //dddx($this->tableFilters);
        //dddx($this->getResourceTable());
        /*
        dddx([
            'filters'=>$this->filters,
            'tableFilters'=>$this->tableFilters,
            'request_all'=>request()->all(),
            'requ1'=>request()->query('tableFilters'),
        ]);
        //*/
        if(isset($filters['date_from'])){
            $filters['date_from']=Carbon::parse($filters['date_from']);
        }else{
            $filters['date_from'] = null;
        }
        if(isset($filters['date_to'])){
            $filters['date_to']=Carbon::parse($filters['date_to']);
        }else{
            $filters['date_to'] = null;
        }

        Assert::isInstanceOf($this->record, \Modules\Quaeris\Models\QuestionChart::class, '[wip]');

        $res=[];
        $rows=app(\Modules\Quaeris\Actions\QuestionChart\GetChartsDataByQuestionChart::class)
            ->execute($this->record, true, $filters['date_from'], $filters['date_to']);


        if(count($rows)==3) {
            return [
                Split::make([
                ChartColumn::make('id')->setAnswersData($rows[0]),
                Stack::make([
                    ChartColumn::make('id')->setAnswersData($rows[1]),
                    ChartColumn::make('id')->setAnswersData($rows[2]),
                    //TextColumn::make('question_txt'),

                ]),
            ]),
        ];
        }

        foreach($rows as $row) {
            $res[]=ChartColumn::make('id')->setAnswersData($row);
        }

        return $res;
        /*
        if(count($charts)==1){
            return [
                ChartsColumn::make('id'),
            ];
        }
        */
    }

    public function updateFilter(array $filter)
    {
        dddx($filter);
    }
}
