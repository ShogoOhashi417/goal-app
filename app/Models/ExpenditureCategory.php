<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExpenditureCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    /**
     * @return array
     */
    public function fetchAll(): array
    {
        return $this->all()->toArray();
    }

    /**
     * @param integer $id
     * @return array
     */
    public function fetchById(int $id): array
    {
        return $this->where('id', $id)->get()->toArray();
    }

    /**
     * @param string $name
     * @param integer $userId
     * @return array
     */
    public function createExpenditureCategory(string $name, int $userId): array
    {
        $category = $this->create(
            [
                'name' => $name,
                'user_id' => $userId
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
     * @return array
     */
    public function updateById(int $id, string $name): array
    {
        $this->where('id', $id)->update(['name' => $name]);
        return $this->where('id', $id)->first()->toArray();
    }
}
