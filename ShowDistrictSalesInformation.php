<?php
set_time_limit(0);
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "can_erdoğan";


$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} 


// $countpage=0;

// if($countpage==0){
	// $countpage=1;
	// $page = $_SERVER['ShowDistrictSalesInformation.php'];
	// $sec = "3";
	// header("Refresh: $sec; url=$page");
	// echo "asd";
// }


$sql="SELECT branch.Branch_name,city.City_name,district.District_name,SUM(sale.Sale_amount),salesman.Salesman_name, salesman.Salesman_surname
FROM branch,city,district,sale,salesman
WHERE city.District_id = district.District_id && district.District_id='" . $_REQUEST['selection'] . "' && branch.City_id=city.City_id && sale.Salesman_id=salesman.Salesman_id && salesman.Branch_id=branch.Branch_id
GROUP BY sale.Salesman_id;";


$result = mysqli_query($conn,$sql) or die("Error");

$maxmin_isim=array();
$maxmin_soyisim=array();
$maxmin_amount=array();
$branch_counter=0;
$maxmin_amounttotal=0;
if (mysqli_num_rows($result) > 0) {
	
	echo "<table border='1'>";
	echo "<tr><td>Branch</td><td>Province</td><td>District</td><td>EmpNameMostSale</td><td>EmpSurnameMostSale</td><td>SaleAmtMostSale</td><td>EmpNameLeastSale</td><td>EmpSurnameLeastSale</td><td>SaleAmtLeastSale</td><td>TotalIncomeAmt</td></tr>";
    while($row = mysqli_fetch_array($result)) {
		$maxmin_amounttotal+=$row[3];
		$maxmin_amount[$branch_counter]=$row[3];
		$maxmin_isim[$branch_counter]=$row[4];
		$maxmin_soyisim[$branch_counter]=$row[5];
		$branch_counter++;
		
			
		if($branch_counter==4){
			$min_amount=$maxmin_amount[0];
			$min_isim=$maxmin_isim[0];
			$min_soyisim=$maxmin_soyisim[0];
			for($iterr=0;$iterr<$branch_counter-1;$iterr++){
				for($ii=0;$ii<$branch_counter-$iterr-1;$ii++){
					if($maxmin_amount[$ii]>$maxmin_amount[$ii+1]){
						$tempp=$maxmin_amount[$ii];
						$tempp2=$maxmin_isim[$ii];
						$tempp3=$maxmin_soyisim[$ii];
						
						$maxmin_amount[$ii]=$maxmin_amount[$ii+1];
						$maxmin_isim[$ii]=$maxmin_isim[$ii+1];
						$maxmin_soyisim[$ii]=$maxmin_soyisim[$ii+1];
						
						$maxmin_amount[$ii+1]=$tempp;
						$maxmin_isim[$ii+1]=$tempp2;
						$maxmin_soyisim[$ii+1]=$tempp3;
					}
				}
				
			
			}
			
			
			
			echo "<tr>";
			echo "<td>" . $row[0]. "</td><td>" . $row[1]. "</td><td>" . $row[2]. "</td><td>" . $maxmin_isim[3]. "</td><td>" . $maxmin_soyisim[3]. "</td><td>" . $maxmin_amount[3]. "</td><td>" . $maxmin_isim[0]. "</td><td>" . $maxmin_soyisim[0]. "</td><td>" . $maxmin_amount[0]. "</td><td> $maxmin_amounttotal </td>";
			echo "</tr>";
			$branch_counter=0;
			$maxmin_amounttotal=0;
			for($itrrr=0;$itrrr<4;$itrrr++){
				$maxmin_isim[$itrrr]="";
				$maxmin_soyisim[$itrrr]="";
				$maxmin_amount[$itrrr]=0;
			}
			
		}
		
    }
	echo "</table>";
	
} else {
    echo "0 results";
}
echo "<br></br>";

// SELECT salesman.Salesman_name,salesman.Salesman_surname,branch.Branch_name,city.City_name,district.District_name, customer.Customer_name,customer.Customer_surname,SUM(sale.Sale_amount*book.Price)
// FROM salesman,branch,city,district,sale,customer,book
// WHERE city.District_id = district.District_id && district.District_id=1 && branch.City_id=city.City_id && sale.Salesman_id=salesman.Salesman_id && salesman.Branch_id=branch.Branch_id && sale.Customer_id=customer.Customer_id && sale.Book_id=book.Book_id 
// GROUP BY customer.Customer_id

$result0=mysqli_query($conn,"SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))") or die("Error");

// $sql2="SELECT salesman.Salesman_name,salesman.Salesman_surname,branch.Branch_name,city.City_name,district.District_name, customer.Customer_name,customer.Customer_surname,MAX(sale.Sale_amount*book.Price)
// FROM salesman,branch,city,district,sale,customer,book
// WHERE city.District_id = district.District_id && district.District_id='" . $_REQUEST['selection'] . "' && branch.City_id=city.City_id && sale.Salesman_id=salesman.Salesman_id && salesman.Branch_id=branch.Branch_id && sale.Customer_id=customer.Customer_id && sale.Book_id=book.Book_id && book.Book_id=sale.Book_id
// GROUP BY customer.Customer_id";
$sql2="SELECT salesman.Salesman_name,salesman.Salesman_surname,branch.Branch_name,city.City_name,district.District_name, customer.Customer_name,customer.Customer_surname,SUM(sale.Sale_amount*book.Price)
FROM salesman,branch,city,district,sale,customer,book
WHERE city.District_id = district.District_id && district.District_id='" . $_REQUEST['selection'] . "'  && branch.City_id=city.City_id && sale.Salesman_id=salesman.Salesman_id && salesman.Branch_id=branch.Branch_id && sale.Customer_id=customer.Customer_id && sale.Book_id=book.Book_id 
GROUP BY customer.Customer_id";
$result2 = mysqli_query($conn,$sql2) or die("Error");

$maxpaid_empisim=array();
$maxpaid_empsoyisim=array();
$maxpaid_branch=array();
$maxpaid_city=array();
$maxpaid_customerisim=array();
$maxpaid_customersoyisim=array();
$maxpaid_price=array();
$maxpaid_counter=0;
$maxpaid_district="";
$maxpaid_pricetotal=0;
if (mysqli_num_rows($result2) > 0) {
	
	echo "<table border='1'>";
	echo "<tr><td>EmpName</td><td>EmpLName</td><td>Branch</td><td>Province</td><td>District</td><td>MaxPaidCustomerName</td><td>MaxPaidCustomerSurname</td><td>TotalSalesIncome</td></tr>";
    while($row = mysqli_fetch_array($result2)) {
		$maxpaid_pricetotal+=$row[7];
		if($maxpaid_counter==0){
			$maxpaid_empisim[$maxpaid_counter]=$row[0];
			$maxpaid_empsoyisim[$maxpaid_counter]=$row[1];
			$maxpaid_branch[$maxpaid_counter]=$row[2];
			$maxpaid_city[$maxpaid_counter]=$row[3];
			$maxpaid_customerisim[$maxpaid_counter]=$row[5];
			$maxpaid_customersoyisim[$maxpaid_counter]=$row[6];
			$maxpaid_price[$maxpaid_counter]=$row[7];
			
			$maxpaid_counter++;
		}
		else{
			$temp_maxpaid_empisim=$row[0];
			$temp_maxpaid_empsoyisim=$row[1];
			$temp_maxpaid_branch=$row[2];
			$temp_maxpaid_city=$row[3];
			$temp_maxpaid_customerisim=$row[5];
			$temp_maxpaid_customersoyisim=$row[6];
			$temp_maxpaid_price=$row[7];
			if($temp_maxpaid_price>$maxpaid_price[$maxpaid_counter-1] && $temp_maxpaid_empisim==$maxpaid_empisim[$maxpaid_counter-1] && $temp_maxpaid_empsoyisim==$maxpaid_empsoyisim[$maxpaid_counter-1]){
				
				$maxpaid_branch[$maxpaid_counter-1]=$row[2];
				$maxpaid_city[$maxpaid_counter-1]=$row[3];
				$maxpaid_customerisim[$maxpaid_counter-1]=$row[5];
				$maxpaid_customersoyisim[$maxpaid_counter-1]=$row[6];
				$maxpaid_price[$maxpaid_counter-1]=$row[7];
				
			}
			if(($temp_maxpaid_empisim!=$maxpaid_empisim[$maxpaid_counter-1] && $temp_maxpaid_empsoyisim!=$maxpaid_empsoyisim[$maxpaid_counter-1]) || ($temp_maxpaid_empisim!=$maxpaid_empisim[$maxpaid_counter-1] && $temp_maxpaid_empsoyisim==$maxpaid_empsoyisim[$maxpaid_counter-1]) || ($temp_maxpaid_empisim==$maxpaid_empisim[$maxpaid_counter-1] && $temp_maxpaid_empsoyisim!=$maxpaid_empsoyisim[$maxpaid_counter-1]) ){
				$maxpaid_pricetotal-=$row[7];
				echo "<tr>";
				echo "<td>" . $maxpaid_empisim[$maxpaid_counter-1]. "</td><td>" . $maxpaid_empsoyisim[$maxpaid_counter-1]. "</td><td>" . $maxpaid_branch[$maxpaid_counter-1]. "</td><td>" . $maxpaid_city[$maxpaid_counter-1]. "</td><td>" . $row[4]. "</td><td>" . $maxpaid_customerisim[$maxpaid_counter-1]. "</td><td>" . $maxpaid_customersoyisim[$maxpaid_counter-1]. "</td><td>" .$maxpaid_pricetotal.  "</td>";
				echo "</tr>";
				$maxpaid_pricetotal=$row[7];
				$maxpaid_empisim[$maxpaid_counter]=$row[0];
				$maxpaid_empsoyisim[$maxpaid_counter]=$row[1];
				$maxpaid_branch[$maxpaid_counter]=$row[2];
				$maxpaid_city[$maxpaid_counter]=$row[3];
				$maxpaid_customerisim[$maxpaid_counter]=$row[5];
				$maxpaid_customersoyisim[$maxpaid_counter]=$row[6];
				$maxpaid_price[$maxpaid_counter]=$row[7];
				$maxpaid_counter++;
			}
		}
		$maxpaid_district=$row[4];
		
		
			
		
		
    }
	echo "<tr>";
	echo "<td>" . $maxpaid_empisim[$maxpaid_counter-1]. "</td><td>" . $maxpaid_empsoyisim[$maxpaid_counter-1]. "</td><td>" . $maxpaid_branch[$maxpaid_counter-1]. "</td><td>" . $maxpaid_city[$maxpaid_counter-1]. "</td><td>"  .$maxpaid_district. "</td><td>" . $maxpaid_customerisim[$maxpaid_counter-1]. "</td><td>" . $maxpaid_customersoyisim[$maxpaid_counter-1]. "</td><td>" .$maxpaid_pricetotal.   "</td>";
	echo "</tr>";
	echo "</table>";
	
} else {
    echo "0 results";
}




mysqli_close($conn);
?>