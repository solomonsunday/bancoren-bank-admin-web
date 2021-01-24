<?php

namespace App\Interfaces;


interface IBase
{
    public function selectAll(array $selects);
    public function create(array $data);
    public function findItem(array $condition);
    public function updateItem(array $condition, array $data);
    public function getAll();
    public function getItem(array $condition, array $selects);
    public function selectItem(array $condition, array $selects);
    public function selectItems(array $condition, array $selects);
    public function deleteItem(array $condition);
    public function new_insert($selects);
}
