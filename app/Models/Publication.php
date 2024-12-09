<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Publication extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
