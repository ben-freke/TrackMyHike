<?php

class ControllerBase extends \Phalcon\Mvc\Controller

{
    const GCM_API_KEY = "AIzaSyAR_a5MuTo72QO_eEyrH951v_xKZjgpBX8";
    const MAPS_API_KEY = "AIzaSyC-p1XhM-GHZubu9Vu7SU7P9Cmwx2YTAWQ";

    public function checkLogin()
    {
        $this->userid = 1;
        $this->view->setVar('login', 1);
        $this->view->setVar('username', "Joe Bloggs");
        $this->view->setVar('userid', 1);
        $this->view->setVar('maps_api_key', self::MAPS_API_KEY);
        $this->view->setVar('map_zoom', 14);
        $this->view->setVar('intervalTime', 60);

    }

}

