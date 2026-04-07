<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'status'
    ];

    // Relationship: Form has many fields
    public function fields()
    {
        return $this->hasMany(FormField::class);
    }

    // Relationship: Form has many submissions (optional)
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}