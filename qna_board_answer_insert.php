<meta charset="utf-8">
<?php
    session_start();
    if (isset($_SESSION["userid"])) $userid = $_SESSION["userid"];
    else $userid = "";
    if (isset($_SESSION["username"])) $username = $_SESSION["username"];
    else $username = "";
	if (isset($_SESSION["userlevel"])) $userlevel = $_SESSION["userlevel"];
    else $userlevel = "";

    if ( !$userid)
    {
        echo("
                    <script>
                    alert('답변 작성은 로그인 후 이용해 주세요!');
                    history.go(-1)
                    </script>
        ");
                exit;
    }
	else if($userlevel != 1){
		echo("
                    <script>
                    alert('관리자만 답변을 작성할 수 있습니다!');
                    history.go(-1)
                    </script>
        ");
		exit;
	}
	

    $subject = $_POST["subject"];
    $content = $_POST["content"];
	$num = $_POST["num"];
	$root_id = $_POST["root_id"];

	$subject = htmlspecialchars($subject, ENT_QUOTES);
	$content = htmlspecialchars($content, ENT_QUOTES);

	$regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장

	$upload_dir = './data/';

	$upfile_name	 = $_FILES["upfile"]["name"];
	$upfile_tmp_name = $_FILES["upfile"]["tmp_name"];
	$upfile_type     = $_FILES["upfile"]["type"];
	$upfile_size     = $_FILES["upfile"]["size"];
	$upfile_error    = $_FILES["upfile"]["error"];

	if ($upfile_name && !$upfile_error)
	{
		$file = explode(".", $upfile_name);
		$file_name = $file[0];
		$file_ext  = $file[1];

		$new_file_name = date("Y_m_d_H_i_s");
		$new_file_name = $new_file_name;
		$copied_file_name = $new_file_name.".".$file_ext;      
		$uploaded_file = $upload_dir.$copied_file_name;

		if( $upfile_size  > 1000000 ) {
				echo("
				<script>
				alert('업로드 파일 크기가 지정된 용량(1MB)을 초과합니다!<br>파일 크기를 체크해주세요! ');
				history.go(-1)
				</script>
				");
				exit;
		}

		if (!move_uploaded_file($upfile_tmp_name, $uploaded_file) )
		{
				echo("
					<script>
					alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
					history.go(-1)
					</script>
				");
				exit;
		}
	}
	else 
	{
		$upfile_name      = "";
		$upfile_type      = "";
		$copied_file_name = "";
	}
	
	$con = mysqli_connect("localhost", "user1", "12345", "sample");

	$sql = "insert into qnaboard (id, name, subject, content, regist_day, hit,  file_name, file_type, file_copied, root_num, root_id, step, status) ";
	$sql .= "values('$userid', '$username', '$subject', '$content', '$regist_day', 0, ";
	$sql .= "'$upfile_name', '$upfile_type', '$copied_file_name', '$num','$root_id', 1, 2)";
	mysqli_query($con, $sql);  // $sql 에 저장된 명령 실행

	$sql = "update qnaboard set status=1 where num=$num";
	mysqli_query($con, $sql);  // $sql 에 저장된 명령 실행

	// 포인트 부여하기
  	$point_up = 100;

	$sql = "select point from members where id='$userid'";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($result);
	$new_point = $row["point"] + $point_up;
	
	$sql = "update members set point=$new_point where id='$userid'";
	mysqli_query($con, $sql);

	mysqli_close($con);                // DB 연결 끊기

	//$con = mysqli_connect("localhost", "user1", "12345", "sample");

	//$sql = "update qnaboard set root_num=(select max(num) from qnaboard where id='$userid') where num=(select max(num) from qnaboard where id='$userid')"
	// $sql = "update qnaboard set root_num=(select max(num) from qnaboard where id='$userid') where num=(select max(num) from qnaboard where id='$userid')"
	// mysqli_query($con, $sql);  // $sql 에 저장된 명령 실행

	// mysqli_close($con);                // DB 연결 끊기

	echo "
	   <script>
	    location.href = 'qna_board_list.php';
	   </script>
	";
?>

  
