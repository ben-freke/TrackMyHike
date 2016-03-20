<?php
/**
 * Created by PhpStorm.
 * User: Ben Freke
 * Date: 10/03/2016
 * Time: 20:07
 */

class MapController extends ControllerBase
{

    public function initialize()
    {
        $this->checkLogin();
    }

    public function indexAction()
    {



    }

    public function trackAction($userID, $trackID)
    {
        $track = tracks::findFirst(array(
            "conditions" => "id = :trackVal: AND userid = :idVal:",
            "bind" => array("idVal" => $userID, "trackVal" => $trackID)
        ));
        $curr_loc = locations::findFirst(array(
            "conditions" => "userID = :idVal: AND trackid = :trackVal:",
            "order" => "time DESC",
            "bind" => array("idVal" => $userID, "trackVal" => $trackID)
        ));

        if ($curr_loc == null)
        {
            $url = '/'; // this can be set based on whatever
            header( "Location: $url" );
        }

        $locations = locations::find(array(
            "conditions" => "userID = :idVal: AND trackid = :trackVal:",
            "bind" => array("idVal" => $userID, "trackVal" => $trackID)
        ));

        $this->view->setVar('track', $track);
        $this->view->setVar('miles', "12,447");
        $this->view->setVar('locArray', $locations);
        $this->view->setVar('currLong', $curr_loc->long);
        $this->view->setVar('currLat', $curr_loc->lat);
    }

}