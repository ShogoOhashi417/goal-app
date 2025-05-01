<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Income extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id', 'amount', 'calendar_date'];

    /**
     * @return array
     */
    public function fetchAll(): array
    {
        return $this->join('income_categories', 'incomes.category_id', '=', 'income_categories.id')
                    ->select('incomes.*', 'income_categories.name as category_name')
                    ->get()
                    ->toArray();
    }

    /**
     * @param integer $id
     * @return ?
     */
    public function fetchById(int $id): ?Income
    {
		return $this->join('income_categories', 'incomes.category_id', '=', 'income_categories.id')
					->leftjoin('fixed_incomes', 'incomes.id', '=', 'fixed_incomes.income_id')
					->select('incomes.*', 'income_categories.name as category_name', 'fixed_incomes.payment_day', 'fixed_incomes.payment_month', 'fixed_incomes.start_date', 'fixed_incomes.end_date', 'fixed_incomes.cycle_unit')
					->where('incomes.id', $id)
					->first();
    }

    /**
     * @param string $name
     * @param integer $categoryId
     * @param integer $amount
     * @param string $calendarDate
     * @return void
     */
    public function createIncome(
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
}
