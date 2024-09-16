<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tourist extends Model
{
    use HasFactory,SoftDeletes;

protected $fillable = [
        'first_name',
        'last_name',
        'national_code',
        'number',
        'birth_date'

];

public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}

public function rating(): HasMany
{
    return $this->hasMany(Rating::class);
}

public function ticket(): HasMany
{
    return $this->hasMany(Ticket::class);
}

}
