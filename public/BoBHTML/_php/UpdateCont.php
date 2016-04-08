<?php
session_start();
if(sizeof($_POST)==0)
{
header("Location:UpDateCont.html");//sends back to browser if someone comes here first must be 1st thing before code.
exit();
}

if(isset($_SESSION[0]))
    $contId = $_SESSION[0];
else{
	header("Location:UpDateCont.html");//This and above path has to be changed
    exit();
}

if(isset($_POST['txtfirstName']))//Not sure if this code  is OK
{
$fName = $_POST['txtfirstName'];
}
else
{
$fName = "notsubmitted";
}
if(isset($_POST['txtlastName']))
{
$lName = $_POST['txtlastName'];
}
else
{
$lName = "notsubmitted";
}
if(isset($_POST['txtAddress']))
{
$Address = $_POST['txtAddress'];
}
else
{
$Address = "notsubmitted";
}
if(isset($_POST['txtCity']))
{
$City = $_POST['txtCity'];
}
else
{
$City = "notsubmitted";
}
if(isset($_POST['lstState']))
{
$State = $_POST['lstState'];
}
else
{
$State = "notsubmitted";
}
if(isset($_POST['txtZip']))
{
$Zip = $_POST['txtZip'];
}
else
{
$Zip = "notsubmitted";
}
if(isset($_POST['txtPhone']))
{
$Phone = $_POST['txtPhone'];
}
else
{
$Phone = "notsubmitted";
}
if(isset($_POST['txteMail']))
{
$eMail = $_POST['txteMail'];
}
else
{
$eMail = "notsubmitted";
}
if(isset($_POST['txtPassword']))
{
$Password = $_POST['txtPassword']; //This can't be null'
}
else
{
$Password = "notsubmitted";
}
//Saved this if we need to use
/*$fName = $_POST['txtfirstName'];
$lName = $_POST['txtlastName'];
$Address = $_POST['txtAddress'];
$City = $_POST['txtCity'];
$State = $_POST['lstState'];
$Zip = $_POST['txtZip'];
$Phone = $_POST['txtPhone'];
$eMail = $_POST['txteMail'];
$Password = $_POST['txtPassword'];*/

$serverName = "MPC-11123359\SQLEXPRESS";//needs to be agilebob


$connectionInfo = array("Database" => "bobdb"); //BOB uid and password


$conn = sqlsrv_connect($serverName, $connectionInfo);


if (!$conn) {
    echo("Something went wrong while connecting to MSSQL");
} else {
    echo "Connection Established";

}
/* Define the Transact-SQL query. Use question marks (?) in place of
the parameters to be passed to the stored procedure */
$tsql_callSP = "{call sp_UpdateContestants( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";

/* Define the parameter array. By default, the first parameter is an
INPUT parameter. The second parameter is specified as an INOUT
parameter. To ensure data type integrity, output parameters should be
initialized before calling the stored procedure, or the desired
PHPTYPE should be specified in the $params array.*/
$Message = 0;
$contId = $SESSION[0];//this is set at login
$params = array(
                 array($contId, SQLSRV_PARAM_IN),
                 array($fName, SQLSRV_PARAM_IN),
                 array($lName, SQLSRV_PARAM_IN),
                 array($Address, SQLSRV_PARAM_IN),
                 array($City, SQLSRV_PARAM_IN),
                 array($State, SQLSRV_PARAM_IN),
                 array($Zip, SQLSRV_PARAM_IN),
                 array($eMail, SQLSRV_PARAM_IN),
                 array($Phone, SQLSRV_PARAM_IN),
                 array($Password, SQLSRV_PARAM_IN),
                 array($Message, SQLSRV_PARAM_OUT)//If updated a one is returned
                
                 
               );

/* Execute the query. */
$stmt3 = sqlsrv_query( $conn, $tsql_callSP, $params);
if( $stmt3 === false )
{
    echo "Error in executing statement 3.\n";
    die( print_r( sqlsrv_errors(), true));
}

/* Display the value of the output parameter $Message. */
sqlsrv_next_result($stmt3);
if ($Message == 1)
echo "Your changes have been saved";

/*Free the statement and connection resources. */
sqlsrv_free_stmt( $stmt3);
sqlsrv_close( $conn);

?>


<!--this can be removed or not-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

</head>

<body>
<center><h1>Battle in J113G</h1></center>
<center><h1>Thanks for your input!</h1></center>


<center><h3>You are Contestant:<? $Message?> </h3></center>
<center><table>
<tr>
<td>First Name:</td>
<td><?=$fName?></td>
</tr>
<tr>
<td>Last Name:</td>
<td><?=$lName?></td>
</tr>
<tr>
<td>Address:</td>
<td><?=$Address?></td>
</tr>
<tr>
<td>City:</td>
<td><?=$City?></td>
</tr>

<tr>
<td>State:</td>
<td><?=$State?></td>
</tr>
<tr>
<td>Zip:</td>
<td><?=$Zip?></td>
</tr>
<tr>
<td>Phone:</td>
<td><?=$Phone?></td>
</tr>
<tr>
<td>Email:</td>
<td><?=$eMail?></td>
</tr>
</table></center>




</body>

</html>
