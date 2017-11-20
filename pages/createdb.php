<?php
include_once('classes.php');
$pdo=Tools::connect();

$users='create table Users(
	id int not null auto_increment primary key,
	login varchar(32)not null unique,
	pass varchar(128)not null)
	default charset="utf8"';

$pictures='create table Pictures(
	id int not null auto_increment primary key,
	imagepath varchar(255),
	filename varchar(32)not null,
	userid int,
	foreign key(userid) references Users(id) on delete cascade,
	psize int,
	pdate date,
	requested int)
	default charset="utf8"';

//$pdo->exec($users);
$pdo->exec($pictures);
?>