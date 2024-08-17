<?php

declare(strict_types=1);

namespace App\Http\Controllers\Income;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IncomeController extends Controller
{
    public function index()
    {
        // todo ダミーデータ
        $income_info_list = [
            [
                'name' => '給料',
                'amount' => 300000
            ],
        ];

        return view('view.income.index', [
            'income_info_list' => $income_info_list
        ]);
    }
}
