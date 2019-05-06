<?php
$vote = $_REQUEST['vote'];
$id = 1;
//get content of textfile
//$filename = "poll_result.txt";
//$content = file($filename);
$DB_SERVER = "p:127.0.0.1:3306";
$DB_USERNAME = "saswata";
$DB_PASSWORD = "saswata";

// Create connection
$conn = new mysqli($DB_SERVER, $DB_USERNAME, $DB_PASSWORD);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//Create database
$conn->query('CREATE DATABASE IF NOT EXISTS POLL;');
mysqli_select_db($conn, 'POLL');
//Create table
$sql = "CREATE TABLE IF NOT EXISTS POLL_RESULTS(id INT(6) AUTO_INCREMENT PRIMARY KEY, 
YES INT(6) NOT NULL,
NO INT(6) NOT NULL);";
$conn->query($sql);
//put content in array
$sql = 'SELECT * FROM POLL_RESULTS WHERE ID =' . $id .';';
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
$yes = $row[YES];
$no = $row[NO];
}
else{
  $yes = 0;
  $no = 0;
}
if ($vote == 1) {
  $yes = $yes + 1;
}
if ($vote == 0) {
  $no = $no + 1;
} 
//insert votes to db
$sql = "INSERT INTO funds (id, YES, NO)
    VALUES ($id, $yes, $no)
        ON DUPLICATE KEY UPDATE YES = $yes, NO = $no;";
$conn->query($sql);
//$insertvote = $yes."||".$no;
//$fp = fopen($filename,"w");
//fputs($fp,$insertvote);
//fclose($fp);
?>

<h2>Result:</h2>
<table>
<tr>
<td>Yes:</td>
<td>
<img src="poll.gif"
width='<?php echo(100*round($yes/($no+$yes),2)); ?>'
height='20'>
<?php echo(100*round($yes/($no+$yes),2)); ?>%
</td>
</tr>
<tr>
<td>No:</td>
<td>
<img src="poll.gif"
width='<?php echo(100*round($no/($no+$yes),2)); ?>'
height='20'>
<?php echo(100*round($no/($no+$yes),2)); ?>%
</td>
</tr>
</table>
