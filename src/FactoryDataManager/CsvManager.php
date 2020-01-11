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