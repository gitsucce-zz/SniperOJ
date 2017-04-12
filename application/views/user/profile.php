<link href="../../assets/css/style.css" rel='stylesheet' type='text/css' />
<div class="banner-info">
	<div class="col-md-7 header-right" style="color:#111;text-align:initial;padding-left: 400px;">
		<h1>Profile</h1>
		<ul class="address">
		
		<li>
				<ul class="address-text">
					<li><b>NAME</b></li>
					<li><?php echo $user_data['username']; ?></li>
				</ul>
			</li>
			<li>
				<ul class="address-text">
					<li><b>E-Mail</b></li>
					<li><a href="<?php echo $user_data['email']; ?>"><?php echo $user_data['email']; ?></a></li>
				</ul>
			</li>
			<li>
				<ul class="address-text">
					<li><b>College</b></li>
					<li><?php echo $user_data['college']; ?></li>
				</ul>
			</li>
			<li>
				<ul class="address-text">
					<li><b>Register Time</b></li>
					<li><?php echo $user_data['registe_time']; ?></li>
				</ul>
			</li>
			<li>
				<ul class="address-text">
					<li><b>Register IP</b></li>
					<li><?php echo $user_data['registe_ip']; ?></li>
				</ul>
			</li>
			<li>
				<ul class="address-text">
					<li><b>Score</b></li>
					<li><?php echo $user_data['score']; ?></li>
				</ul>
			</li>
			<li>
			</li>
		</ul>
	</div>
	<div class="col-md-5 header-left">
		<img src="../../assets/images/avatar.png" alt="" style="width: 240px;
  height:240px;
  border-radius:120px">
	</div>
</div>

<table class="table table-hover">
  <caption>Submit log</caption>
  <thead>
    <tr>
      <th>ID</th>
      <th>ChallengeName</th>
      <th>Flag</th>
      <th>Time</th>
      <th>Current</th>
    </tr>
  </thead>
  <tbody>
	  <?php 
		  for ($i=0; $i < count($submit_log); $i++) { 
			echo "<tr>";
			echo "<td>".(count($submit_log) - ($i))."</td>";
			echo "<td>".$submit_log[$i]['challengeName']."</td>";
			echo "<td>".$submit_log[$i]['flag']."</td>";
			echo "<td>".date("Y-m-d H:i:s", $submit_log[$i]['submit_time'])."</td>";
			if ($submit_log[$i]['is_current'] == 1){
				echo "<td>√</td>";
			}else{
				echo "<td>×</td>";
			}
			echo "</tr>";
		  }
	  ?>
  </tbody>
</table>