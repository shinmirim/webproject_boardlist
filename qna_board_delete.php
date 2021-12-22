<?php

    $num   = $_GET["num"];
    $page   = $_GET["page"];

    $con = mysqli_connect("localhost", "user1", "12345", "sample");
    $sql = "select * from qnaboard where num = $num";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);

    $copied_name = $row["file_copied"];
    $step = $row["step"];

	if ($copied_name)
	{
		$file_path = "./data/".$copied_name;
		unlink($file_path);
    }

    if($step == 1){
      $sql = "delete from qnaboard where num = $num";
    }
    else{
      $sql = "delete from qnaboard where root_num = $num";
    }

    
    mysqli_query($con, $sql);
    mysqli_close($con);

    echo "
	     <script>
	         location.href = 'qna_board_list.php?page=$page';
	     </script>
	   ";
?>

