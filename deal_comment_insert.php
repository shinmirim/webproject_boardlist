<?php
 session_start();
 if (isset($_SESSION["userid"])) $userid = $_SESSION["userid"];
 else $userid = "";
 if (isset($_SESSION["username"])) $username = $_SESSION["username"];
 else $username = "";

 if ( !$userid )
 {
     echo("
                 <script>
                 alert('댓글 작성은 로그인 후 이용해 주세요!');
                 history.go(-1)
                 </script>
     ");
             exit;
 }

    $num = $_POST["num"];
    $page = $_POST["page"];
    $comment = $_POST["comment"];


    $regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장
          
    $con = mysqli_connect("localhost", "user1", "12345", "sample");
    $sql = "insert into dealcomment (boardnum,id,name,content,regist_day) values ('$num','$userid','$username','$comment','$regist_day') ";
    mysqli_query($con, $sql);

    mysqli_close($con);     

    echo "
	      <script>
	          location.href = 'deal_board_view.php?num=$num&page=$page';
	      </script>
	  ";
?>

   
