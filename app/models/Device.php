<?php

namespace UkraineDefender\PropagandaBanhammerAnalytics;

require_once 'global/JsonModel.php';

class Device extends JsonModel
{
    public function __construct(
        public string $JsonFilePath,
        public ?string $ID,
        public int $RegistrationDate = 0,
        public int $LastOnline = 0,
        public int $SuccessReportsCount = 0,
        public int $ErrorReportsCount = 0,
        public int $TinyBanCount = 0
    )
    {
        parent::__construct($JsonFilePath);
    }

    public static function FromJSONFile(string $Filename): self
    {
        $ParsedObject = parent::ParseJSONFile($Filename);

        if($ParsedObject != null)
        {
            return new self(
                JsonFilePath: $Filename,
                ID: $ParsedObject->{'ID'} ?? null,
                RegistrationDate: $ParsedObject->{'RegistrationDate'} ?? 0,
                LastOnline: $ParsedObject->{'LastOnline'} ?? 0,
                SuccessReportsCount: $ParsedObject->{'SuccessReportsCount'} ?? 0,
                ErrorReportsCount: $ParsedObject->{'ErrorReportsCount'} ?? 0,
                TinyBanCount: $ParsedObject->{'TinyBanCount'} ?? 0
            );
        }
        else
        {
            return null;
        }
    }

    public static function Create(string $Folder = DEVICES_DIR): self
    {
        $ID = md5(uniqid());

        $NewDevice = new self(
            JsonFilePath: $Folder . '/' . $ID . '.json',
            ID: $ID,
            RegistrationDate: time()
        );

        $NewDevice->SaveChanges();

        return $NewDevice;

    }

    public function UpdateLastOnline(?int $Value = null): void
    {
        if($Value == null)
            $Value = time();
        
        $this->LastOnline = $Value;
        $this->OnPropertyChange('LastOnline', $Value);
    }

    public function OnReportSuccess(): void
    {
        $this->LastOnline = time();
        $this->SuccessReportsCount++;
        $this->SaveChanges();
    }
    
    public function OnReportError(): void
    {
        $this->LastOnline = time();
        $this->ErrorReportsCount++;
        $this->SaveChanges();
    }

}