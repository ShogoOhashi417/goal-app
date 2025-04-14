<?php

declare(strict_types=1);

namespace App\Application\UseCase\CSV\Export;

final readonly class ExportSampleExpenditureCsvUseCase 
{
    public function handle(): array
    {
        $header = ['支払日', '項目名', '金額', 'カテゴリー'];
        
        $data = [
            ['2024/11/1', 'スーパー', '2000', '食費']
        ];
        
        return [
            'header' => $header,
            'data' => $data
        ];
    }
}