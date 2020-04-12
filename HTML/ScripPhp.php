<?php
echo $action = $_REQUEST['action'];

parse_str($_REQUEST['dataku'], $hasil);  
echo "firstname: ".$hasil['firstName']."<br/>";
echo "lastname: ".$hasil['lastName']."<br/>";
echo "username: ".$hasil['Username']."<br/>";

//$hasil = $_REQUEST;

/* SQL: select, update, delete */

if($action == 'create')
	$syntaxsql = "insert into tbl_billing values (null, '$hasil[firstName]', '$hasil[lastName]', '$hasil[Username]', '$hasil[Email]', '$hasil[Address]',now())";
elseif($action == 'update')
	$syntaxsql = "update tbl_billing set first_name = '$hasil[firstName]', last_name = '$hasil[lastName]', Username = '$hasil[Username]',
	Email = '$hasil[Email]', Address = '$hasil[Address]'";
elseif($action == 'delete')
	$syntaxsql = "delete from tbl_billing where username = '$hasil[username]'";
elseif($action == 'read')
	$syntaxsql = "select * from tbl_billing";
	
//eksekusi syntaxsql 
$conn = new mysqli("localhost","root","","formTira"); //dbhost, dbuser, dbpass, dbname
if ($conn->connect_errno) {
  echo "Failed to connect to MySQL: " . $conn -> connect_error;
  exit();
}else{
  echo "Database connected. ";
}
//create, update, delete query($syntaxsql) -> true false
if ($conn->query($syntaxsql) === TRUE) {
	echo "Query $action with syntax $syntaxsql suceeded !";
}
elseif ($conn->query($syntaxsql) === FALSE){
	echo "Error: $syntaxsql" .$conn->error;
}
//khusus read query($syntaxsql) -> semua associated array
else{
	$result = $conn->query($syntaxsql); //bukan true false tapi data array asossiasi
	if($result->num_rows > 0){
		echo "<table id='tresult' class='table table-striped table-bordered'>";
		echo "<thead><th>First_name</th><th>Last_name</th><th>Username</th><th>Email</th><th>Address</th></thead>";
		echo "<tbody>";
		while($row = $result->fetch_assoc()) {
			echo "<tr><td>". $row['First_name']."</td><td>". $row['Last_name']."</td><td>". $row['Username']."</td><td>". $row['Email']."</td><td>". $row['Address']."</td></tr>";
		}
		echo "</tbody>";
		echo "</table>";
	}
}
$conn->close();

?>