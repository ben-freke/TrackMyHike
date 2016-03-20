<?php

class TracksController extends ControllerBase
{

    public function initialize()
    {
        $this->checkLogin();
    }

    public function viewAction()
    {
        $tracks = tracks::find(array(
            "conditions" => "userid = :idVal:",
            "bind" => array("idVal" => $this->userid)
        ));

        $this->view->setVar('tracks', $tracks);
    }

    public function stopAction($trackID)
    {
        $track = tracks::findFirst(array(
            "conditions" => "id = :trackVal: and userid = :idVal:",
            "bind" => array("idVal" => $this->userid, "trackVal" => $trackID)
        ));

        if ($track == null)
        {
            $url = '/'; // this can be set based on whatever
            header( "Location: $url" );
        }

        $track->status = 2;

        $track->save();

        $url = '/tracks/view'; // this can be set based on whatever
        header( "Location: $url" );

    }

    public function addLocAction()
    {
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
                $payload = json_decode(base64_decode($data['Message']));
                foreach ($payload as $item)
                {
                    $user = users::findFirst(array(
                        "conditions" => "id = :idVal: AND apiKey = :keyVal:",
                        "bind" => array("idVal" => $item->userid, "keyVal" => $item->key)
                    ));
                    if ($user)
                    {
                        $location = new locations();
                        $location->userID = $item->userid;
                        $location->trackid = $item->trackid;
                        $location->long = $item->long;
                        $location->lat = $item->lat;
                        $location->altitude = $item->altitude;
                        $location->accuracy = $item->accuracy;
                        $location->speed = $item->speed;
                        $location->time = $item->time;
                        if ($location->save()) {
                            $notification->status = "Saved";
                        }
                        else {
                            $notification->status = "Fail";
                        }
                    }
                    else {
                        return;
                    }
                }
            }
            else {
                $notification->status = "Could not read from stream";
            }
        }
    }

}

