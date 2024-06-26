<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hut extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function type()
    {
        return $this->belongsTo(HutType::class, 'huttype_id', 'id');
    }

    public function hut_numbers()
    {
        return $this->hasMany(HutNumber::class, 'huts_id')->where('status', 'Active');
    }
}
