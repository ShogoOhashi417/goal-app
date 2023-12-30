<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoList extends Model
{
    use HasFactory;

    public function getData()
    {
        return $this->name . "の締切は" . $this->dead_line . "です！";
    }

    public function scopeNameEqual($query, $str) {
        return $query->where('name', $str);
    }
}
