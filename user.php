<?php 
session_start();
require_once('connection.php');
?>

<html>
<head>
	<title>Expense Tracker</title>
	<link rel="stylesheet" type="text/css" href="style2.css">
</head>
<body>
	
		<div id='header_alignment'>
			<?php 
			$query = "SELECT users.* FROM users WHERE id = " . $_SESSION['member_id'];
			$result = run_mysql_query($query);
			$row = fetch_record($query);

			// echo($query);
			// die();

			$query_1 = "SELECT expenses.amount FROM expenses WHERE users_id = " . $_SESSION['member_id'];
			$sum = fetch_all($query_1);
			$aggregate = 0;

			// echo($query_1);
			// die();
			foreach ($sum as $value)
			{
				$aggregate += $value['amount'];
			}
			$new_total = $row['budget'] - $aggregate;

			if(isset($_SESSION['member_id']))
				{
					echo "<h1> Welcome " . $row['name'] . "!</h1>";
					echo "You have " . $new_total . " left for your savings. ";
				}
			?>
		</div>

		<div id='expenses_alignment'>
			<h1 id='exp'>List of Expenses</h1>
			<?php 
				$query_2 = "SELECT expenses.id, expenses.created_at, expenses.particular, expenses.amount FROM expenses WHERE users_id = " . $_SESSION['member_id'];
				$results = fetch_all($query_2);

				// echo($query_2);
				// die();

				echo "<table id='table-2'>";
				if(!empty($results))
				{
					echo "<th>Date</th><th>Particulars</th><th>Amount Spent($)</th><th>Action</th>";
					foreach($results as $result)
					{
						echo "<tr>
									<td>{$result['created_at']}</td>
									<td>{$result['particular']}</td>
									<td>{$result['amount']}</td>
									<td><form action = 'process.php' method='post'>
										<input type='hidden' name='action_delete' value='delete'>
										<input type='hidden' name='deletion_id' value = '{$result['id']}'>
										<input type='submit' value='Delete'>
										</form>
									</td>
								</tr>";
					}	
					echo "</table>";
				}
				else
				{
					echo "<p id='yet'>You have not entered any expenses yet...</p>";
				}
			?>
		</div>
				<h1 id='add_exp'>Add Expenses: </h1>
			<div id="add_expenses">
				<?php 
					if(isset($_SESSION['errors']))
					{

						foreach ($_SESSION['errors'] as $value) 
						{
							echo "<p id='errors'>" . $value . "</p>";
						}
						unset($_SESSION['errors']);
					}
				?>
					<form action = 'process.php' method = 'post'>
						<input type='hidden' name='action' value='add_expense'>
						<label>Particulars: </label><input type='text' name='particulars' placeholder='Enter Items'><br>
						<label>Amount: </label><input type='text' name='amount' placeholder='Enter Amount'><br><br>
						<input id='add' class='btn' type='submit' value="Add" name='add'><br>
					</form>
			</div>
	<?php echo "<a href='process.php'><img id='logout' src='logout.png'></a>";?> 
</body>
</html>