<html>
<head>
<link rel="stylesheet" href="https://bootswatch.com/cosmo/bootstrap.min.css"/>
<link rel="stylesheet" href="../css/hover-min.css" media="all"/>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" media="all">
<title>Get Result</title>
</head>
<body>
<?php
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
$emerr=$uerr=$usn=$email="";
if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["register"]))
{
  $ok=1;
$usn=test_input($_POST["usn"]);
$email=test_input($_POST["email"]);
if($usn=="" || $usn==NULL)
{
	$uerr="USN canot be empty";
	$ok=0;
}
if($email=="" || $email==NULL)
  {
    $ok=0;
    $emerr="EMAIL CANNOT BE EMPTY";
  }
  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $ok=0;
    $emerr = "INVALID EMAIL FORMAT";
  }
if($ok)
{
$conn = new mysqli('localhost','username','password','dbname');
$sql="INSERT INTO `result`(`email`, `usn`) VALUES ('$email','$usn')";
$result = $conn->query($sql);
$emerr="DataBase Updated";
}
}
?>
<div class="container">
  <div class="row">
  <div class="col-sm-4"></div>
<div class="col-sm-4"><h2 "text-center">Register</h2><p>Get Your Result on Mail as soon as it comes on VTU SITE</p><p class="help-block">Note There might be Delay if VTU SITE is under load</p><p>Keep Checking Your SPAM Folder too </p></div>
<div class="col-sm-4"></div>
</div>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
  <div class="form-group">
  <input class="form-control" type="text" placeholder="USN" name="usn" value="<?php echo $usn; ?>"/>
  <label style="color:red;"><?php echo $uerr; ?> </label>
</div>
<div class="form-group">
<input class="form-control" type="email" placeholder="EMAIL" name="email"value="<?php echo $email; ?>"/>
<label style="color:red;"><?php echo $emerr; ?> </label>
</div>
<div class="form-group">
<input class="btn btn-primary hvr-grow-shadow hvr-round-corners btn-block" type="submit" name="register" value="Register"/>
</div><!--Register -->
</form>
</div>
</body>
</html>
