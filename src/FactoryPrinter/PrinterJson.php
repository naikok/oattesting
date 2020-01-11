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

    /**
     *
     * Function that is the responsible for translating and get output from a specific read file
     * @param array $array
     * Example array passed as parameter
     * array(2) {
            [0]=>
            array(3) {
                    ["text"]=>
                    string(35) "What is the capital of Luxembourg ?"
                    ["createdAt"]=>
                    string(19) "2019-06-01 00:00:00"
                    ["choices"]=>
                    array(3) {
                        [0]=>
                        array(1) {
                        ["text"]=>
                        string(10) "Luxembourg"
                        }
                        [1]=>
                        array(1) {
                        ["text"]=>
                        string(5) "Paris"
                        }
                        [2]=>
                        array(1) {
                        ["text"]=>
                        string(6) "Berlin"
                        }
                    }
            }
            [1]=>
            array(3) {
                ["text"]=>
                string(23) "What does mean O.A.T. ?"
                ["createdAt"]=>
                string(19) "2019-06-02 00:00:00"
                ["choices"]=>
                    array(3) {
                    [0]=>
                    array(1) {
                    ["text"]=>
                    string(28) "Open Assignment Technologies"
                    }
                    [1]=>
                    array(1) {
                    ["text"]=>
                    string(28) "Open Assessment Technologies"
                     }
                    [2]=>
                    array(1) {
                    ["text"]=>
                    string(32) "Open Acknowledgment Technologies"
                    }
                }
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