<?php

declare(strict_types=1);

namespace App\Http\Controllers\HouseholdManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

final class HouseholdManagementController extends Controller
{
    public function index()
    {
        return view('view.household_management.index');
    }
}
