<?php
namespace App\FactoryPrinter;

use App\Entity\Question;
use App\Entity\Choice;
use App\Service\Translators\TranslatorService;
use App\FactoryPrinter\Interfaces\Printer;

class PrinterJson implements Printer
{
    public $translatorService = null;

    public function __construct(TranslatorService $translatorService)
    {
        $this->translatorService = $translatorService;
    }

    public function readResponseAndParse(array $data) : array
    {
        $questionObjects = [];

        if (!empty($data) && is_array($data)) {
            foreach ($data as $key => $val) {
                $questionObject = new Question();
                $choices = [];

                foreach ($val as $index => $item) {
                    if ($index == "text") {
                        $questionObject->setText($this->translatorService->translate($item));
                    } else if ($index == "CreatedAt") {
                        $questionObject->setCreatedAt($this->translatorService->translate($item));
                    } else {
                        if (is_array($item) && !empty($item)) {
                            foreach ($item as $value) {
                                $choice = new Choice();
                                $choice->setText($this->translatorService->translate($value['text']));
                                $choices[] = $choice;
                            }
                        }
                    }
                }

                $questionObject->setChoices($choices);
                $questionObjects[] = $questionObject;
            }
        }

        return $questionObjects;
    }
}