<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Expenditure extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id', 'amount'];

    /**
     * @return array
     */
    public function fetchAll(): array
    {
        return $this->all()->toArray();
    }

        /**
     * @param integer $id
     * @return array
     */
    public function fetchById(int $id): array
    {
        return $this->find($id)->toArray();
    }

    /**
     * @param string $name
     * @param integer $categoryId
     * @param integer $amount
     * @return void
     */
    public function createExpenditure(
        string $name,
        int $categoryId,
        int $amount
    ): void
    {
        $this->create(
            [
                'name' => $name,
                'category_id' => $categoryId,
                'amount' => $amount
            ]
        );
    }

    /**
     * @param integer $id
     * @param string $name
     * @param integer $categoryId
     * @param integer $amount
     * @return void
     */
    public function updateById(
        int $id,
        string $name,
        int $categoryId,
        int $amount
    ): void {
        $this->where('id', $id)->update(
            [
                'name' => $name,
                'category_id' => $categoryId,
                'amount' => $amount
            ]
        );
    }

    /**
     * @param integer $id
     * @return void
     */
    public function deleteById(int $id): void
    {
        $this->where('id', $id)->delete();
    }
}
