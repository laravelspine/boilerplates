<?php

declare(strict_types=1);

namespace Modules\Sample\Models;

use Illuminate\Database\Eloquent\Model;
use Spine\Traits\HasLifecycleHooks;

class SampleItem extends Model
{
    // Otomatis dispatch EntityCreating/Created/Updating/Updated/Deleting/Deleted
    use HasLifecycleHooks;

    protected $fillable = ['name', 'description', 'quantity', 'price'];

    protected $casts = [
        'id'       => 'integer',
        'quantity' => 'integer',
        'price'    => 'decimal:2',
    ];
}
