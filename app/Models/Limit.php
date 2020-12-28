<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Limit extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['available', 'last_credited'];

    /**
     * @return int
     */
    public function getAvailableAfterAttribute()
    {
        $lastCredited = new Carbon($this->last_credited);

        return 15 - $lastCredited->diffInMinutes(new Carbon());
    }
}
