<?php
/**
 * @see https://www.larashout.com/laravel-collection-using-tojson-method
 * @see https://codepen.io/k-sav/pen/PXxywK
 * @see https://chartjs-plugin-datalabels.netlify.app/
 */

declare(strict_types=1);

namespace Modules\Chart\Services\ChartEngines\ChartJsEngineTraits;

use Modules\Chart\Services\ChartJsBuilder;

trait HorizbarTrait {
    /**
     * Undocumented function.
     */
    public function horizbar1(): self {
        /** 
        * @phpstan-var view-string
        */
        $view = 'chart::'.(inAdmin()?'admin.':'').'chartjs.'.__FUNCTION__;

        $labels = $this->data->pluck('label')->all();
        $data = $this->data->pluck('value')->all();
        // dddx(['data'=>$this->data]);
        /** 
        * @phpstan-var view-string
        */
        $view = 'chart::chartjs.'.__FUNCTION__;
        $view .= '.1';
        $view_params = [
            'view' => $view,
            'filename' => 'prova123',
            'labels' => $labels,
            'data' => $data,
        ];

        // dddx($view_params);

        $out = view()->make($view, $view_params);
        $html = $out->render();
        echo $html; // se non mostro js non viene elaborato

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