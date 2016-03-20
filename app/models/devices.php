<?php


class devices extends Phalcon\Mvc\Model
{
    public $id;
    public $userid;
    public $name;
    public $os;
    public $key;
    public $status;

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