<?php


class locations extends Phalcon\Mvc\Model
{
    public $id;
    public $userID;
    public $lat;
    public $long;
    public $altitude;
    public $accuracy;
    public $time;
    public $speed;
    public $trackid;


    public function initialize()
    {
    }
    public function beforeSave()
    {
    }
    public function afterFetch()
    {
    }

}