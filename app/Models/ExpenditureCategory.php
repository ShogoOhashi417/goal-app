<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenditureCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * @param string $name
     * @return void
     */
    public function createExpenditureCategory(string $name): void
    {
        $this->create(
            [
                'name' => $name,
            ]
        );
    }
}
