<?php

namespace UkraineDefender\PropagandaBanhammerAnalytics;

use ArrayIterator;

class DeviceList extends ArrayIterator
{
    public function __construct(array $InitialData = [])
    {
        parent::__construct($InitialData);
    }

    public function current(): Device
    {
        return parent::current();
    }

    public function offsetGet($Offset): ?Device
    {
        return parent::offsetGet($Offset);
    }

    public function Add(Device &$Device): void
    {
        parent::append($Device);
    }

    public function __toArray(): array
    {
        return parent::getArrayCopy();
    }

    public function GetByID(string $ID): ?Device
    {
        foreach((array)$this as &$Current)
        {
            if($Current->ID == $ID)
                return $Current;
        }

        return null;
    }

    public static function FromFolder(string $FolderPath)
    {
        $Result = null;
        
        if(file_exists($FolderPath))
        {
            $Result = new self();
            foreach(glob($FolderPath . "/*.json") as $Filename)
            {
                $NewDevice = Device::FromJSONFile($Filename);
                
                if($NewDevice instanceof Device) 
                {
                    $Result->Add($NewDevice);
                }
            }
        }

        return $Result;
    }

}

