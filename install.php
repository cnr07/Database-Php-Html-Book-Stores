<?php
set_time_limit(0);
$servername = "localhost";
$username = "root";
$password = "mysql";
//$dbname = "can_erdoğan";
$conn = mysqli_connect($servername, $username, $password);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$resulttt=mysqli_query($conn,"SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))") or die("Error");
$sql1 = "DROP DATABASE IF EXISTS can_erdoğan;";
$sql2 = "CREATE DATABASE can_erdoğan;";
$sql3 = "USE can_erdoğan;";
$sql4 = "CREATE TABLE IF NOT EXISTS `DISTRICT` (
  `District_id` int(11) NOT NULL AUTO_INCREMENT,
  `District_name` varchar(50) NOT NULL,
  PRIMARY KEY(`District_id`)
) ENGINE=InnoDB;";
$sql5 = "CREATE TABLE IF NOT EXISTS `CITY` (
  `City_id` int(11) NOT NULL AUTO_INCREMENT,
  `City_name` varchar(50) NOT NULL,
  `District_id` int(11) NOT NULL,
  PRIMARY KEY(`City_id`),
  FOREIGN KEY fk_CITY_District_id (`District_id`) REFERENCES `DISTRICT` (`District_id`)
) ENGINE=InnoDB;";
$sql6 = "CREATE TABLE IF NOT EXISTS `BRANCH` (
  `Branch_id` int(11) NOT NULL AUTO_INCREMENT,
  `Branch_name` varchar(50) NOT NULL,
  `City_id` int(11) NOT NULL,
  PRIMARY KEY(`Branch_id`),
  FOREIGN KEY fk_BRANCH_City_id (`City_id`) REFERENCES `CITY` (`City_id`)
) ENGINE=InnoDB;";
$sql7 = "CREATE TABLE IF NOT EXISTS `SALESMAN` (
  `Salesman_id` int(11) NOT NULL AUTO_INCREMENT,
  `Branch_id` int(11) NOT NULL,
  `Salesman_name` varchar(50) NOT NULL,
  `Salesman_surname` varchar(50) NOT NULL,
  PRIMARY KEY(`Salesman_id`),
  FOREIGN KEY fk_SALESMAN_Branch_id (`Branch_id`) REFERENCES `BRANCH` (`Branch_id`)
) ENGINE=InnoDB;";
$sql8 = "CREATE TABLE IF NOT EXISTS `CUSTOMER` (
  `Customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `Customer_name` varchar(50) NOT NULL,
  `Customer_surname` varchar(50) NOT NULL,
  PRIMARY KEY(`Customer_id`)
) ENGINE=InnoDB;";
$sql9 = "CREATE TABLE IF NOT EXISTS `BOOK` (
  `Book_id` int(11) NOT NULL AUTO_INCREMENT,
  `Book_name` varchar(50) NOT NULL,
  `Price` int(11) NOT NULL,
  PRIMARY KEY(`Book_id`)
) ENGINE=InnoDB;";
$sql10 = "CREATE TABLE IF NOT EXISTS `SALE` (
  `Sale_id` int(11) NOT NULL AUTO_INCREMENT,
  `Salesman_id` int(11) NOT NULL,
  `Book_id` int(11) NOT NULL,
  `Customer_id` int(11) NOT NULL,
  `Sale_amount` int(11) NOT NULL,
  `Sale_date` date NOT NULL,
  PRIMARY KEY(`Sale_id`),
  FOREIGN KEY fk_SALE_Salesman_id (`Salesman_id`) REFERENCES `SALESMAN` (`Salesman_id`),
  FOREIGN KEY fk_SALE_Book_id (`Book_id`) REFERENCES `BOOK` (`Book_id`),
  FOREIGN KEY fk_SALE_Customer_id (`Customer_id`) REFERENCES `CUSTOMER` (`Customer_id`)
) ENGINE=InnoDB;";

$result1 = mysqli_query($conn,$sql1) or die("Error");
$result2 = mysqli_query($conn,$sql2) or die("Error");
$result3 = mysqli_query($conn,$sql3) or die("Error");
$result4 = mysqli_query($conn,$sql4) or die("Error");
$result5 = mysqli_query($conn,$sql5) or die("Error");
$result6 = mysqli_query($conn,$sql6) or die("Error");
$result7 = mysqli_query($conn,$sql7) or die("Error");
$result8 = mysqli_query($conn,$sql8) or die("Error");
$result9 = mysqli_query($conn,$sql9) or die("Error");
$result10 = mysqli_query($conn,$sql10) or die("Error");






	$row = 0;
	$row2 = 0;
	$row3 = 0;
	$row4 = 0;
	$row5 = 0;
	$header = NULL;
	$header2 = NULL;
	$header3 = NULL;
	$header4 = NULL;
	$header5 = NULL;
	$filename = "csv/Person_INFO.csv";
	$filename2 = "csv/Books_INFO.csv";
	$filename3 = "csv/Districts_INFO.csv";
	$filename4 = "csv/Cities_INFO.csv";
	$filename5 = "csv/Branches_INFO.csv";

	$isim = array();
	$soyisim = array();
	$bookisim = array();
	$District_id = array();
	$District_name = array();
	$City_id = array();
	$City_name = array();
	$City_District_id = array();
	$Branch_id = array();
	$Branch_name = array();
	$Branch_City_id = array();
	
	if(!file_exists($filename) || !is_readable($filename) || !file_exists($filename2) || !is_readable($filename2) || !file_exists($filename3) || !is_readable($filename3) || !file_exists($filename4) || !is_readable($filename4) || !file_exists($filename5) || !is_readable($filename5))
		return FALSE;
	
	
	
	if (($handle = fopen($filename, 'r')) !== FALSE)
	{
		
		while (($row = fgetcsv($handle, 1000, ';')) !== FALSE)
		{
			if(!$header)
				$header = $row;
			else{
				$isim[] = $row[0];
				$soyisim[] = $row[1];
				
				
			}
		}
		
		fclose($handle);
	}
	if (($handle = fopen($filename2, 'r')) !== FALSE)
	{
		
		while (($row2 = fgetcsv($handle, 1000, ';')) !== FALSE)
		{
			if(!$header2)
				$header2 = $row2;
			else{
				$bookisim[] = $row2[0];
				
				
			}
		}
		
		fclose($handle);
	}
	if (($handle = fopen($filename3, 'r')) !== FALSE)
	{
		
		while (($row3 = fgetcsv($handle, 1000, ';')) !== FALSE)
		{
			if(!$header3)
				$header3 = $row3;
			else{
				$District_id[] = $row3[0];
				$District_name[] = $row3[1];
				
				
			}
		}
		
		fclose($handle);
	}
	if (($handle = fopen($filename4, 'r')) !== FALSE)
	{
		
		while (($row4 = fgetcsv($handle, 1000, ';')) !== FALSE)
		{
			if(!$header4)
				$header4 = $row4;
			else{
				$City_id[] = $row4[0];
				$City_name[] = $row4[1];
				$City_District_id[] = $row4[2];
				
				
			}
		}
		
		fclose($handle);
	}
	if (($handle = fopen($filename5, 'r')) !== FALSE)
	{
		
		while (($row5 = fgetcsv($handle, 1000, ';')) !== FALSE)
		{
			if(!$header5)
				$header5 = $row5;
			else{
				$Branch_id[] = $row5[0];
				$Branch_name[] = $row5[1];
				$Branch_City_id[] = $row5[2];
				
				
			}
		}
		
		fclose($handle);
	}
	
	
	
	$lastitem1=sizeof($isim)-1;
	$lastitem2=sizeof($soyisim)-1;
	
	for($i=0;$i<2025;$i++){
		$rand1=rand(0,$lastitem1);
		$rand2=rand(0,$lastitem2);
		$sql11 = "INSERT INTO `CUSTOMER` (`Customer_id`, `Customer_name`, `Customer_surname`) VALUES
(0,'".$isim[$rand1]."','".$soyisim[$rand2]."');";
				mysqli_query($conn,$sql11) or die("Error");
		
	}

	for($i=0;$i<500;$i++){
		$rand3=rand(20,100);
		$sql12 = "INSERT INTO `BOOK` (`Book_id`, `Book_name`, `Price`) VALUES
(0,'".$bookisim[$i]."',$rand3);";
				mysqli_query($conn,$sql12) or die("Error");
		
	}

	for($i=0;$i<7;$i++){
		$sql13 = "INSERT INTO `DISTRICT` (`District_id`, `District_name`) VALUES
('".$District_id[$i]."','".$District_name[$i]."');";
				mysqli_query($conn,$sql13) or die("Error");
		
	}
	
	for($i=0;$i<81;$i++){
		$sql14 = "INSERT INTO `CITY` (`City_id`, `City_name`, `District_id`) VALUES
('".$City_id[$i]."','".$City_name[$i]."','".$City_District_id[$i]."');";
				mysqli_query($conn,$sql14) or die("Error");
		
	}
	
	for($ii=1;$ii<=81;$ii++){
		$counterr=0;
		for($i=0;$i<976;$i++){
		if($Branch_City_id[$i]==$ii && $counterr<5){
			$sql15 = "INSERT INTO `BRANCH` (`Branch_id`, `Branch_name`, `City_id`) VALUES
(0,'".$Branch_name[$i]."','".$Branch_City_id[$i]."');";
			mysqli_query($conn,$sql15) or die("Error");
			$counterr++;
		}
		
		
		
		}
	}
	for($itr=1;$itr<=405;$itr++){
		for($i=0;$i<4;$i++){
		$rand4=rand(0,$lastitem1);
		$rand5=rand(0,$lastitem2);
		$sql11 = "INSERT INTO `SALESMAN` (`Salesman_id`, `Branch_id`, `Salesman_name`, `Salesman_surname`) VALUES
(0,$itr,'".$isim[$rand4]."','".$soyisim[$rand5]."');";
				mysqli_query($conn,$sql11) or die("Error");
		
		}
	}
	
	for($itr=1;$itr<=2025;$itr++){
		for($i=0;$i<10;$i++){
		$rand6=rand(1,1620);
		$rand7=rand(1,500);
		$rand8=rand(1,7);
		$randomyear=rand("2010","2020");
		$randommonth=rand("1","12");
		$randomday=rand("1","30");
		if(($randommonth==2 && $randomday==30) || ($randommonth==2 && $randomday==29)){$randomday="28";}
		$datee="$randomyear-$randommonth-$randomday";
		$sql11 = "INSERT INTO `SALE` (`Sale_id`, `Salesman_id`, `Book_id`, `Customer_id`, `Sale_amount`, `Sale_date`) VALUES
(0,$rand6,$rand7,$itr,$rand8,'$randomyear-$randommonth-$randomday');";
				mysqli_query($conn,$sql11) or die("Error");
		
		}
	}






mysqli_close($conn);
?>