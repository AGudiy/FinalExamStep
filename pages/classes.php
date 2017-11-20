<?php
class Tools
{
	static function connect(
		$host="localhost:3306",
		$user="root",
		$pass="AndGud/760247",
		$dbname="exam")
	{
		$cs='mysql:host='.$host.';dbname='.$dbname.';charset=utf8;';
		$options=array(
			PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
			PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES UTF8'
		);
		try {
			$pdo=new PDO($cs,$user,$pass,$options);
			return $pdo;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
			return false;
		}
	}

	static function register($name,$pass1,$pass2)
	{
		$name=trim($name);
		$pass1=trim($pass1);
		$pass2=trim($pass2);
		if ($name=="" || $pass1=="" || $pass2=="")
		{
		 echo "<h3/><span style='color:red;'>
		 Fill All Required Fields!</span><h3/>";
		 return false;
		}
		if ($pass1!=$pass2){
			echo "<h3/><span style='color:red;'> pass1<>pass2</span><h3/>";
		 	return false;
		}
		if (strlen($name)<3 || strlen($name)>30 || strlen($pass1)<3 || strlen($pass1)>30)
		{
		 echo "<h3/><span style='color:red;'>Values Length Must Be Between 3 And 30!</span><h3/>";
		 return false;
		}
		Tools::connect();
		$pass=md5($pass1);
		$customer=new Users ($name,$pass);
		$err=$customer->intoDb();
		if ($err)
		{
			if($err==1062)
			echo "<h3/><span
			style='color:red;'>
			This Login Is Already Taken!</
			span><h3/>";
			else
			echo "<h3/><span
			style='color:red;'>
			Error code:".$err."!</span><h3/>";
			return false;
		}
		return true;
	}
}


class Pictures
{
	public $id, $imagepath, $filename, $userid, $psize, $pdate, $requested;
	function __construct($imagepath, $filename, $userid, $psize, $pdate, $requested=0, $id=0)
	{
		$this->imagepath=$imagepath;
		$this->filename=$filename;
		$this->userid=$userid;
		$this->psize=$psize;
		$this->pdate=$pdate;
		$this->requested=$requested;
		$this->id=$id;
	}
	public function intoDb()
	{
		try{
			$pdo=Tools::connect();
			$ps=$pdo->prepare('Insert into Pictures 
				(id, imagepath, filename, userid, psize, pdate, requested) 
				values (?,?,?,?,?,?,?)');
			$ps->execute(array(
				$this->id,
				$this->imagepath,
				$this->filename,
				$this->userid,
				$this->psize,
				$this->pdate,
				$this->requested
				));
		}
		catch(PDOException $e){
			echo $e->getMessage();
			return false;
		}
	}
	static function fromDb()
	{

	}

	static function getPictures($size)
	{
		$ps=null;
		$pictures=null;
		try{
			$pdo=Tools::connect();
			$ps=$pdo->prepare('select * from Pictures where psize<?');
			$ps->execute(array($size));
			while($row=$ps->fetch())
			{
				$picture=new Pictures($row['imagepath'],$row['filename'],$row['userid'],$row['psize'], $row['pdate'], $row['requested'],$row['id']);
				$pictures[]=$picture;
			}
			return $pictures;
		}
		catch(PDOException $e){
			echo $e->getMessage();
			return false;
		}
	}

	function Drow()
	{
		echo "<div class='col-sm-4 col-md-4 col-lg-4' style='height:300px'>";
		echo "<div class='col-sm-9 col-md-9 col-lg-9' style='height:300px'>";
		echo "<img src='".$this->imagepath."' width='100%' style='max-height:300px'>";
		echo "</div>";
		echo "<div class='col-sm-3 col-md-3 col-lg-3' style='height:300px'>";
		echo "<h3 style='color:green'>".$this->filename."</h3><br>";
		echo "<p style='font-size:18px; color:green;'>size: ".$this->psize." byte<p>";
		$req=$this->requested+1;
		echo "<p style='font-size:18px; color:green;'>requested: ".$req."<p>";
		echo "</div>";
		echo "</div>";
	}

	function requested()
	{
		try{
			$pdo=Tools::connect();
			$update='update pictures set requested=? where id=?';
			$ps=$pdo->prepare($update);
			$ps->execute(array($this->requested+1,$this->id));
		}
		catch(PDOException $e){
			echo $e->getMessage();
			return false;
		}
	}
}


class Users
{
	private $id, $login, $pass;
	function __construct($login, $pass, $id=0)
	{
		$this->login=$login;
		$this->pass=$pass;
		$this->id=$id;
	}
	function intoDb()
	{
		try{
			$pdo=Tools::connect();
			$ps=$pdo->prepare("INSERT INTO Users
				(login,pass,id)
				VALUES (?, ?, ?)");
			$ps->execute(array(
				$this->login,
				$this->pass,
				$this->id
			));			
		}
		catch(PDOException $e){
				return $e->getMessage();			
		}
	}

	static function fromDb($id)
	{
		$customer=null;
		try{
			$pdo=Tools::connect();
			$ps=$pdo->prepare("SELECT * FROM Customers WHERE id=?");
			$res=$ps->execute(array($id));
			$row=$res->fetch();
			$customer=new Customer($row['login'], $row['pass'], $row['imagepath'], $row['id']);
			return $customer;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
			return false;
		}
	}

	static function Login($login,$pass)
	{
		$login=trim($login);
		$pass=trim($pass);
		if ($login=="" || $pass==""){
			echo "<h3/><span style='color:red;'> Fill All Required Fields!</span><h3/>";
			return false;
		}
		$pass=md5($pass);
		$customer=null;
		try{	
			$pdo=Tools::connect();
			$ps=$pdo->prepare('select * from Users where
			login=? and pass=?');
			$ps->execute(array($login, $pass));
			if($row=$ps->fetch()){
				$customer=new Users($row['login'],$row['pass'], $row['imagepath'], $row['id']);
				$_SESSION['ruser']=$row['login'];
				$_SESSION['userid']=$row['id'];
				 return $customer;
			}
			else
			{
				echo "<h3/><span style='color:red;'>No Such User!</span><h3/>";
				return false;
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
			return false;
		}
	}	
}
?>