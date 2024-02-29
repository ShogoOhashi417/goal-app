<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Infrastructure\LifeInsurance\LifeInsuranceRepository;
use App\Application\UseCase\LifeInsurance\Read\ReadLifeInsuranceUseCase;
use App\Application\UseCase\LifeInsurance\Create\CreateLifeInsuranceUseCase;
use App\Application\UseCase\LifeInsurance\Delete\DeleteLifeInsuranceUseCase;
use Exception;

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

    public function get() {
        $readLifeInsuranceUseCase = new ReadLifeInsuranceUseCase(
            new LifeInsuranceRepository()
        );

        return [
            'life_insurance_info_list' => $readLifeInsuranceUseCase->handle()
        ];
    }

    public function create(Request $request)
    {
        $createLifeInsuranceUseCase = new CreateLifeInsuranceUseCase(
            new LifeInsuranceRepository()
        );

        try {
            $createLifeInsuranceUseCase->handle(
                $request->id ?? 0,
                $request->life_insurance_name,
                $request->fee,
                $request->payment_type,
                $request->insurance_type
            );
        } catch (RuntimeException $exception) {
            return [
                'message' => '生命保険の登録に失敗しました。お手数ですが再度処理を実行してください。',
                'result_status' => 'error'
            ];
        } catch (Exception $e) {
            return [
                'message' => '生命保険の登録に失敗しました。' . $e->getMessage(),
                'result_status' => 'error'
            ];
        }
    }

    public function remove(Request $request)
    {
        $deleteLifeInsuranceUseCase = new DeleteLifeInsuranceUseCase(
            new LifeInsuranceRepository()
        );

        $deleteLifeInsuranceUseCase->handle($request->id);

        return '削除した';
    }
}
