<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
use todo\models\TaskModel;
use todo\Task;
use todo\stores\TaskStores;

require 'vendor/autoload.php';

// header('location:index.php?mode=all');

// Database details
$db = new PDO('mysql:host=localhost;dbname=todos', 'root', '');

$store = new TaskStores($db);
$manager = new Task($store);

if($_GET['mode'] == 'active'){
	$task_data = $manager->activeTask();
}else if($_GET['mode'] == 'complete'){
	$task_data = $manager->completedTask();
}else if($_GET['mode'] == 'clear'){
	$task_data = $manager->clearcompletedTask();
}else{
	$task_data = $manager->getallTask();
}

if (isset($_POST['submit']) && !empty($_POST['task'])) {
	try{
		$taskdata = $_POST['task'];
		$sucess   = "Update Sucessfully";
	}
	catch(Exception $e){
		$error_message = $e->getmessage();
	}
}

$task = new TaskModel;
$task->setTitle(@$taskdata);
$task->setStatus();

$storedtask = $manager->addTask($task);

$delete = @$_GET['delete'];
$manager->deleteTask($delete);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Todo - List</title>
	<link rel="stylesheet" href="assets/bootstrap.min.css">
	<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="wrapper">
	<div class="container">
		<div class="row pt-4">
			<div class="col-sm-6 offset-sm-3">
				<div class="logo-area text-center">
					<h2>todos</h2>
				</div>
				<div class="task-area">
					<div class="tas-form">
						<form action="" method="POST">
							<input type="text" name="task" class="form-control" placeholder="What needs to be done?">
							<button name="submit" type="hidden" class="add-btn">Add Task</button>
						</form>
					</div>
					<div class="task-table">
						<div class="all-task">
							<?php 
								foreach($task_data as $task){
							?>
							<div class="single-task">
								<!-- <div class="form-check"> -->
								    <a href="edit.php?status=<?php echo $task->getStatus();?>&id=<?php echo $task->getId();?>"><span class="tick-mark"><?php echo ($task->getStatus() == 1) ? '&#10003;' : '&nbsp;&nbsp;'; ?></span></a>
									<label class="form-check-label<?php echo ($task->getStatus() == 1) ? '' : '-not'; ?>" for="exampleCheck1"><?php echo $task->getTitle(); ?></label>
									<a href="index.php?delete=<?php echo $task->getId(); ?>" class="delete-btn">x</a>
								<!-- </div> -->
							</div>
							<?php } ?>
						</div>
						<div class="task-menu">
							<p> <?php echo $manager->countTask(); ?> items left</p>
							<ul>
								<li><a href="index.php?mode=all" class="active">All</a></li>
								<li><a href="index.php?mode=active">Active</a></li>
								<li><a href="index.php?mode=complete">Completed</a></li>
							</ul>
							<p><a href="index.php?mode=clear">Clear Completed</a></p>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="assets/jquery-3.5.1.min.js"></script>	
<script src="assets/bootstrap.min.js"></script>	
</body>
</html>