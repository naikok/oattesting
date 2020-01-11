<?php
namespace App\Service;
use App\FactoryDataManager\Interfaces\IManagerData;
use App\FactoryDataManager\ManagerDataFactory;
use App\FactoryPrinter\Interfaces\Printer;
use App\FactoryPrinter\PrinterFactory;
use App\Service\Translators\TranslatorService;

/*
 * Pattern Adapter where we are able to config the main datasource to be managed.
 *
 */
class ManagerDataService
{
    public $manager = null;
    public $printer = null;
    public $translatorService = null;

    public $dataSource = 'json'; //change this param to use a different format datasource (json, csv...) for accessing data and managing data.

    public function __construct(TranslatorService $translatorService)
    {
        $this->manager = ManagerDataFactory::getType($this->dataSource);
        $this->translatorService = $translatorService;
    }

    protected function getManager() : IManagerData
    {
        return $this->manager;
    }

    protected function getPrinter() : Printer
    {
        return $this->printer;
    }

    public function readData() : array
    {
        return $this->manager->readData();
    }

    public function save(array $data) : bool
    {
        return $this->manager->save($data);
    }

    public function readResponseAndParse(array $data) : array
    {
        return $this->getPrinter()->readResponseAndParse($data);
    }

    public function setPrinterWithTranslatorLanguage(string $targetLang) : Printer
    {
        $this->translatorService->setAutoDetectOriginLang($targetLang);
        $this->translatorService->setTargetLang($targetLang);
        $this->printer = PrinterFactory::getType($this->dataSource, $this->translatorService);

        return $this->printer;
    }
}