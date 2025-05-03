<?php

declare(strict_types=1);

namespace App\Application\UseCase\CSV\Export;

use DateTime;
use App\Infrastructure\Util\CsvExporter;
use App\Application\Query\Expenditure\ExpenditureQueryServiceInterface;

final readonly class ExportExpenditureCsvUseCase
{
    public function __construct(
        private ExpenditureQueryServiceInterface $query,
        private CsvExporter $csvExporter
    ) {}

    public function handle(?string $startDate = null, ?string $endDate = null, string $format = 'detailed'): array
    {
        if ($startDate) {
            $startDate = (new DateTime($startDate))->format('Y-m-d');
        }

        if ($endDate) {
            $endDate = (new DateTime($endDate))->format('Y-m-d');
        }

        $header = ['ID', '支払日', '項目名', '金額', 'カテゴリー'];
        
        $expenditureList = $this->query->fetchByDateRange($startDate, $endDate);

        $data = [];
        foreach ($expenditureList as $expenditure) {
            $data[] = [
                $expenditure['id'],
                $expenditure['calendar_date'],
                $this->csvExporter->escapeField($expenditure['name']),
                $expenditure['amount'],
                $this->csvExporter->escapeField($expenditure['category_name'])
            ];
        }

        return [
            'header' => $header,
            'data' => $data
        ];
    }
} 