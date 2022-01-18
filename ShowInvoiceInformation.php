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


$sql="SELECT district.District_name, city.City_name,branch.Branch_name,salesman.Salesman_name,salesman.Salesman_surname,book.Book_name,sale.Sale_amount,sale.Sale_date
FROM customer,district,city,branch,salesman,book,sale
WHERE customer.Customer_name='" . $_POST['customername'] . "' and customer.Customer_surname='" . $_POST['customersurname'] . "' and city.District_id=district.District_id and branch.City_id=city.City_id and salesman.Branch_id=branch.Branch_id and salesman.Salesman_id=sale.Salesman_id and sale.Customer_id=customer.Customer_id and sale.Book_id=book.Book_id
";

$result = mysqli_query($conn,$sql) or die("Error");
// SELECT district.District_name, city.City_name,branch.Branch_name,salesman.Salesman_name,salesman.Salesman_surname,book.Book_name,sale.Sale_amount,sale.Sale_date
// FROM customer,district,city,branch,salesman,book,sale
// WHERE customer.Customer_name='" . $_POST['customername'] . "' and customer.Customer_surname='" . $_POST['customersurname'] . "' and city.District_id=district.District_id and branch.City_id=city.City_id and salesman.Branch_id=branch.Branch_id and salesman.Salesman_id=sale.Salesman_id and sale.Customer_id=customer.Customer_id and sale.Book_id=book.Book_id

if (mysqli_num_rows($result) > 0) {
    // output data of each row
	echo "<table border='1'>";
	echo "<tr><td>district name</td><td>province name</td><td>branch name</td><td>employee name</td><td>employee surname</td><td>book name</td><td>sale amount</td><td>date</td></tr>";
    while($row = mysqli_fetch_array($result)) {
		echo "<tr>";
        echo "<td>" . $row[0]. "</td><td>" . $row[1]. "</td><td>" . $row[2]. "</td><td>" . $row[3]. "</td><td>" . $row[4]. "</td><td>" . $row[5]. "</td><td>" . $row[6]. "</td><td>" . $row[7]. "</td>";
		echo "</tr>";
    }
	echo "</table>";
} else {
    echo "0 results";
}
mysqli_close($conn);
?>