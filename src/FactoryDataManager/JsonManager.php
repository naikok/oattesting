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

    /* @TO-DO implementation in order to save into json file we will be receiving a format that needs to be parsed and adapated to be saved in json file .*/
    //example $data => $data = ["Question text" => $question['Question text'], "created At" => $currentDateTime, "Choice 1"=> $question['choices'][0], "Choice" => $question['choices'][1],"Choice 3" => $question['choices'][2]];

    public function save(array $data) : bool
    {




    }
}