<?php

declare(strict_types=1);

namespace App\Http\Controllers\Expenditure;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpenditureController extends Controller
{
    public function index()
    {
        // todo ダミーデータ
        $expenditure_info_list = [
            [
                'name' => '家賃',
                'amount' => 105000
            ],
            [
                'name' => '電気料金',
                'amount' => 3000
            ],
        ];

        return view('view.expenditure.index', [
            'expenditure_info_list' => $expenditure_info_list
        ]);
    }
}
