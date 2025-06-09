<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    /**
     * @param int $userId
     * @return array
     */
    public function fetchAll(int $userId): array
    {
        return $this->where('user_id', $userId)->get()->toArray();
    }

    /**
     * @param integer $id
     * @return array
     */
    public function fetchById(int $id, int $userId): array
    {
        return $this->where('id', $id)->where('user_id', $userId)->get()->toArray();
    }

    /**
     * @param string $name
     * @param int $userId
     * @return array
     */
    public function createIncomeCategory(string $name, int $userId): array
    {
        $category = $this->create(
            [
                'name' => $name,
                'user_id' => $userId,
            ]
        );
        
        return $category->toArray();
    }

    /**
     * @param integer $id
     * @return void
     */
    public function deleteById(int $id): void
    {
        $this->where('id', $id)->delete();
    }

    /**
     * @param integer $id
     * @param string $name
     * @return void
     */
    public function updateIncomeCategory(int $id, string $name): void
    {
        $this->where('id', $id)->update(['name' => $name]);
    }
}
