<?php

namespace Modules\Chart\Tables\Columns;

use Filament\Tables\Columns\Column;
use Illuminate\Contracts\View\View;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Webmozart\Assert\Assert;

class ChartsColumn extends Column
{

    protected string $view = 'chart::tables.columns.charts-column';
    
    public function getComponents():array{
        //$charts=$this->record->charts;
        //$data=request()->all(); // vedere se c'e' qualche trait per i filtri 
        Assert::isInstanceOf($this->record, \Modules\Quaeris\Models\QuestionChart::class, '[wip]');

        $res=[];
        $rows=app(\Modules\Quaeris\Actions\QuestionChart\GetChartsDataByQuestionChart::class)
            ->execute($this->record);
        
        if(count($rows)==3){
            
            return [ 
                
                Split::make([
                //TextColumn::make('id'),
                ChartColumn::make('id')->setAnswersData($rows[0]),
                Stack::make([
                    ChartColumn::make('id')->setAnswersData($rows[1]),
                    ChartColumn::make('id')->setAnswersData($rows[2]),
                    //TextColumn::make('question_txt'),
                    //TextColumn::make('question_txt'),
                ]),
            ]),
        ];
        }
        
        foreach($rows as $row){
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
}
