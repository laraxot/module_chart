<?php

declare(strict_types=1);

namespace Modules\Chart\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// //use Laravel\Scout\Searchable;

use Illuminate\Database\Eloquent\Model;
use Modules\Lang\Models\Traits\LinkedTrait;
use Modules\Xot\Traits\Updater;

/**
 * Class BaseModelLang.
 */
abstract class BaseModelLang extends Model {
    use HasFactory;
    // use Searchable;
    use LinkedTrait;
    use Updater;
/**
 * Indicates whether attributes are snake cased on arrays.
 *
 * @see  https://laravel-news.com/6-eloquent-secrets
* 
 * @var bool
 */
// public static $snakeAttributes = true;

protected $perPage = 30;


    protected $connection = 'chart';

    /**
     * @var array
     */
    protected $casts = [
        // 'published_at' => 'datetime:Y-m-d', // da verificare
    ];

    /**
     * @var string[]
     */
    protected $dates = ['published_at', 'created_at', 'updated_at'];

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var bool
     */
    public $incrementing = true;

    /**
     * @var array
     */
    protected $hidden = [
        // 'password'
    ];

    /**
     * @var bool
     */
    public $timestamps = true;

    // -----------
    /*
    protected $id;
    protected $post;
    protected $lang;
    */
}
