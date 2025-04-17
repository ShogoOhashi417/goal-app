<?php

declare(strict_types=1);

namespace App\Infrastructure\Util;

class CsvExporter
{
    /**
     * CSVデータを生成する
     *
     * @param array $header ヘッダー行
     * @param array $data データ行
     * @return string CSVデータ
     */
    public function generate(array $header, array $data): string
    {
        $csvData = [];
        
        $csvData[] = chr(0xEF) . chr(0xBB) . chr(0xBF) . implode(',', $header);
        
        foreach ($data as $row) {
            $csvData[] = implode(',', $row);
        }
        
        return implode("\n", $csvData);
    }
    
    /**
     * CSVレスポンスを生成する
     *
     * @param array $header ヘッダー行
     * @param array $data データ行
     * @param string $filename ファイル名
     * @return \Illuminate\Http\Response
     */
    public function export(array $header, array $data, string $filename): \Illuminate\Http\Response
    {
        $csvContent = $this->generate($header, $data);
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        return response($csvContent, 200, $headers);
    }
    
    /**
     * CSVフィールドをエスケープ処理
     * 
     * @param string $field
     * @return string
     */
    public function escapeField(string $field): string
    {
        return '"' . str_replace('"', '""', $field) . '"';
    }
} 