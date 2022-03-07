<?php 
namespace UkraineDefender\PropagandaBanhammerAnalytics;

use WeRtOG\FoxyMVC\Attributes\Action;
use WeRtOG\FoxyMVC\Controller;
use WeRtOG\FoxyMVC\ControllerResponse\JsonView;
use WeRtOG\FoxyMVC\ControllerResponse\Response;
use WeRtOG\FoxyMVC\ControllerResponse\View;
use WeRtOG\FoxyMVC\Route;

class IndexController extends Controller
{
    public function __construct(array $Models = [])
    {
        parent::__construct($Models);
    }

    #[Action]
    public function Index(): JsonView
    {
        return new JsonView([
            'ok' => true,
            'code' => 200
        ]);
    }
}

?>