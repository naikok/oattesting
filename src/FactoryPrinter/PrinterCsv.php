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

    /**
     *
     * Function that is the responsible for translating and get output from a specific read file
     * @param array $array
     * Example param array
     * array(2) {
            [0]=>
            array(5) {
                ["Question text"]=>
                string(35) "What is the capital of Luxembourg ?"
                ["Created At"]=>
                string(19) "2019-06-01 00:00:00"
                ["Choice 1"]=>
                string(10) "Luxembourg"
                ["Choice"]=>
                string(5) "Paris"
                ["Choice 3"]=>
                string(6) "Berlin"
            }
            [1]=>
                array(5) {
                ["Question text"]=>
                string(23) "What does mean O.A.T. ?"
                ["Created At"]=>
                string(19) "2019-06-02 00:00:00"
                ["Choice 1"]=>
                string(28) "Open Assignment Technologies"
                ["Choice"]=>
                string(28) "Open Assessment Technologies"
                ["Choice 3"]=>
                string(32) "Open Acknowledgment Technologies"
                }
            }
     * @return array ([Question object])
     *
     */
    public function readResponseAndParse(array $data) : array
    {
        $questionObjects = [];

        if (!empty($data) && is_array($data)) {
            foreach ($data as $key => $val) {
                $questionObject = new Question();
                $choices = [];

                foreach ($val as $index => $item) {
                    if ($index == "Question text") {
                        $questionObject->setText($this->translatorService->translate($item));
                    } else if ($index == "Created At") {
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
        }

        return $questionObjects;
    }
}