<?php

namespace App\Utils;

use Symfony\Component\Console\Exception\InvalidArgumentException;


class Validator
{
    public function __construct()
    {

    }

    public function validateQuery(string $query): string
    {
        if (empty($query)) {
            throw new InvalidArgumentException('The query can not be empty.');
        }

        return $query;
    }
}
