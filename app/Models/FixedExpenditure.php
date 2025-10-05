<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class FixedExpenditure extends Model
{
    use HasFactory;

    protected $fillable = [
        'expenditure_id', 
        'cycle_unit', 
        'payment_day', 
        'payment_month', 
        'start_date', 
        'end_date', 
        'user_id',
    ];

    /**
     * Get the expenditure that owns the fixed expenditure.
     */
    public function expenditure(): BelongsTo
    {
        return $this->belongsTo(Expenditure::class);
    }

    /**
     * @param integer $expenditureId
     * @param int $cycleUnit
     * @param integer $paymentDay
     * @param integer|null $paymentMonth
     * @param string $startDate
     * @param string|null $endDate
     * @return void
     */
    public function createFixedExpenditure(
        int $expenditureId,
        int $cycleUnit,
        int $paymentDay,
        ?int $paymentMonth,
        string $startDate,
        ?string $endDate,
        int $userId,
    ): void
    {
        $this->create([
            'expenditure_id' => $expenditureId,
            'cycle_unit' => $cycleUnit,
            'payment_day' => $paymentDay,
            'payment_month' => $paymentMonth,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'user_id' => $userId,
        ]);
    }

    /**
     * @param integer $id
     */
    public function fetchById(int $id): ?self
    {
        return $this->find($id);
    }

    /**
     * @param int $userId
     * @return array
     */
    public function fetchAll(int $userId): array
    {
        return $this->join('expenditures', 'fixed_expenditures.expenditure_id', '=', 'expenditures.id')
                    ->join('expenditure_categories', 'expenditures.category_id', '=', 'expenditure_categories.id')
                    ->where('fixed_expenditures.user_id', $userId)
                    ->select(
                        'fixed_expenditures.*', 
                        'expenditures.name',
                        'expenditures.amount',
                        'expenditure_categories.name as category_name',
                        'expenditure_categories.id as category_id'
                    )
                    ->get()
                    ->toArray();
    }

    /**
     * @param integer $id
     * @param integer $expenditureId
     * @param integer $cycleUnit
     * @param integer $paymentDay
     * @param integer|null $paymentMonth
     * @param string $startDate
     * @param string|null $endDate
     * @return void
     */
    public function updateById(
        int $id,
        int $expenditureId,
        int $cycleUnit,
        int $paymentDay,
        ?int $paymentMonth,
        string $startDate,
        ?string $endDate,
        int $userId,
    ): void {
        $this->where('id', $id)->update([
            'expenditure_id' => $expenditureId,
            'cycle_unit' => $cycleUnit,
            'payment_day' => $paymentDay,
            'payment_month' => $paymentMonth,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'user_id' => $userId,
        ]);
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