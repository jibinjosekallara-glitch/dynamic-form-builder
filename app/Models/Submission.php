<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'data' // json field storing submitted values
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}