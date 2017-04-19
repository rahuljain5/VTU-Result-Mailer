<?php

function curlit($usn,$to)
{
  $curl_handle=curl_init();
  curl_setopt($curl_handle,CURLOPT_URL,'http://results.vtu.ac.in/results/result_page.php?usn='.$usn);
  curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
  curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
  $buffer = curl_exec($curl_handle);
  curl_close($curl_handle);
  if (empty($buffer)){
      print "Nothing returned from url.<p>";
  }
  else{
      	$found=0;
		$found=stripos($buffer,'<script type="text/javascript">');
		if($found)
		{
			echo "Result Yet Not Available";
		}
		else if($found === false)
		{
		//	print $buffer;
			// Strip Everything 
			$extract = array("start" =>'	<div class="row" style="margin-top:20px;">', "end"=>'																			</table>');
		$start = stripos($buffer, $extract['start']);
		$end = strripos($buffer, $extract['end']);
		$buffer = substr($buffer, $start, $end);
	$conn = new mysqli('localhost','username','password','dbname');
		$sql="DELETE FROM `result` WHERE `usn`='$usn' and `email`='$to'";
		$conn->query($sql);
		$conn->close();
		
		$buffer=$buffer."</table>";
		$subject = "Result email";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: results@vturesult.000webhostapp.com' . "\r\n";
		mail($to,$subject,$buffer,$headers);
		//print $buffer;
		}
  }
}
$conn = new mysqli('localhost','username','password','dbname');
$sql="SELECT `email`,`usn` FROM `result`";
$result = $conn->query($sql);
$conn->close();	
 while($row = $result->fetch_assoc()) {
	 $usn=$row["usn"];
	 $email=$row["email"];
	 curlit($usn,$email);
	 usleep(2000);
	 
 }



?>