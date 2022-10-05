<?php
/**
 * @see https://www.larashout.com/laravel-collection-using-tojson-method
 * @see https://codepen.io/k-sav/pen/PXxywK
 * @see https://chartjs-plugin-datalabels.netlify.app/
 */

declare(strict_types=1);

namespace Modules\Chart\Services\ChartEngines\ChartJsEngineTraits;

use Modules\Chart\Services\ChartJsBuilder;
use Illuminate\Support\Str;

trait HorizbarTrait {
    /**
     * Undocumented function.
     */
    public function horizbar1(): self {

      //dddx($this);

      $uuid = Str::uuid()->toString();
      $uuid = str_replace('-','',$uuid);
      $uuid = substr($uuid,-8);
            
      $datay = $this->data->pluck('value')->all();
      $datax = $this->data->pluck('label')->all();

      $chartjsbuilder=ChartJsBuilder::make();

      $chartjs = $chartjsbuilder
      //attenzione: rand andrà sostuito con un id univoco per il canvas
      //ho provato con uuid ma vedo che non funziona. forse troppo lungo
      ->name('c'.$uuid)
      //a seconda del type
      ->type('bar')
      ->size(['width' => $this->vars['width'], 'height' => $this->vars['height']])
      ->labels($datax)
      ->datasets([
          [
              "label" => "Anwers",
              'backgroundColor' => ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)'],
              'data' => $datay
          ]
          ])
      ->options([
          'indexAxis'=> 'y',
          'elements'=> [
              'bar'=> [
                  'borderWidth'=> 2
                  ]
          ],
          'responsive'=> false,
          'plugins'=> [
              'legend'=> [
                  'position'=> 'right',
              ],
              'title'=> [
                  'display'=> true,
                  'text'=> 'Totale Rispondenti: '.$this->vars['tot']
              ]
          ]
      ]);

      //dddx($chartjs);

      $view='chart::chartjs.example';
      $view_params=compact('chartjs');
      $view_params['view']=$view;
      $view_params['filename'] = 'prova123';

      /* echo '<pre>';
      echo var_export($view_params,true);
      echo '</pre>'; */

      //dddx($view_params);
      $out = view()->make($view, $view_params);
      $html = $out->render();
      echo $html; 
      //dddx($html);
      return $this;
    }

    public function horizbar1_obj(): self {
        $labels = $this->data->pluck('label')->all();
        $data = $this->data->pluck('value')->all();
        $options = [
            'indexAxis' => 'y',
            'plugins' => [
                'datalabels' => [
                    'color' => '#d60021',
                ],
            ],
            'scales' => [
                'yAxes' => [
                    [
                        'type' => 'category',
                        'offset' => true,
                        'position' => 'right',
                    ],
                ],
            ],
        ];

        $optionsRaw = "{
            indexAxis: 'y',
            scales: {

                xAxes: [
                  {
                    stacked: true,
                    gridLines: {
                      display: false
                    },
                    ticks: {
                      fontColor: '#d60021'
                    }
                  },
                  {
                    type: 'category',
                    offset: true,
                    position: 'right',
                    ticks: {
                      fontColor: '#d60021'

                    }
                  }
                ],
                yAxes: [
                  {
                    stacked: true,
                    display: false,
                    ticks: {
                      fontColor: '#d60021'
                    }
                  }
                ]
            }
        }";

        $optionsRaw = "{
            indexAxis: 'y',
            type: 'category',
            position: 'right',
            offset: true,
            ticks: {
              reverse: true,
            },
            gridLines: {
              display: false
            }
          }";

        $optionsRaw = "{
            indexAxis: 'y',
            scales: {
                xAxes: [{
                  stacked: true,
                }],
                yAxes: [{
                  stacked: true,
                  ticks: {
                    reverse: true,
                  }
                },
                {
                  type: 'category',
                  position: 'right',
                  offset: true,
                  ticks: {
                    reverse: true,
                  },
                  gridLines: {
                    display: false
                  }
                }]
            }
        }";

        $optionsRaw = "{
            maintainAspectRatio: false,
            responsive: true,
              scales: {
                     xAxes: [{
                       display: true,
                       ticks: {
                       maxTicksLimit: 12
                       }
                     }],
                     yAxes: [{
                        position: 'left',
                        display: true,
                        ticks: {
                        callback:(label,index,labels)=>{
                        label = label.match(/_(\w*)/)[1];
                        return label;
                        }}
                        },
                        {
                         position: 'right',
                         display: true,
                         ticks: {

                         callback:(label,index,labels)=>{
                         return label ;
                         }
                        }
                       }]
                       },
                       legend: {
                               display: false
                      }

      }";

        $optionsRaw = "{
        plugins: {
          datalabels: {
            backgroundColor: function(context) {
              return context.dataset.backgroundColor;
            },
            borderRadius: 4,
            color: 'white',
            font: {
              weight: 'bold'
            },
            formatter: Math.round,
            padding: 6
          }
        },

        // Core options
        aspectRatio: 5 / 3,
        layout: {
          padding: {
            top: 32,
            right: 16,
            bottom: 16,
            left: 8
          }
        },
        elements: {
          line: {
            fill: false,
            tension: 0.4
          }
        },
        scales: {
          y: {
            stacked: true
          }
        }
      }";

        $chartjs = ChartJsBuilder::make()
        ->name(__FUNCTION__)
        ->type('bar')
        ->size(['width' => 400, 'height' => 200])
        ->labels($labels)
        ->datasets([
            [
                'label' => '#',
                'backgroundColor' => 'rgba(38, 185, 154, 0.31)',
                'borderColor' => 'rgba(38, 185, 154, 0.7)',
                'pointBorderColor' => 'rgba(38, 185, 154, 0.7)',
                'pointBackgroundColor' => 'rgba(38, 185, 154, 0.7)',
                'pointHoverBackgroundColor' => '#fff',
                'pointHoverBorderColor' => 'rgba(220,220,220,1)',
                'data' => $data,
            ],
        ])
        ->optionsRaw($optionsRaw);
        /** 
        * @phpstan-var view-string
        */
        $view = 'chart::chartjs.default';
        $view_params = compact('chartjs');

        $out = view()->make($view, $view_params);
        $html = $out->render();
        echo $html; // se non mostro js non viene elaborato e non salva.. ipotesi phantomJS

        
        return $this;
    }
}