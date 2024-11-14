<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * @return array
     */
    public function fetchAll(): array
    {
        return $this->all()->toArray();
    }

    /**
     * @param string $name
     * @return void
     */
    public function createIncomeCategory(string $name): void
    {
        $this->create(
            [
                'name' => $name,
            ]
        );
    }
}
