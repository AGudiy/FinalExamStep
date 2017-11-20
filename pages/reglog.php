<div class="container adm">
	<div class="row">
		<script type="text/javascript">
			$(function(){$('#tabs').tabs()});
		</script>
		<div id="tabs">
			<ul>
				<li><a href="#tabs-1">Reg</a></li>
				<li><a href="#tabs-2">Log</a></li>
			</ul>


			<div id="tabs-1">
				<h3>Registration Form</h3>
				<?php
				if (!isset($_SESSION['ruser']) ){
				if(!isset($_POST['regbtn']))
				{
				?>
					<form action="index.php?page=3" method="post" enctype="multipart/form-data">
					<div class="form-group">
					 <label for="login">Login:</label>
					 <input type="text" class="inputreg" name="login">
					</div>
					 <div class="form-group">
					 <label for="pass1">Password:</label>
					 <input type="password" class="inputreg" name="pass1">
					 </div>
					 <div class="form-group">
					 <label for="pass2">Confirm Password:</label>
					 <input type="password" class="inputreg" name="pass2">
					 </div>
					 <button type="submit" class="btn btn-primary" name="regbtn">Register</button>
					</form>
				<?php
				}
				else
		        {
					//customer registration
					if(Tools::register($_POST['login'],$_POST['pass1'],$_POST['pass2']))
					{
						 echo "<h3/><span style='color:green;'>New User Added!</span><h3/>";
					}
				}
			}
				?>
			</div>


			<div id="tabs-2">
				<?php
				if ( isset($_SESSION['ruser']) )
				{
					echo '<form action="index.php?page=3" method="post">';
					echo '<h4>Hello, <span>'.$_SESSION['ruser'].'</span>&nbsp;';
					echo '<input type="submit" value="Logout" id="ex" name="ex" class="btn btn-default"></h4>';
					echo '</forn>';
					if ( isset($_POST['ex']) )
					{
						unset( $_SESSION['ruser'] );
						unset( $_SESSION['radmin'] );
						echo '<script>window.location.reload();</script>';
					}
				}
				else
				{
					if (isset($_POST['press']))
					{
						 if(Users::login($_POST['login'],$_POST['pass'])){
						echo '<script>window.location.reload();</script>';
						 }
					}
					else
					{
					?>
						<form action="index.php?page=3" method="post">
						<input type="text" name="login" size="10" class="inputreg" placeholder="login" style="margin-bottom:17px;"><br>
						<input type="password" name="pass" size="10" class="inputreg" placeholder="password" style="margin-bottom:17px;"> 
						<br>
						<input type="submit" id="press"	value="Login" class="btn btn-default" name="press">
						</form>
					<?php
					}
				}
				?>
			</div>
		</div>
	</div>
	
</div>