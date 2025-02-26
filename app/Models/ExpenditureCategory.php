<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenditureCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

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
     * @return void
     */
    public function createExpenditureCategory(string $name): void
    {
        $this->create(
            [
                'name' => $name,
            ]
        );
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
    public function updateById(int $id, string $name): void
    {
        $this->where('id', $id)->update(['name' => $name]);
    }
}
