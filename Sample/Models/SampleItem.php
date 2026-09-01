<?php

declare(strict_types=1);

namespace Modules\Sample\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spine\Traits\HasLifecycleHooks;

class SampleItem extends Model
{
    // Otomatis dispatch EntityCreating/Created/Updating/Updated/Deleting/Deleted
    use HasLifecycleHooks;
    // Auto-generate ULID (bukan UUID) di kolom 'ulid' saat create — bawaan Laravel
    use HasUlids;

    protected $fillable = ['name', 'description', 'quantity', 'price', 'ulid', 'status'];

    protected $casts = [
        'id'       => 'integer',
        'quantity' => 'integer',
        'price'    => 'decimal:2',
    ];

    /**
     * HasUlids default mengisi PRIMARY KEY — override agar mengisi kolom 'ulid'.
     */
    public function uniqueIds(): array
    {
        return ['ulid'];
    }
}
