<?php
namespace App\FactoryDataManager\Interfaces;

interface IManagerData
{
    public function readData() : array;

    public function save(array $data) : bool;
}

