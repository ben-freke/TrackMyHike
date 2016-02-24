<?php
/**
 * Created by PhpStorm.
 * User: benfreke
 * Date: 25/01/16
 * Time: 07:50
 */

use Phalcon\Mvc\View;


class TrackController extends ControllerBase {

    public function locationAction(){
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
        $request = new \Phalcon\Http\Request();
        if ($request->isPost()){
            $data = json_decode(file_get_contents('php://input'), true);
            //print_r($data);
            $location = new locations();
            $location->userID = $data['id'];
            $location->long = $data['long'];
            $location->lat = $data['lat'];
            $location->altitude = $data['altitude'];
            $location->accuracy = $data['accuracy'];
            $location->time = $data['time'];

            if ($location->save()){
            }
            else {
                echo $location->getMessages();
            }
        }
    }
}