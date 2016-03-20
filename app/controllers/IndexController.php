<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $this->view->setVar('login', 0);
    }

}

