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
            if (!isset($data['Type'])){
                $notification->type = "Error";
                $notification->messageID = "Error";
                $notification->signature = "Error";
                $notification->status = "Stream could not be read";
            }
            $notification->type = $data['Type'];
            $notification->messageID = $data['MessageId'];
            $notification->signature = $data['Signature'];
            if ($data['Type'] == "SubscriptionConfirmation")
            {
                /**
                 * AWS Subscription
                 */
                $xml = file_get_contents($data['SubscribeURL']);
                $notification->status = base64_encode($xml);
            }
            else if ($data['Type'] == "Notification")
            {
                /**
                 * AWS Notification
                 */

                $payload = json_decode($data['Message']);
                foreach ($payload as $item)
                {
                    $location = new locations();
                    $location->userID = $item->userid;
                    $location->long = $item->long;
                    $location->lat = $item->lat;
                    $location->altitude = $item->altitude;
                    $location->accuracy = $item->accuracy;
                    $location->time = $item->time;
                    if ($location->save()) {
                        $notification->status = "Saved";
                    }
                    else {
                    }

                        $notification->status = "Fail";
                    }
                }
            else {
                $notification->status = "Could not read from stream";
            }

            if ($notification->save()) echo "Saved";

        }
    }
}