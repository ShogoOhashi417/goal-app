<?php

declare(strict_types=1);

namespace App\Http\Controllers\Income;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IncomeController extends Controller
{
    public function index()
    {
        return view('view.income.index');
    }
}
