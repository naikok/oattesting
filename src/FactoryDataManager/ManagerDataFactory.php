<?php
namespace App\FactoryDataManager;

use App\FactoryDataManager\Interfaces\IManagerData;
use Symfony\Component\HttpFoundation\Response;
use App\FactoryDataManager\CsvManager;
use App\FactoryDataManager\JsonManager;

class ManagerDataFactory
{
    public static function getType(string $type) : IManagerData
    {
        $instance = null;

        switch ($type) {
            case 'csv':
                $instance = new CsvManager();
                break;
            case 'json':
                $instance = new JsonManager();
                break;
            default:
                throw new \Exception('Error when creating a new Manager to handle the data', Response::NOT_FOUND);
                break;
        }

        return $instance;
    }
}