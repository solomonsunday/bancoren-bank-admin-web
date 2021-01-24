<?php

namespace App\Repos;

use App\Interfaces\IBase;
use Illuminate\Support\Facades\DB;

class Base implements IBase
{
    protected $table_name;

    public function __construct($table_name)
    {
        $this->table_name = $table_name;
    }

    public function selectAll(array $selects)
    {
        return  DB::table($this->table_name)->select($selects)->orderByDesc('created_at')->get();
    }

    public function create(array $data)
    {
        return DB::table($this->table_name)->insertGetId($data);
    }

    public function findItem(array $condition)
    {
        return DB::table($this->table_name)->where($condition)->first();
    }

    public function updateItem(array $condition, array $data)
    {
        return DB::table($this->table_name)->where($condition)->update($data);
    }


    public function getAll()
    {
        return DB::table($this->table_name)->orderByDesc('id')->get();
    }

    public function getItem(array $condition, array $selects)
    {
        return DB::table($this->table_name)->where($condition)->select($selects)->orderByDesc('created_at')->get();
    }

    public function selectItem(array $condition, array $selects)
    {
        return  DB::table($this->table_name)
            ->where($condition)->select($selects)->first();
    }

    public function selectItems(array $condition, array $selects)
    {
        return  DB::table($this->table_name)
            ->where($condition)->select($selects)->orderByDesc('created_at')->get();
    }

    public function deleteItem(array $condition)
    {
        return DB::table($this->table_name)->where($condition)->delete();
    }

    public function new_insert($selects)
    {
        return DB::table($this->table_name)->orderByDesc('id')->select($selects)->first();
    }
}
