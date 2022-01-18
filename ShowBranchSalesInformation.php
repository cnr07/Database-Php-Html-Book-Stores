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



$sql="SELECT customer.Customer_name,customer.Customer_surname,SUM(sale.Sale_amount),SUM(sale.Sale_amount*book.Price)
FROM branch,sale,salesman,customer,book
WHERE branch.Branch_id='" . $_REQUEST['selection3'] . "' && sale.Book_id=book.Book_id && sale.Customer_id=customer.Customer_id && salesman.Branch_id=branch.Branch_id && salesman.Salesman_id=sale.Salesman_id 
GROUP BY customer.Customer_id;";


$result = mysqli_query($conn,$sql) or die("Error");


if (mysqli_num_rows($result) > 0) {
	
	echo "<table border='1'>";
	echo "<tr><td>customer name</td><td>customer surname</td><td># of sales</td><td>total price</td></tr>";
    while($row = mysqli_fetch_array($result)) {
		
		echo "<tr>";
		echo "<td>" . $row[0]. "</td><td>" . $row[1]. "</td><td>" . $row[2]. "</td><td>" . $row[3].  "</td>";
		echo "</tr>";
		
    }
	echo "</table>";
	
} else {
    echo "0 results";
}
echo "<br></br>";

$sql2="SELECT salesman.Salesman_name,salesman.Salesman_surname,SUM(sale.Sale_amount),SUM(sale.Sale_amount*book.Price)
FROM branch,sale,salesman,customer,book
WHERE branch.Branch_id='" . $_REQUEST['selection3'] . "' && sale.Book_id=book.Book_id && sale.Customer_id=customer.Customer_id && salesman.Branch_id=branch.Branch_id && salesman.Salesman_id=sale.Salesman_id 
GROUP BY salesman.Salesman_id;";
$result2 = mysqli_query($conn,$sql2) or die("Error");
if (mysqli_num_rows($result2) > 0) {
	
	echo "<table border='1'>";
	echo "<tr><td>employee name</td><td>employee surname</td><td># of sales</td><td>total price</td></tr>";
    while($row = mysqli_fetch_array($result2)) {
		
		echo "<tr>";
		echo "<td>" . $row[0]. "</td><td>" . $row[1]. "</td><td>" . $row[2]. "</td><td>" . $row[3].  "</td>";
		echo "</tr>";
		
    }
	echo "</table>";
	
} else {
    echo "0 results";
}



mysqli_close($conn);
?>