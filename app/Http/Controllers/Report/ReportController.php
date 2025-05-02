<?php

declare(strict_types=1);

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class ReportController extends Controller
{
    /**
     * レポートのインデックスページを表示
     */
    public function saving(): Response
    {
        $savingData = $this->fetchSavingData();

        return Inertia::render('Report/Balance/Index', [
            'savingData' => $savingData
        ]);
    }

    /**
     * 支出レポートページを表示
     */
    public function expense(): Response
    {
        return Inertia::render('Report/Expense/Index');
    }

    private function fetchSavingData(): array
    {
        $savingData = [];

        return $savingData;
    }
    
}
