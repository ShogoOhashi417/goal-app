<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Expenditure extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id', 'amount', 'calendar_date', 'user_id'];

    public function fetchAll(int $userId): array
    {
        return $this->join('expenditure_categories', 'expenditures.category_id', '=', 'expenditure_categories.id')
                    ->leftjoin('fixed_expenditures', 'expenditures.id', '=', 'fixed_expenditures.expenditure_id')
                    ->whereNull('fixed_expenditures.id')
                    ->where('expenditures.user_id', $userId)
                    ->select('expenditures.*', 'expenditure_categories.name as category_name', 'fixed_expenditures.id as fixed_expenditure_id', 'fixed_expenditures.cycle_unit', 'fixed_expenditures.payment_day', 'fixed_expenditures.payment_month', 'fixed_expenditures.start_date', 'fixed_expenditures.end_date')
                    ->get()
                    ->toArray();
    }

    /**
     * @param integer $id
     * @return Model|null
     */
    public function fetchById(int $id, int $userId): ?Model
    {
        return $this->where('id', $id)->where('user_id', $userId)->first();
    }

    public function fetchByDateRange(string $startDate, string $endDate): array
    {
        return $this->whereBetween('calendar_date', [$startDate, $endDate])
                    ->join('expenditure_categories', 'expenditures.category_id', '=', 'expenditure_categories.id')
                    ->select('expenditures.*', 'expenditure_categories.name as category_name')
                    ->get()
                    ->toArray();
    }

    public function fetchOneTimeExpenditure(string $startDate, string $endDate): array
    {
        return $this->whereBetween('calendar_date', [$startDate, $endDate])
                    ->join('expenditure_categories', 'expenditures.category_id', '=', 'expenditure_categories.id')
                    ->leftjoin('fixed_expenditures', 'expenditures.id', '=', 'fixed_expenditures.expenditure_id')
                    ->whereNull('fixed_expenditures.id')
                    ->select('expenditures.*', 'expenditure_categories.name as category_name')
                    ->get()
                    ->toArray();
    }

    public function fetchFixedExpenditure(): array
    {
        return $this->join('fixed_expenditures', 'expenditures.id', '=', 'fixed_expenditures.expenditure_id')
                    ->join('expenditure_categories', 'expenditures.category_id', '=', 'expenditure_categories.id')
                    ->select(
                        'expenditures.*', 
                        'expenditure_categories.name as category_name',
                        'fixed_expenditures.cycle_unit', 
                        'fixed_expenditures.payment_day', 
                        'fixed_expenditures.payment_month', 
                        'fixed_expenditures.start_date', 
                        'fixed_expenditures.end_date',
                    )
                    ->get()
                    ->toArray();
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
     * @param array $saveDataList
     * @return void
     */
    public function saveBulk(
        array $saveDataList,
    ): void {
        $this->upsert($saveDataList, ['id', 'user_id']);
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

    /**
     * 
     * @param integer $id
     * @return self|null
     */
    public function fetchFixedExpenditureById(int $id): ?self
    {
        return $this->join('expenditure_categories', 'expenditures.category_id', '=', 'expenditure_categories.id')
                    ->join('fixed_expenditures', 'expenditures.id', '=', 'fixed_expenditures.expenditure_id')
                    ->select(
                        'expenditures.*', 
                        'expenditure_categories.name as category_name',
                        'fixed_expenditures.id as fixed_expenditure_id',
                        'fixed_expenditures.cycle_unit',
                        'fixed_expenditures.payment_day',
                        'fixed_expenditures.payment_month',
                        'fixed_expenditures.start_date',
                        'fixed_expenditures.end_date'
                    )
                    ->where('expenditures.id', $id)
                    ->first();
    }
}
