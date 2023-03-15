<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function rule()
    {
        return $this->belongsTo(Rule::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
