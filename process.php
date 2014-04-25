<?php 
session_start();
require_once('connection.php');

// This is to register a user
if(isset($_POST['action'])  && $_POST['action'] == 'register_user')
{
	register($_POST);
}

elseif(isset($_POST['action']) && $_POST['action'] == 'add_expense')
{
	add_expense($_POST);
	// var_dump($_POST);
	// die();
}

elseif(isset($_POST['action_delete']) && $_POST['action_delete'] == 'delete')
{
	delete($_POST);
}
else
{
	session_destroy();
	header('location: index.php');
	die();
}

function register($post)
{
	// var_dump($post);

		$_SESSION['errors'] = array();

		if(empty($post['name']) && empty($post['budget']))
		{
			$_SESSION['errors'][] = "Name and budget must both have valid inputs!!!";
		}
		elseif(empty($post['name']))
		{
			$_SESSION['errors'][] = "You must input a name, Thank you :) ";
		}
		elseif(empty($post['budget']))
		{
			$_SESSION['errors'][] = "Do you not have any money :( ";
		}
		elseif(!ctype_digit($post['budget']))
		{
			$_SESSION['errors'][] = 'Please enter a number for your budget and no decimals!';
		}
		else
		{
			$query = "INSERT INTO users(name, budget, created_at, updated_at)
					  VALUES ('{$post['name']}', '{$post['budget']}', NOW(), NOW())";

					  run_mysql_query($query);

					  $member_id = get_insertion_id();

					  $_SESSION['member_id'] = $member_id;

					  // echo($query);
					  // die();

					  header('Location: user.php?id=' . $member_id);
					  die();
		}

		header('Location: index.php');
		die();

}

function add_expense($post)
{

	$_SESSION['errors'] = array();

	if(empty($post['particulars']) && empty($post['amount']))
	{
		$_SESSION['errors'][] = "You must enter values into both fields";
	}
	elseif(empty($post['particulars']))
	{
		$_SESSION['errors'][] = "You must enter an item of your choice in this field";
	}
	elseif(empty($post['amount']))
	{
		$_SESSION['errors'][] = "Please enter a dollar amount";
	}
	elseif(!ctype_digit($post['amount']))
	{
		$_SESSION['errors'][] = 'Please enter a valid number';
	}
	else
	{
		$member_id = $_SESSION['member_id'];
		$query = "INSERT INTO expenses(particular, amount, created_at, updated_at, users_id)
				  VALUES('{$post['particulars']}','{$post['amount']}', NOW(), NOW(), {$member_id})";
		run_mysql_query($query);
		
		// echo($query);
		// die();	

		header('Location: user.php?id =' . $member_id);
		die();	  
	}

	header('Location: user.php?id =' . $member_id);
	die();
}


function delete($post)
{
	$member_id = $_SESSION['member_id'];
	$query = "DELETE FROM expenses WHERE id = {$post['deletion_id']}";

	run_mysql_query($query);
	header('Location: user.php?id=' . $member_id);
	die();
}















?>

