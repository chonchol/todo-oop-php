<?php 

namespace todo\stores;

use PDO;
use todo\models\TaskModel;
use todo\stores\TaskInterface;

class TaskStores implements TaskInterface
{
    protected $db;

    public function __construct(PDO $db)
    {
    	$this->db = $db;
    }

    public function store(TaskModel $task)
    {
        $statement = $this->db->prepare("INSERT INTO tasks (title, status) VALUES (:title, :status)");
        $statement->execute($this->buildcolumns($task));

        return $this->get($this->db->lastInsertId()); 
    }

    public function update(TaskModel $task)
    {
        $statement = $this->db->prepare("UPDATE tasks SET title = :title, status = :status WHERE id = :id");
        $statement->execute($this->buildcolumns($task, ['id' => $task->getId(),]));

        return $this->get($task->getId());
    }

    public function delete($id)
    {
        $statement = $this->db->prepare("DELETE FROM tasks WHERE id = :id");
        $statement->execute(['id' => $id]);
        return $statement->fetch();
    }

    public function clearCompleted()
    {
        $statement = $this->db->prepare("DELETE FROM tasks WHERE status = 1");
        return true;
    }

    public function get($id)
    {
        $statement = $this->db->prepare("SELECT id, title, status FROM tasks WHERE id = :id");
        $statement->setFetchMode(PDO::FETCH_CLASS, TaskModel::class);
        $statement->execute(['id' => $id]);

        return $statement->fetch();
    }

    public function all()
    {
        $statement = $this->db->prepare("SELECT id, title, status FROM tasks order by id desc");
        $statement->setFetchMode(PDO::FETCH_CLASS, TaskModel::class);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function active()
    {
        $statement = $this->db->prepare("SELECT id, title, status FROM tasks WHERE status = 0 order by id desc");
        $statement->setFetchMode(PDO::FETCH_CLASS, TaskModel::class);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function complete()
    {
        $statement = $this->db->prepare("SELECT id, title, status FROM tasks WHERE status = 1 order by id desc");
        $statement->setFetchMode(PDO::FETCH_CLASS, TaskModel::class);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function count()
    {
        $total_data = $this->db->query("SELECT COUNT(*) FROM tasks WHERE status = 0")->fetchColumn();
        return $total_data;
    }

    protected function buildcolumns(TaskModel $task, array $additional =[])
    {
        return array_merge([
            'title'  => $task->getTitle(),
            'status' => $task->getStatus() ? 1 : 0,
        ], $additional);
    }
}

 ?>