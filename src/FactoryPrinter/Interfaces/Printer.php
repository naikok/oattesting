<?php
namespace App\FactoryPrinter\Interfaces;

interface Printer
{
    public function readResponseAndParse(array $data) : array;
}
