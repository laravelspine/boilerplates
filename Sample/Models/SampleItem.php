<?php

declare(strict_types=1);

namespace Modules\Sample\Models;

use Illuminate\Database\Eloquent\Model;

class SampleItem extends Model
{
    protected $fillable = ['name'];

    protected $casts = [
        'id' => 'integer',
    ];
}
