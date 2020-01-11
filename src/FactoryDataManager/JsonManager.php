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
            throw new \Exception('Json file could not be read as the filepath was not found' . $this->filepath, Response::HTTP_NOT_FOUND);
        }

        $string = file_get_contents($this->filepath);
        $result = json_decode($string, true);
        return $result;
    }

    /* to-do implementation in order to save into json file .*/

    public function save(array $data) : bool
    {




    }
}