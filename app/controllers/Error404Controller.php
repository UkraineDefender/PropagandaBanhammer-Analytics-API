<?php 
namespace UkraineDefender\PropagandaBanhammerAnalytics;

use WeRtOG\FoxyMVC\Attributes\Action;
use WeRtOG\FoxyMVC\Controller;
use WeRtOG\FoxyMVC\ControllerResponse\JsonView;

class Error404Controller extends Controller
{
    public function __construct(array $Models = [])
    {
        parent::__construct($Models);
    }

    #[Action]
    public function Index(): JsonView
    {
        return new JsonView([
            'ok' => false,
            'code' => 404
        ], 404);
    }
}

?>