<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function diallingCode(){
        return $this->hasOne(DialingCode::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
