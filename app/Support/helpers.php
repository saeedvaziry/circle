<?php

use \App\Models\Limit;

/**
 * @return \Illuminate\Database\Eloquent\HigherOrderBuilderProxy|mixed
 */
function get_limit()
{
    $limit = Limit::query()->first();
    if (!$limit) {
        $limit = Limit::query()->create([
            'available' => 50,
            'last_credited' => \Carbon\Carbon::now()
        ]);
    }

    return $limit;
}
