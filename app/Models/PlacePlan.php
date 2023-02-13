<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlacePlan extends Model
{
    use HasFactory;

    protected $fillable =[
        'place_name', 'content', 'is_start' , ' is_destination','leave_time', 'arrived_time','stay_time'
    ];

    public function datePlan(){
        return $this->belongsTo(DatePlan::class);
    }
}
