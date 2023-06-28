<?php

declare(strict_types=1);

Route::middleware(['web', 'auth'])
    ->post('/chart/image/store', 'ApiController@imageStore')
    ->name('chart.image.store');
