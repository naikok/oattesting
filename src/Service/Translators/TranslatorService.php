<?php
namespace App\Service\Translators;

use Stichoza\GoogleTranslate\GoogleTranslate;


class TranslatorService
{
    protected static $instance = null;

    public function __construct(GoogleTranslate $googleTranslate)
    {
        self::$instance = $googleTranslate;
    }

    protected function getClient()
    {
        return self::$instance;
    }

    public function setOriginLang(string $lang) : void
    {
        $this->getClient()->setSource($lang);
    }

    public function setAutoDetectOriginLang() : void
    {
        $this->getClient()->setSource();
    }

    public function setTargetLang(string $lang) : void
    {
        $this->getClient()->setTarget($lang);
    }

    public function translate(string $text) : string
    {
        return $this->getClient()->translate($text);
    }
}
