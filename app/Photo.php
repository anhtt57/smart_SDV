<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'photo';
    protected $fillable = ['id','user_id','research_id','medical_institution_id','patient_id','stage_id','turn_number','photo_type','photo_path','created_at','updated_at','created_by','updated_by'];
}
