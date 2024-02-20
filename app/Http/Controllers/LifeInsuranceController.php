<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Infrastructure\LifeInsurance\LifeInsuranceRepository;
use App\Application\UseCase\LifeInsurance\Read\ReadLifeInsuranceUseCase;

class LifeInsuranceController extends Controller
{
    public function index()
    {
        $readLifeInsuranceUseCase = new ReadLifeInsuranceUseCase(
            new LifeInsuranceRepository()
        );

        $lifeInsuranceInfoList = $readLifeInsuranceUseCase->handle();

        return view('life_insurance', [
            'life_insurance_info_list' => $lifeInsuranceInfoList
        ]);
    }
}
