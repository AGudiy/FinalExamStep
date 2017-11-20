<form action="index.php?page=2" method="post" class="form-inline">
<select name="pictureid" style="width: 22%; height: 34px; border-radius: 5px;">
<?php
$pdo=Tools::connect();
$list=$pdo->query("SELECT * FROM Pictures");
while ($row=$list->fetch())
{
 echo '<option value="'.$row['id'].'">'.$row['filename'].' ('.$row['psize'].' byte)</option>';
}
?> 	
</select>
<label for="maxsize"></label>
<input type="number" name="maxSize" style="width: 12%; height: 34px; border-radius: 5px; border: 2px solid silver;">
<input type="submit" name="filterSize" class="btn" value="Enter">
</form>

<?php
if(isset($_POST['filterSize'])){
	$maxSize=$_POST['maxSize'];
	$pictures=Pictures::getPictures($maxSize);
	echo '<div class="container">';
	echo '<div class="row">';
	foreach ($pictures as $p) {
		$p->Drow();
		$p->requested();
	}
	echo '</div>';
	echo '</div>';
}
?>