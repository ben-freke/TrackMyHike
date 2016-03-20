<?php

class DevicesController extends ControllerBase
{

    public function initialize()
    {
        $this->checkLogin();
    }

    public function indexAction()
    {

        $devices = devices::find(array(
            "conditions" => "userid = :idVal:",
            "bind" => array ("idVal" => $this->userid)
        ));

        $this->view->setVar('devices', $devices);

    }


}

