<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['name','dead_line'];

    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->dead_line)->format('Y/m/d');
    }
}
