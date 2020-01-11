<?php

namespace App\Entity;

class Question
{
    public $text;

    public $createdAt;

    public $choices;


    public function getText() : string
    {
        return $this->text;
    }

    public function setText(string $text)
    {
        $this->text = $text;
    }

    public function getCreatedAt() : string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getChoices(array $choices) : array
    {
        $this->choices= $choices;
    }

    public function setChoices(array $choices)
    {
         $this->choices= $choices;
    }
}
