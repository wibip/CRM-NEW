<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<title>Remove Mac</title>
</head>

<body>
	<?php
		//require_once('db/config.php'); 
	require_once 'classes/dbClass.php';
	$db = new db_functions();

	header("Cache-Control: no-cache, must-revalidate");
		if (isset($_POST['nameid']) ) {
			$deleteid = $_POST['nameid'];
			$deleteid;
			$qq = " DELETE FROM `exp_customer_sessions_mac` WHERE `id` = '$deleteid'";
			$rr = $db->execDB($qq);

		}
	?>

	<table border="1">
		<tr>
			<th>Mac</th>
			<th></th>
		</tr>
	<?php
 

	$q1 = "SELECT `id`,`mac` FROM `exp_customer_sessions_mac`";
	$r = $db->selectDB($q1);


	foreach ($r['data'] AS $row) {
		$id = $row[id];
		$mac = $row[mac];
		echo "<tr><td>".$mac."</td>";
		/*echo '<td>
				<button onclick="deleter('.$id.')" >DELETE</button>
				</td>		</tr>';*/

		echo '<td><form action="mac.php" method="POST">
		<input type="hidden" value="'.$id.'" name="nameid">
		<input type="submit" value="DELETE">
		</form></tr>';
	}

	?>
	</table>

	
	</form>
	<script type="text/javascript">
		function deleter(id){
			//console.log(id);
			window.location = "?id="+id+"&delete=delete";
		}
	</script>

</body>

</html>
