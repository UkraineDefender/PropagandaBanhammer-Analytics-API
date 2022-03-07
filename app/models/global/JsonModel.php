<?php

namespace UkraineDefender\PropagandaBanhammerAnalytics;

use function Amp\File\put;

class JsonModel
{
    public function __construct(
        public string $JsonFilePath,
    )
    { }

    public function OnPropertyChange(string $Name, string|array|object $Value): void
    {
        $this->SaveChanges();
    }

    public function SaveChanges(): void
    {
        file_put_contents($this->JsonFilePath, json_encode($this, JSON_PRETTY_PRINT));
    }

    public static function ParseJSON(string $JSON): ?object
    {
        return json_decode($JSON) ?? null;
    }


    public static function ParseJSONFile(string $Filename): ?object
    {
        return self::ParseJSON(
            @file_get_contents($Filename) ?? null
        );
    }
}