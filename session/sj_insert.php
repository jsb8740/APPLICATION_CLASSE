<!--20183346 정승백 -->
<!doctype html>
<html>
<body>
<head>
<title> 과목 정보 입력 </title>

<style>
table {
	margin:auto;
    width: 500px;
    border: 3px solid #73AD21;
    padding: 10px;
}
tr {
	height:50px;
}
td {	
	text-align : center;
	font-weight : bold;
	width : 200px;
}
th {
	font-size : 18px;
	color : blue;
}
h3 {
	color : blue;
	text-align : center;
}

tr:nth-child(odd) {background-color: #f2f2f2;}
input[type=submit], input[type=reset] {
	font-size : 16px;
	font-weight:bold;
}
div {
	 position:relative;
	 left:75%;
	 top:15px;
}
</style>
</head>

<body>

<form method="post" action="sj_insert.php"> 
<table> 
<tr>
  <th colspan="2"> 과목 정보 입력 </th>
</tr>

<tr> 
  <td> 과목코드 </td> 
  <td> <input type="text" name="sj_code" placeholder="CS000"> </td>
</tr>
<tr> 
  <td> 과목이름 </td> <td> <input type="text" name="sj_name"> </td>
</tr>
<tr> 
  <td> 제한인원 </td> <td> <input type="text" name="sj_limit"> </td>
</tr>
<tr> 
  <td> 개설학년 </td> 
  <td> <select name="sj_grade"> 
       <option value="1"> 1 </option>
	   <option value="2"> 2 </option>
	   <option value="3"> 3 </option>
	   <option value="4"> 4 </option>
  </td>
</tr>
<tr> 
  <td> 개설학기 </td> 
  <td> <input type="radio" name="sj_sem" value="1" checked> 
       <label for="1"> 1 </label> 
	   <input type="radio" name="sj_sem" value="2"> 
	   <label for="2"> 2 </label> 
  </td>
</tr> 
<tr>
  <td> 학점수 </td> 
  <td> <select name="sj_credit"> 
       <option value="1"> 1 </option>
	   <option value="2"> 2 </option>
	   <option value="3"> 3 </option>
  </td>
</tr>
<tr>
  <td> 수업시수 </td> 
  <td> <select name="sj_num_class"> 
       <option value="1"> 1 </option>
	   <option value="2"> 2 </option>
	   <option value="3"> 3 </option>
	   <option value="3"> 4 </option>
	   <option value="3"> 5 </option>
	   <option value="3"> 6 </option>
  </td>
</tr>
<tr>
  <td> 학수구분 </td> 
  <td> 
       <input type="radio" name="sj_cate" value="선택" checked> 
       <label for="선택"> 선택 </label> 
	   <input type="radio" name="sj_cate" value="필수"> 
	   <label for="필수"> 필수 </label> 
  </td>
</tr>

<tr> 
  <td colspan="2"> <input type="submit" value="저장" name="submit"> 
                   <input type="reset" value="다시쓰기" name="reset"> </td>
</tr>

</table>
<div><a href="admin.php"> 관리자 페이지로... </a></div>
</form>

</body>
</html>

<?
	$dbc=mysqli_connect("localhost", "root", "", "proj20");
	
	if (isset($_POST['submit'])) {	//저장버튼 누르면
		$code=$_POST['sj_code'];
		$name=$_POST['sj_name'];
		$limit=$_POST['sj_limit'];
		$credit=$_POST['sj_credit'];
		$num_class=$_POST['sj_num_class'];
		$grade=$_POST['sj_grade'];
		$sem=$_POST['sj_sem'];
		$cate=$_POST['sj_cate'];
		
		$query="insert into subjects values('$code','$name','$limit','$credit','$num_class','$grade','$sem', '$cate')";
		$result=mysqli_query($dbc, $query);
		
		/*if ($result)
			echo "성공";
		else
			echo "실패";*/
		
	}
	mysqli_close($dbc);
?>