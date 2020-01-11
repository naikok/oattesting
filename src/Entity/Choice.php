<?php

namespace App\Entity;

class Choice
{
    public $text;

    public function getText() : string
    {
        return $this->text;
    }

    public function setText(string $text)
    {
        $this->text = $text;
    }

}
