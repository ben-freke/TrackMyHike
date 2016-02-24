<?php


class notifications extends Phalcon\Mvc\Model
{
    public $id;
    public $type;
    public $messageID;
    public $signature;
    public $timestamp;


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