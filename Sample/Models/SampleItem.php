<?php

declare(strict_types=1);

namespace Modules\Sample\Models;

use Illuminate\Database\Eloquent\Model;

class SampleItem extends Model
{
    protected $fillable = ['name', 'description', 'quantity', 'price'];

    protected $casts = [
        'id'       => 'integer',
        'quantity' => 'integer',
        'price'    => 'decimal:2',
    ];
}
