<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domain\LifeInsurance\PaymentType;
use App\Domain\LifeInsurance\InsuranceType;

class LifeInsurance extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'fee', 'payment_type', 'type'];

    public function getPaymentTypeAttribute($value)
    {
        return PaymentType::from($value)->toString();
    }

    public function getTypeAttribute($value)
    {
        return InsuranceType::from($value)->toString();
    }
}
