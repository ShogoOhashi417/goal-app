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
        'payment_date'
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
     * @param string $cycleUnit
     * @param integer $paymentDay
     * @param integer|null $paymentMonth
     * @param string $startDate
     * @param string|null $endDate
     * @param string $paymentDate
     * @return void
     */
    public function createFixedExpenditure(
        int $expenditureId,
        string $cycleUnit,
        int $paymentDay,
        ?int $paymentMonth,
        string $startDate,
        ?string $endDate,
        string $paymentDate
    ): void
    {
        $this->create([
            'expenditure_id' => $expenditureId,
            'cycle_unit' => $cycleUnit,
            'payment_day' => $paymentDay,
            'payment_month' => $paymentMonth,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'payment_date' => $paymentDate
        ]);
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
     * @return array
     */
    public function fetchAll(): array
    {
        return $this->join('expenditures', 'fixed_expenditures.expenditure_id', '=', 'expenditures.id')
                    ->join('expenditure_categories', 'expenditures.category_id', '=', 'expenditure_categories.id')
                    ->select(
                        'fixed_expenditures.*', 
                        'expenditures.name',
                        'expenditures.amount',
                        'expenditure_categories.name as category_name'
                    )
                    ->get()
                    ->toArray();
    }

    /**
     * @param integer $id
     * @param integer $expenditureId
     * @param string $cycleUnit
     * @param integer $paymentDay
     * @param integer|null $paymentMonth
     * @param string $startDate
     * @param string|null $endDate
     * @param string $paymentDate
     * @return void
     */
    public function updateById(
        int $id,
        int $expenditureId,
        string $cycleUnit,
        int $paymentDay,
        ?int $paymentMonth,
        string $startDate,
        ?string $endDate,
        string $paymentDate
    ): void {
        $this->where('id', $id)->update([
            'expenditure_id' => $expenditureId,
            'cycle_unit' => $cycleUnit,
            'payment_day' => $paymentDay,
            'payment_month' => $paymentMonth,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'payment_date' => $paymentDate
        ]);
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