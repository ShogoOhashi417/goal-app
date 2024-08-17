<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Income extends Model
{
    use HasFactory;

    /**
     * @return array
     */
    public function fetchAll(): array
    {
        return $this->all()->toArray();
    }
}
