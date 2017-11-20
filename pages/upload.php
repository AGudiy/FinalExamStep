<?php
	if ( isset($_SESSION['ruser']) )
	{
		echo '<h4 style="color:green;">Hello, <span style="color:green;">'.$_SESSION['ruser'].'</span>&nbsp;</h4>';
?>
	<form action="index.php?page=1" method="post" enctype="multipart/form-data">
 		<div class="form-group">
		 <label for="imagepath">Select image:</label>
    	 <input type="file" name="imagepath[]" multiple accept="image/*">
    	</div>
    	<input type="submit" class="btn btn-primary" name="addbtn">
	</form>
<?php
	if(isset($_POST['addbtn'])){
		foreach($_FILES['imagepath']['name'] as $k => $v){
			if($_FILES['imagepath']['error'][$k]!=0)
				{
					echo '<script>alert("Upload file error:'.$v.'")</script>';
					continue;
				}
			 move_uploaded_file($_FILES['imagepath']['tmp_name'][$k], "images/".$v);
			 $imagepath="images/".$_FILES['imagepath']['name'][$k];
			 $filename=$_FILES['imagepath']['name'][$k];
			 $filename=substr($filename, 0, strrpos($filename, '.'));
			 $psize=$_FILES['imagepath']['size'][$k];
			$userid=$_SESSION['userid'];
			$pdate=@date('Y.m.d H:i:s');
			$picture=new Pictures($imagepath, $filename, $userid, $psize, $pdate);
			$picture->intoDb();		
		}
	}
	}
	else
	{
		echo "<h3/><span style='color:red;'>only for registered users</span><h3/>";		
	}
?>
