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
        return new JsonView([
            'ok' => true,
            'code' => 200,
            'devices' => (array)$this->DeviceList
        ]);
    }

    #[Action]
    public function GetDeviceByID(): JsonView
    {
        $ID = (string)($_GET['id'] ?? null) ?? null;

        if($ID != null)
        {
            $Device = $this->DeviceList->GetByID($ID);
            $Device->LastOnline = 235;

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
        $ReportResult = filter_var($_GET['success'], FILTER_VALIDATE_BOOLEAN);
        
        if($ID != null)
        {
            $Device = $this->DeviceList->GetByID($ID);
            if($Device != null)
            {
                switch($ReportResult)
                {
                    case 1:
                        $Device->OnReportError();
                        return new JsonView([
                            'ok' => true,
                            'code' => 200
                        ]);
                        break;

                    case 2:
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