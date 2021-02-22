<?php 

require 'index.php';

$task_status = @$_GET['status'];
$task_id     = @$_GET['id'];

if($task_status == 1){
    $task = $manager->getTask(@$task_id);
    $task->setStatus('0');
    $manager->updateTask($task);
}else{
    $task = $manager->getTask(@$task_id);
    $task->setStatus('1');
    $manager->updateTask($task);
}

header('location:index.php?mode=all');

?>