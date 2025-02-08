<?php

namespace App\Application\UseCase\CSV\Export;

use Symfony\Component\HttpFoundation\StreamedResponse;

final readonly class ExportSampleExpenditureCsvUseCase 
{
    public function handle(): StreamedResponse
    {
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=csvexport.csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function()
        {
            $createCsvFile = fopen('php://output', 'w');
            
            $columns = [
                '支払日',
                '項目名',
                '金額',
                'カテゴリー',
            ];

            mb_convert_variables('SJIS-win', 'UTF-8', $columns);

            fputcsv($createCsvFile, $columns);
                $csv = [
                    '2024/11/1',
                    'スーパー',
                    '2000',
                    '食費'
                ];

                mb_convert_variables('SJIS-win', 'UTF-8', $csv);

                fputcsv($createCsvFile, $csv);
            fclose($createCsvFile);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}