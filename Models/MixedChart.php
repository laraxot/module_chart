<?php
/**
 * ---.
 */

declare(strict_types=1);

namespace Modules\Chart\Models;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Modules\Chart\Models\MixedChart.
 *
 * @property int                                                                    $id
 * @property string                                                                 $name
 * @property \Illuminate\Support\Carbon|null                                        $created_at
 * @property \Illuminate\Support\Carbon|null                                        $updated_at
 * @property string|null                                                            $created_by
 * @property string|null                                                            $updated_by
 * @property \Illuminate\Database\Eloquent\Collection|\Modules\Chart\Models\Chart[] $charts
 * @property int|null                                                               $charts_count
 * @method static \Modules\Chart\Database\Factories\MixedChartFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|MixedChart    newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MixedChart    newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MixedChart    query()
 * @method static \Illuminate\Database\Eloquent\Builder|MixedChart    whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MixedChart    whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MixedChart    whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MixedChart    whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MixedChart    whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MixedChart    whereUpdatedBy($value)
 * @mixin \Eloquent
 * @mixin IdeHelperMixedChart
 */
class MixedChart extends BaseModel
{
    /**
     * @var array<string>
     */
    protected $fillable = [
        'id',
        'name',
    ];

    // ---- relations

    public function charts(): MorphMany
    {
        Relation::morphMap([
            'question_chart'=>'Modules\Quaeris\Models\QuestionChart',
            'mixed_chart'=>'Modules\Chart\Models\MixedChart',
        ]);

        $res=$this->morphMany(Chart::class, 'post');

        return $res;
    }
}
