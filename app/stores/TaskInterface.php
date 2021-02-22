<?php 

namespace todo\stores;

use todo\models\TaskModel;

interface TaskInterface
{
    public function store(TaskModel $task);
    public function update(TaskModel $task);
    public function delete($id);
    public function get($id);
    public function all();
}

?>