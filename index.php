<?php

//index.php

include('class/Appointment.php');

$object = new Appointment;

if(isset($_SESSION['patient_id']))
{
	header('location:dashboard.php');
}

$object->query = "
SELECT * FROM doctor_schedule_table 
INNER JOIN doctor_table 
ON doctor_table.doctor_id = doctor_schedule_table.doctor_id
WHERE doctor_schedule_table.doctor_schedule_date >= '".date('Y-m-d')."' 
AND doctor_schedule_table.doctor_schedule_status = 'Active' 
AND doctor_table.doctor_status = 'Active' 
ORDER BY doctor_schedule_table.doctor_schedule_date ASC
";

$result = $object->get_result();

include('header_new.php');

?>

  <section id="hero" style="background-image: url(img/hospital.jpg); background-size: cover;">
    <div class="hero-container" data-aos="fade-up">
      <h1>Welcome to Bee Hospital</h1>
      <h2>The Best Hospital In Depok City</h2>
      <a href="login.php" class="btn-get-started scrollto">Login Here</a>
    </div>
  </section>

  <main id="main">

    <section id="about" class="about">
      <div class="container bg-light" data-aos="fade-up">
		      		<form method="post" action="result.php">
			      		<div class="card-header bg-light"><h3><b>Doctor Schedule List</b></h3></div>
			      		<div class="card-body">
		      				<div class="table-responsive">
		      					<table class="table table-striped table-bordered">
		      						<tr>
		      							<th>Doctor Name</th>
		      							<th>Education</th>
		      							<th>Speciality</th>
		      							<th>Appointment Date</th>
		      							<th>Appointment Day</th>
		      							<th>Available Time</th>
		      							<th>Action</th>
		      						</tr>
		      						<?php
		      						foreach($result as $row)
		      						{
		      							echo '
		      							<tr>
		      								<td>'.$row["doctor_name"].'</td>
		      								<td>'.$row["doctor_degree"].'</td>
		      								<td>'.$row["doctor_expert_in"].'</td>
		      								<td>'.$row["doctor_schedule_date"].'</td>
		      								<td>'.$row["doctor_schedule_day"].'</td>
		      								<td>'.$row["doctor_schedule_start_time"].' - '.$row["doctor_schedule_end_time"].'</td>
		      								<td><button type="button" name="get_appointment" class="btn btn-primary btn-sm get_appointment" data-id="'.$row["doctor_schedule_id"].'">Get Appointment</button></td>
		      							</tr>
		      							';
		      						}
		      						?>
		      					</table>
		      				</div>
		      			</div>
		      		</form>
      </div>
    </section>	    

<?php

include('footer_new.php');

?>

<script>

$(document).ready(function(){
	$(document).on('click', '.get_appointment', function(){
		var action = 'check_login';
		var doctor_schedule_id = $(this).data('id');
		$.ajax({
			url:"action.php",
			method:"POST",
			data:{action:action, doctor_schedule_id:doctor_schedule_id},
			success:function(data)
			{
				window.location.href=data;
			}
		})
	});
});

</script>