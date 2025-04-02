<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Expenditure extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id', 'amount', 'calendar_date'];

    public function fetchAll(): array
    {
        return $this->join('expenditure_categories', 'expenditures.category_id', '=', 'expenditure_categories.id')
                    ->select('expenditures.*', 'expenditure_categories.name as category_name')
                    ->get()
                    ->toArray();
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
        int $amount,
        string $calendarDate
    ): void
    {
        $this->create(
            [
                'name' => $name,
                'category_id' => $categoryId,
                'amount' => $amount,
                'calendar_date' => $calendarDate
            ]
        );
    }

    /**
     * @param array $saveDataList
     * @return void
     */
    public function saveBulk(
        array $saveDataList
    ): void {
        $this->upsert($saveDataList, ['id']);
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
        int $amount,
        string $calendarDate
    ): void {
        $this->where('id', $id)->update(
            [
                'name' => $name,
                'category_id' => $categoryId,
                'amount' => $amount,
                'calendar_date' => $calendarDate
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

    /**
     * @return integer
     */
    public function getLastInsertId(): int
    {
        return $this->getConnection()->getPdo()->lastInsertId();
    }
}
