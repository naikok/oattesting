<?php
namespace App\FactoryPrinter;

use App\FactoryPrinter\Interfaces\Printer;
use App\Service\Translators\TranslatorService;

class PrinterFactory
{
    public static function getType(string $type, TranslatorService $translatorService) : Printer
    {
        $instance = null;

        switch ($type) {
            case 'json':
                $instance = new PrinterJson($translatorService);
                break;
            case 'csv':
                $instance = new PrinterCsv($translatorService);
                break;
            default:
                throw new \Exception('Error when creating a new printer service', Response::NOT_FOUND);
                break;
        }

        return $instance;
    }
}