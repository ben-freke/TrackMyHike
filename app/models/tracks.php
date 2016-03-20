<?php


class tracks extends Phalcon\Mvc\Model
{
    public $id;
    public $userid;
    public $name;
    public $location;
    public $distance;
    public $status;
    public $time;

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