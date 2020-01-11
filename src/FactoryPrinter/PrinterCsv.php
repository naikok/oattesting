<?php
namespace App\FactoryPrinter;

use App\Entity\Question;
use App\Entity\Choice;
use App\Service\Translators\TranslatorService;
use App\FactoryPrinter\Interfaces\Printer;

class PrinterCsv implements Printer
{
    public $translatorService = null;

    public function __construct(TranslatorService $translatorService)
    {
        $this->translatorService = $translatorService;
    }

    public function readResponseAndParse(array $data) : array
    {
        $questionObjects = [];

        foreach ($data as $key => $val) {
            $questionObject = new Question();
            $choices = [];

            foreach($val as $index=>$item) {
                if ($index == "Question text"){
                    $questionObject->setText( $this->translatorService->translate($item));
                } else if ($index == "Created At"){
                    $questionObject->setCreatedAt($this->translatorService->translate($item));
                } else {

                    $choice = new Choice();
                    $choice->setText($this->translatorService->translate($item));

                    $choices[] = $choice;
                }
            }
            $questionObject->setChoices($choices);
            $questionObjects[] = $questionObject;
        }

        return $questionObjects;
    }
}