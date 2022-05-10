<?php

declare(strict_types=1);

namespace Modules\Chart\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
// //use Laravel\Scout\Searchable;
use Modules\Xot\Traits\Updater;

/**
 * Class BasePivot.
 */
abstract class BasePivot extends Pivot {
    use Updater;
    // use Searchable;

    /**
     * @var string
     */
    protected $connection = 'chart'; // this will use the specified database conneciton
    /**
     * @var array
     */
    protected $appends = [];
    /**
     * @var array
     */
    protected $casts = [];
    /**
     * @var string[]
     */
    protected $dates = ['created_at', 'updated_at'];
    /**
     * Undocumented variable.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * @var bool
     */
    public $incrementing = true;
}
