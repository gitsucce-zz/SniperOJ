<h1>Score</h1>
<?php 
	foreach ($scores as $user => $result) {
		foreach ($result as $key => $value) {
			echo "$key->$value<br>";
		}
		echo "<br>";
	}
?>