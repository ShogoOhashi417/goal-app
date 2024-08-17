<?php

declare(strict_types=1);

namespace App\Http\Controllers\Expenditure;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpenditureController extends Controller
{
    public function index()
    {
        return view('view.expenditure.index');
    }
}
