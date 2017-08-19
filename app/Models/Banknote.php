<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Banknote extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'banknotes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'currency_id',
        'name',
        'buying',
        'selling',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'currency_id' => 'integer',
        'buying' => 'string',
        'selling' => 'string',
    ];

    /**
     * Get currency.
     *
     * @return BelongsTo
     */
    public function currency() {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }
}
