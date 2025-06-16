<?php

declare(strict_types=1);

namespace App\Http\Controllers\Report;

use DateTime;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Income as IncomeModel;
use App\Models\Expenditure as ExpenditureModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Infrastructure\Adaptor\Date\DateConverter;
use App\Infrastructure\Query\Income\IncomeQueryService;
use App\Infrastructure\Query\Expenditure\ExpenditureQueryService;
use App\Infrastructure\Adaptor\Calculation\CategoryAmountCalculater;
use App\Application\Service\AuthService;

final class ReportController extends Controller
{
    private readonly AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    /**
     * レポートのインデックスページを表示
     */
    public function saving(Request $request): string
    {
        $startDate = date('Y-m-d', strtotime($request->input('start_date')));
        $endDate = date('Y-m-t', strtotime($request->input('end_date')));
        $expenditureInfoList = $this->fetchFinancialData(
            'expenditure',
            $startDate,
            $endDate
        );

        $incomeInfoList = $this->fetchFinancialData(
            'income',
            $startDate,
            $endDate
        );

        return json_encode([
            'incomeDataList' => $incomeInfoList,
            'expenseDataList' => $expenditureInfoList
        ]);
    }

    public function getCategoryToAmountList(Request $request): array
    {
        $startDate = date('Y-m-d', strtotime($request->input('start_date')));
        $endDate = date('Y-m-t', strtotime($request->input('end_date')));

        $incomeInfoList = $this->fetchFinancialData('income', $startDate, $endDate);
        $expenditureInfoList = $this->fetchFinancialData('expenditure', $startDate, $endDate);

        return [
            'incomeDataList' => $incomeInfoList,
            'expenseDataList' => $expenditureInfoList
        ];
    }

    /**
     * 支出レポートページを表示
     */
    public function expense(Request $request): string
    {
        $startDate = date('Y-m-d', strtotime($request->input('start_date')));
        $endDate = date('Y-m-t', strtotime($request->input('end_date')));

        $expenseInfoList = $this->fetchFinancialData(
            'expenditure',
            $startDate,
            $endDate
        );

        return json_encode([
            'expenseInfoList' => $expenseInfoList,
        ]);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function fetchExpenseInfoList(Request $request): array
    {
        $startDate = date('Y-m-d', strtotime($request->input('start_date')));
        $endDate = date('Y-m-t', strtotime($request->input('end_date')));

        return $this->fetchFinancialData('expenditure', $startDate, $endDate);
    }

    /**
     * データタイプに基づいてクエリサービスと関連データを取得する
     * 
     * @param string $type income または expenditure
     * @param string $startDate 開始日
     * @param string $endDate 終了日
     * @return array [queryService, oneTimeDataList, fixedDataList, keyName]
     */
    private function createFinancialDataFactory(string $type, string $startDate, string $endDate): array
    {
        $userId = $this->authService->getCurrentUserId();
        
        if ($type === 'income') {
            $queryService = new IncomeQueryService(
                new IncomeModel()
            );
            $oneTimeDataList = $queryService->fetchOneTimeIncome($startDate, $endDate, $userId);
            $fixedDataList = $queryService->fetchFixedIncome($userId);

            return [
                'queryService' => $queryService,
                'oneTimeDataList' => $oneTimeDataList,
                'fixedDataList' => $fixedDataList,
                'keyName' => 'payment_day'
            ];
        }

        $queryService = new ExpenditureQueryService(
            new ExpenditureModel()
        );

        $oneTimeDataList = $queryService->fetchOneTimeExpenditure($startDate, $endDate, $userId);
        $fixedDataList = $queryService->fetchFixedExpenditure($userId);

        return [
            'queryService' => $queryService,
            'oneTimeDataList' => $oneTimeDataList,
            'fixedDataList' => $fixedDataList,
            'keyName' => 'payment_day'
        ];
    }

    /**
     * 収入または支出データを取得
     * 
     * @param string $type income または expenditure
     * @param string $startDate 開始日
     * @param string $endDate 終了日
     * @return array
     */
    private function fetchFinancialData(string $type, string $startDate, string $endDate): array
    {
        $financialInfoList = $this->createFinancialDataFactory($type, $startDate, $endDate);
        $oneTimeDataList = $financialInfoList['oneTimeDataList'];
        $fixedDataList = $financialInfoList['fixedDataList'];
        $keyName = $financialInfoList['keyName'];

        $requestStartDate = new DateTime($startDate);
        $requestEndDate = new DateTime($endDate);

        $targetFixedDataList = [];
        foreach ($fixedDataList as $fixedData) {
            $dataStartDate = new DateTime($fixedData['start_date']);
            $dataEndDate = $fixedData['end_date'] ? new DateTime($fixedData['end_date']) : null;

            if ($dataEndDate && $dataEndDate < $requestStartDate) {
                continue;
            }

            if ($dataStartDate > $requestEndDate) {
                continue;
            }

            $currentDate = clone $requestStartDate;

            while ($currentDate <= $requestEndDate) {
                $paymentDate = clone $currentDate;
                $paymentDate->setDate(
                    (int)$currentDate->format('Y'),
                    (int)$currentDate->format('m'),
                    (int)$fixedData[$keyName]
                );

                $isAfterStartDate = !$dataStartDate || $paymentDate >= $dataStartDate;
                $isBeforeEndDate = !$dataEndDate || $paymentDate <= $dataEndDate;

                $isInPeriod = $isAfterStartDate && $isBeforeEndDate;

                if ($isInPeriod) {
                    $newData = $fixedData;
                    $newData['calendar_date'] = $paymentDate->format('Y-m-d');
                    $targetFixedDataList[] = $newData;
                }

                $currentDate->modify('+1 month');
            }
        }

        $dataList = array_merge($oneTimeDataList, $targetFixedDataList);

        $categoryAmountCalculater = new CategoryAmountCalculater(
            new DateConverter()
        );

        $categoryToAmountList = $categoryAmountCalculater->calculate($dataList);

        return [
            'category_to_amount_list' => $categoryToAmountList
        ];
    }
}
