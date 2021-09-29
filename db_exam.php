<?
	$dbc=mysqli_connect("localhost", "root", "", "proj20");
	
	$query1="select ptel from prof where pname='최조천'";
	$result=mysqli_query($dbc, $query1);
	
	if (mysqli_num_rows($result) == 1) {
		$row=mysqli_fetch_array($result);
		print "최조천 교수님의 전화번호: ".$row['ptel']."<br>";
	}
	
	$query2="select pmail from prof where pname='김건웅'";
	$result=mysqli_query($dbc, $query2);
	
	if (mysqli_num_rows($result) == 1) {
		$row=mysqli_fetch_array($result);
		print "김건웅 교수님의 이메일: ".$row['pmail']."<br>";
	}
	
	$query3="select pid from prof where pname='정종면'";
	$result=mysqli_query($dbc, $query3);
	
	if (mysqli_num_rows($result) == 1) {
		$row=mysqli_fetch_array($result);
		print "정종면 교수님의 사번: ".$row['pid']."<br>";
	}
	
	$query4="select rcap from room where rid='7507'";
	$result=mysqli_query($dbc, $query4);
	
	if (mysqli_num_rows($result) == 1) {
		$row=mysqli_fetch_array($result);
		print "7507 강의실 수용 인원: ".$row['rcap']."<br>";
	}
	
	$query5="select rid from room where rcap>50";
	$result=mysqli_query($dbc, $query5);
	
	print "수용인원이 50명 이산인 모든 강의실: ";
	while($row=mysqli_fetch_array($result)) {
		echo $row['rid']."   ";
	}
	mysqli_close($dbc);
?>