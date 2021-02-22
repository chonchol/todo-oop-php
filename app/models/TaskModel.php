<?php 

namespace todo\models;

class TaskModel
{
    protected $id;
    protected $status = false;
    protected $title;

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setStatus($status = false)
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        return (bool) $this->status;
    }

    public function getId()
    {
        return $this->id;
    }
}

 ?>