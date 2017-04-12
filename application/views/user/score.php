<h1>Score</h1>



<table class="table table-hover">
  <caption>Score</caption>
  <thead>
    <tr>
      <th>Rank</th>
      <th>Name</th>
      <th>College</th>
      <th>Score</th>
    </tr>
  </thead>
  <tbody>
	  <?php 
		  for ($i=0; $i < count($scores); $i++) { 
			echo "<tr>";
			echo "<td>".($i+1)."</td>";
			foreach ($scores[$i] as $key => $value) {
				echo "<td>$value</td>";
			}
			echo "</tr>";
		  }
	  ?>
  </tbody>
</table>