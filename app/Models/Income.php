<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Income extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id', 'amount', 'calendar_date', 'user_id'];

    /**
     * @param int $userId
     * @return array
     */
    public function fetchAll(int $userId): array
    {
        return $this->join('income_categories', 'incomes.category_id', '=', 'income_categories.id')
                    ->leftjoin('fixed_incomes', 'incomes.id', '=', 'fixed_incomes.income_id')
                    ->select('incomes.*', 'income_categories.name as category_name', 'fixed_incomes.id as fixed_income_id', 'fixed_incomes.cycle_unit', 'fixed_incomes.payment_day', 'fixed_incomes.payment_month', 'fixed_incomes.start_date', 'fixed_incomes.end_date')
                    ->where('incomes.user_id', $userId)
                    ->orderByRaw('fixed_incomes.id IS NULL DESC')
                    ->get()
                    ->toArray();
    }

    /**
     * @param integer $id
     * @return ?
     */
    public function fetchById(int $id, int $userId): ?Income
    {
		return $this->join('income_categories', 'incomes.category_id', '=', 'income_categories.id')
					->leftjoin('fixed_incomes', 'incomes.id', '=', 'fixed_incomes.income_id')
					->select('incomes.*', 'income_categories.name as category_name', 'fixed_incomes.payment_day', 'fixed_incomes.payment_month', 'fixed_incomes.start_date', 'fixed_incomes.end_date', 'fixed_incomes.cycle_unit')
					->where('incomes.id', $id)
					->where('incomes.user_id', $userId)
					->first();
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @param int $userId
     * @return array
     */
    public function fetchOneTimeIncome(string $startDate, string $endDate, int $userId): array
    {
        return $this->whereBetween('calendar_date', [$startDate, $endDate])
                    ->where('incomes.user_id', $userId)
                    ->join('income_categories', 'incomes.category_id', '=', 'income_categories.id')
                    ->leftjoin('fixed_incomes', 'incomes.id', '=', 'fixed_incomes.income_id')
                    ->whereNull('fixed_incomes.id')
                    ->select('incomes.*', 'income_categories.name as category_name')
                    ->get()
                    ->toArray();
    }

    /**
     * @param int $userId
     * @return array
     */
    public function fetchFixedIncome(int $userId): array
    {
        return $this->join('fixed_incomes', 'incomes.id', '=', 'fixed_incomes.income_id')
                    ->join('income_categories', 'incomes.category_id', '=', 'income_categories.id')
                    ->where('incomes.user_id', $userId)
                    ->select(
                        'incomes.*', 
                        'income_categories.name as category_name',
                        'fixed_incomes.cycle_unit', 
                        'fixed_incomes.payment_day', 
                        'fixed_incomes.payment_month', 
                        'fixed_incomes.start_date', 
                        'fixed_incomes.end_date'
                    )
                    ->get()
                    ->toArray();
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
        string $calendarDate,
        int $userId
    ): void
    {
        $this->create(
            [
                'name' => $name,
                'category_id' => $categoryId,
                'amount' => $amount,
                'calendar_date' => $calendarDate,
                'user_id' => $userId
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
        string $calendarDate,
        int $userId
    ): void {
        $this->where('id', $id)->where('user_id', $userId)->update(
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
    public function deleteById(int $id, int $userId): void
    {
        $this->where('id', $id)->where('user_id', $userId)->delete();
    }
}
