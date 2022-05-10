<?php
/**
 * ---
 */

declare(strict_types=1);

namespace Modules\Chart\Models;

use Illuminate\Database\Eloquent\Relations\MorphMany;

class MixedChart extends BaseModel {
    /**
     * @var array<string>
     */
    protected $fillable = [
        'id',
        'name',
    ];

    // ---- relations

    public function charts(): MorphMany {
        return $this->morphMany(Chart::class, 'post');
    }
}
