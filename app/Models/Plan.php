<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $fillable = [
        'date_number','title'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function datePlans(){
        return $this->hasMany(DatePlan::class);
    }
}
