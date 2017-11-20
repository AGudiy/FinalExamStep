<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Exam PHP</title>	
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
	<script type="text/javascript" src="js/jquery-1.12.3.min.js"></script>
</head>
<body>
	<?php	
	include_once('pages/classes.php');
	?>

	<div class="row">
	<ul class="nav nav-tabs nav-justified">
		<li <?php if($_GET['page']==1) {echo "class='active'";} ?>><a href="index.php?page=1">upload</a></li>
		<li <?php if($_GET['page']==2) {echo "class='active'";} ?>><a href="index.php?page=2">view</a></li>
		<li <?php if($_GET['page']==3) {echo "class='active'";} ?>><a href="index.php?page=3">Reg/Log</a></li>
	</ul>
	</div>

	<?php
	if(isset($_GET['page'])){
		$page=$_GET['page'];
		if($page==1)	
			include_once("pages/upload.php");
		if($page==2)
			include_once("pages/view.php");
		if($page==3)
			include_once("pages/reglog.php");
	}
	?>

<script type="text/javascript" src="js/jquery-ui.js"></script>
</body>
</html>