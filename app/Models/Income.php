<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Income extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'amount'];

    /**
     * @return array
     */
    public function fetchAll(): array
    {
        return $this->all()->toArray();
    }

    /**
     * @param string $name
     * @param integer $amount
     * @return void
     */
    public function createIncome(
        string $name,
        int $amount
    ): void
    {
        $this->create(
            [
                'name' => $name,
                'amount' => $amount
            ]
        );
    }
}
