<?php
namespace App\FactoryDataManager;

use Symfony\Component\HttpFoundation\Response;
use App\FactoryDataManager\Interfaces\IManagerData;

class JsonManager implements IManagerData
{
    public $filepath = '';
    public $filename = '';

    const CONSTANT_SOURCE_PATH = __DIR__ . '/DataSource/';

    public function __construct()
    {
        $this->filename = 'questions.json';
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

        $string = file_get_contents($this->filepath);
        $result = json_decode($string, true);
        return $result;
    }

    /* to-do implementation in order to save into json file, not finished yetdue to lack of time .*/
    // example array data provided to adapt it and saved it into json file, the keys of the arrays in json are different, it is required to adapt it
    //$data = ["Question text" => $question['Question text'], "created At" => $currentDateTime, "Choice 1"=> $question['choices'][0], "Choice" => $question['choices'][1],"Choice 3" => $question['choices'][2]];

    public function save(array $data) : bool
    {




    }
}