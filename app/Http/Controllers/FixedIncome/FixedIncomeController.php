<?php

declare(strict_types=1);

namespace App\Http\Controllers\FixedIncome;

use Inertia\Inertia;
use App\Models\Income;
use Illuminate\Http\Request;
use App\Models\IncomeCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Domain\Model\FixedIncome\CycleUnit;
use App\Models\FixedIncome as FixedIncomeModel;
use App\Infrastructure\Repository\FixedIncomeRepository;
use App\Infrastructure\Repository\Income\IncomeRepository;
use App\Application\UseCase\FixedIncome\FetchFixedIncomeUseCase;
use App\Application\UseCase\FixedIncome\CreateFixedIncomeUseCase;
use App\Application\UseCase\FixedIncome\DeleteFixedIncomeUseCase;
use App\Application\UseCase\FixedIncome\UpdateFixedIncomeUseCase;
use App\Infrastructure\Query\FixedIncome\FixedIncomeQueryService;
use App\Application\UseCase\FixedIncome\Input\CreateFixedIncomeInputData;
use App\Application\UseCase\FixedIncome\Input\DeleteFixedIncomeInputData;
use App\Application\UseCase\FixedIncome\Input\UpdateFixedIncomeInputData;
use App\Application\UseCase\Category\Income\Fetch\FetchIncomeCategoryUseCase;

class FixedIncomeController extends Controller
{
    public function index()
    {
        $fixedIncomes = $this->fetchFixedIncomes();

		$fetchIncomeCategoryUseCase = new FetchIncomeCategoryUseCase(
            new IncomeCategory()
        );

        $incomeCategoryInfoList = $fetchIncomeCategoryUseCase->handle();

        return Inertia::render('Income/Fixed', [
            'incomeDataList' => $fixedIncomes,
            'IncomeCategoryDataList' => $incomeCategoryInfoList,
        ]);
    }

	public function get()
	{
		$fixedIncomes = $this->fetchFixedIncomes();
		$incomeCategoryInfoList = $this->fetchIncomeCategoryInfoList();

		return response()->json([
			'fixedIncomes' => $fixedIncomes,	
			'incomeCategoryInfoList' => $incomeCategoryInfoList,
		]);
	}

    private function fetchIncomeCategoryInfoList(): array
    {
        $fetchIncomeCategoryUseCase = new FetchIncomeCategoryUseCase(
            new IncomeCategory()
        );

        return $fetchIncomeCategoryUseCase->handle();
    }

    /**
     * @return array
     */
    private function fetchFixedIncomes(): array
    {
        $fetchFixedIncomeUseCase = new FetchFixedIncomeUseCase(
            new FixedIncomeQueryService(
                new FixedIncomeModel()
            )
        );

        $fixedIncomes = $fetchFixedIncomeUseCase->handle();
        
        $result = [];
        foreach ($fixedIncomes as $item) {
            $result[] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'amount' => $item['amount'],
                'category_id' => $item['category_id'],
                'category_name' => $item['category_name'] ?? '',
                'cycle_unit' => $item['cycle_unit'],
                'payment_day' => $item['payment_day'],
                'payment_month' => $item['payment_month'],
                'period_start_date' => $item['start_date'],
                'period_end_date' => $item['end_date'],
                'period_type' => (int)$item['cycle_unit'] === CycleUnit::MONTH->value ? 'month' : 'year',
            ];
        }
        
        return $result;
    }

    public function create(Request $request)
    {
        $createFixedIncomeUseCase = new CreateFixedIncomeUseCase(
            new IncomeRepository(
                new Income()
			),
			new FixedIncomeRepository(
                new FixedIncomeModel()
            )
        );

        $createFixedIncomeUseCase->handle(
            new CreateFixedIncomeInputData(
                $request->income_name,
                (int)$request->income_category_id,
                (int)$request->income_amount,
                (int)$request->cycle_unit,
                (int)$request->payment_day,
                $request->payment_month ? (int)$request->payment_month : null,
                $request->period_start_date,
                $request->period_end_date,
                Auth::id()
            )
        );

        return response()->json(['status' => 'success']);
    }

    public function update(Request $request, int $id)
    {
        $updateFixedIncomeUseCase = new UpdateFixedIncomeUseCase(
            new IncomeRepository(
                new Income()
            ),
            new FixedIncomeRepository(
                new FixedIncomeModel()
            )
        );

        $updateFixedIncomeUseCase->handle(
            new UpdateFixedIncomeInputData(
                $id,
                $request->income_name,
                (int)$request->income_category_id,
                (int)$request->income_amount,
                (int)$request->cycle_unit,
                (int)$request->payment_day,
                $request->payment_month ? (int)$request->payment_month : null,
                $request->period_start_date,
                $request->period_end_date,
                Auth::id()
            )
        );

        return response()->json(['status' => 'success']);
    }

    public function delete(int $id)
    {
        $deleteFixedIncomeUseCase = new DeleteFixedIncomeUseCase(
            new IncomeRepository(
                new Income()
            ),
            new FixedIncomeRepository(
                new FixedIncomeModel()
            )
        );

        $deleteFixedIncomeUseCase->handle(
            new DeleteFixedIncomeInputData($id, Auth::id())
        );

        return response()->json(['status' => 'success']);
    }
}
