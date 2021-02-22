<?php
namespace todo;

use todo\models\TaskModel;
use todo\stores\TaskInterface;

class Task{

    protected $store;

    public function __construct(TaskInterface $store)
    {
        $this->store = $store;
    }

    public function addTask(TaskModel $task)
    {
        return $this->store->store($task);
    }

    public function updateTask(TaskModel $task)
    {
        return $this->store->update($task);
    }

    public function getTask($id)
    {
        return $this->store->get($id);
    }

    public function deleteTask($id)
    {
        return $this->store->delete($id);
    }

    public function clearcompletedTask()
    {
        return $this->store->clearCompleted();
    }

    public function getallTask()
    {
        return $this->store->all();
    }

    public function countTask()
    {
        return $this->store->count();
    }

    public function activeTask()
    {
        return $this->store->active();
    }

    public function completedTask()
    {
        return $this->store->complete();
    }
}

?>