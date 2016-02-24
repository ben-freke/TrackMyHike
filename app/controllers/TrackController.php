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

            $notification = new notifications();
            $notification->type = $data['Type'];
            $notification->messageID = $data['MessageId'];
            $notification->signature = $data['Signature'];
            $notification->save();


            if ($data['Type'] == "SubscriptionConfirmation")
            {
                /**
                 * AWS Subscription
                 */
                $xml = file_get_contents($data['SubscribeURL']);
            }
            if ($data['Type'] == "Notification")
            {
                /**
                 * AWS Notification
                 */


                $payload = $data['Message'];
                foreach ($payload as $item)
                {
                    $location = new locations();
                    $location->userID = $item['userid'];
                    $location->long = $item['long'];
                    $location->lat = $item['lat'];
                    $location->altitude = $item['altitude'];
                    $location->accuracy = $item['accuracy'];
                    $location->time = $item['time'];
                    if ($location->save()){
                    }
                    else {
                        echo $location->getMessages();
                    }
                }
            }


            //print_r($data);

        }
    }
}