<?php 
namespace UkraineDefender\PropagandaBanhammerAnalytics;

use WeRtOG\FoxyMVC\Attributes\Action;
use WeRtOG\FoxyMVC\Controller;
use WeRtOG\FoxyMVC\ControllerResponse\JsonView;

class DevicesController extends Controller
{
    public DeviceList $DeviceList;

    #[Action]
    public function Index(): JsonView
    {
        return new JsonView([
            'ok' => true,
            'code' => 200
        ]);
    }

    #[Action]
    public function GetDevices(): JsonView
    {
        $Devices = (array)$this->DeviceList;
        return new JsonView([
            'ok' => true,
            'code' => 200,
            'devices_count' => count($Devices),
            'devices' => $Devices
        ]);
    }

    #[Action]
    public function GetOnlineDevices(): JsonView
    {
        $OnlineDevices = [];

        foreach((array)$this->DeviceList as $Device)
        {
            if($Device instanceof Device)
            {
                $TimeDiff = time() - $Device->LastOnline;

                if($TimeDiff < 10)
                    $OnlineDevices[] = $Device;
            }
        }

        return new JsonView([
            'ok' => true,
            'code' => 200,
            'devices_count' => count($OnlineDevices),
            'devices' => $OnlineDevices
        ]);
    }

    #[Action]
    public function GetDeviceByID(): JsonView
    {
        $ID = (string)($_GET['id'] ?? null) ?? null;

        if($ID != null)
        {
            $Device = $this->DeviceList->GetByID($ID);

            return new JsonView([
                'ok' => true,
                'code' => 200,
                'device' => $Device
            ]);
        }
        else
        {
            return new JsonView([
                'ok' => false,
                'code' => 400,
                'error' => 'Bad request.'
            ]);
        }
    }

    #[Action]
    public function SendReportResult(): JsonView
    {
        $ID = (string)($_GET['id'] ?? null) ?? null;
        $ReportResult = $_GET['success'] ?? null;
        $ReportResult = $ReportResult == '1' || $ReportResult == 'true' || $ReportResult == '0' || $ReportResult == 'false' ? $ReportResult : null;
        $ReportResult = $ReportResult == '1' || $ReportResult == 'true' ? true : false;
        
        if($ID != null)
        {
            $Device = $this->DeviceList->GetByID($ID);
            if($Device != null)
            {
                switch($ReportResult)
                {
                    case false:
                        $Device->OnReportError();
                        return new JsonView([
                            'ok' => true,
                            'code' => 200
                        ]);
                        break;

                    case true:
                        $Device->OnReportSuccess();
                        return new JsonView([
                            'ok' => true,
                            'code' => 200
                        ]);
                        break;

                    default:
                        return new JsonView([
                            'ok' => false,
                            'code' => 400,
                            'error' => 'Bad request.'
                        ]);
                        break;
                }
            }
            else
            {
                return new JsonView([
                    'ok' => false,
                    'code' => 400,
                    'error' => 'Bad request.'
                ]);
            }
        }
        else
        {
            return new JsonView([
                'ok' => false,
                'code' => 400,
                'error' => 'Bad request.'
            ]);
        }
    }

    #[Action]
    public function UpdateLastOnline(): JsonView
    {
        $ID = (string)($_GET['id'] ?? null) ?? null;

        if($ID != null)
        {
            $Device = $this->DeviceList->GetByID($ID);
            if($Device != null)
            {
                $Device->UpdateLastOnline();
            }
            else
            {
                return new JsonView([
                    'ok' => false,
                    'code' => 400,
                    'error' => 'Bad request.'
                ]);
            }
        }
        else
        {
            return new JsonView([
                'ok' => false,
                'code' => 400,
                'error' => 'Bad request.'
            ]);
        }
    }


    #[Action]
    public function Register(): JsonView
    {
        $NewDevice = Device::Create();
        $NewDevice->UpdateLastOnline();
        
        $this->DeviceList->Add($NewDevice);

        return new JsonView([
            'ok' => true,
            'code' => 200,
            'device' => $NewDevice
        ]);
    }
}