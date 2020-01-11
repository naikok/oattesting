<?php
namespace App\BusinessService;

use App\Service\Translators\TranslatorService;
use App\Service\ManagerDataService;
use App\Entity\Question;
use App\Entity\Choice;

class ExecutorService
{
    public $translatorService = null;
    public $managerDataService = null;

    public function __construct(ManagerDataService $managerDataService)
    {
        $this->managerDataService = $managerDataService;
    }

    public function readDataQuestionsToLanguage(string $lang) : array
    {
        $data = $this->managerDataService->readData();
        $this->managerDataService->setPrinterWithTranslatorLanguage($lang);
        return $this->managerDataService->readResponseAndParse($data);
    }

    public function saveData(array $data) : bool
    {
        return $this->managerDataService->saveData($data);
    }
}
