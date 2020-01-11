<?php
namespace App\FactoryDataManager;

use Symfony\Component\HttpFoundation\Response;
use App\FactoryDataManager\Interfaces\IManagerData;
use App\Entity\Question;
use App\Entity\Choice;

class CsvManager implements IManagerData
{
    public $filepath = '';
    public $filename = '';

    const CONSTANT_SOURCE_PATH = __DIR__ . '/DataSource/';

    public function __construct()
    {
        $this->filename = 'questions.csv';
        $this->filepath = self::CONSTANT_SOURCE_PATH . $this->filename;
    }

    private function checkIfFileExistsOnPath(string $filepath) : bool
    {
        return file_exists($filepath);
    }

    public function readData() : array
    {
        if ($this->checkIfFileExistsOnPath($this->filepath) === false) {
            return [];
        }

        $csv = array_map("str_getcsv", file($this->filepath,FILE_SKIP_EMPTY_LINES));
        $keys = array_shift($csv);

        foreach ($csv as $i=>$row) {
            $csv[$i] = array_combine($keys, $row);
        }

        return $csv;
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


    public function save(array $data) : bool
    {
        $dataList = [$data];
        try{
            $file = fopen($this->filepath, 'a');
            foreach ($dataList as $field) {
                fputcsv($file, $field);
            }
            fclose($file);
            return true;
        } catch (\Exception $e){
            return false;
        }
    }
}