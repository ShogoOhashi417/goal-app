<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

final class FixedIncome extends Model
{
    use HasFactory;

    protected $fillable = [
        'income_id',
        'cycle_unit',
        'payment_day',
        'payment_month',
        'start_date',
        'end_date',
        'user_id',
    ];

    /**
     * Get the income that owns the fixed income.
     */
    public function income(): BelongsTo
    {
        return $this->belongsTo(Income::class);
    }

    /**
     * @param integer $incomeId
     * @param string $cycleUnit
     * @param integer $paymentDay
     * @param integer|null $paymentMonth
     * @param string $startDate
     * @param string|null $endDate
     * @return void
     */
    public function createFixedIncome(
        int $incomeId,
        int $cycleUnit,
        int $paymentDay,
        ?int $paymentMonth,
        string $startDate,
        ?string $endDate,
        int $userId,
    ): void {
        $this->create([
            'income_id' => $incomeId,
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
	 * @return ?FixedIncome
	 */
	public function fetchById(int $id): ?FixedIncome
	{
		return $this->find($id);
	}
    // /**
    //  * @return array
    //  */
    // public function fetchAll(): array
    // {
    //     return $this->join('incomes', 'fixed_incomes.income_id', '=', 'incomes.id')
    //         ->join('income_categories', 'incomes.category_id', '=', 'income_categories.id')
    //         ->select(
    //             'fixed_incomes.*',
    //             'incomes.name',
    //             'incomes.amount',
    //             'income_categories.name as category_name'
    //         )
    //         ->get()
    //         ->toArray();
    // }

    /**
     * @param integer $id
     * @param integer $cycleUnit
     * @param integer $paymentDay
     * @param integer|null $paymentMonth
     * @param string $startDate
     * @param string|null $endDate
     * @return void
     */
    public function updateById(
        int $id,
        int $cycleUnit,
        int $paymentDay,
        ?int $paymentMonth,
        string $startDate,
        ?string $endDate,
    ): void {
        $this->where('income_id', $id)->update([
            'cycle_unit' => $cycleUnit,
            'payment_day' => $paymentDay,
            'payment_month' => $paymentMonth,
            'start_date' => $startDate,
            'end_date' => $endDate,
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

    /**
     * ユーザーIDでフィルタリングし、関連テーブルを結合するメソッド
     * 
     * @param int $userId
     * @return Builder
     */
    public function fetchAll(int $userId): Builder
    {
        return $this->join('incomes', 'fixed_incomes.income_id', '=', 'incomes.id')
            ->join('income_categories', 'incomes.category_id', '=', 'income_categories.id')
            ->where('incomes.user_id', $userId)
            ->select(
                'fixed_incomes.*',
                'incomes.id',
                'incomes.name',
                'incomes.amount',
                'incomes.category_id',
                'income_categories.name as category_name'
            );
    }
}
