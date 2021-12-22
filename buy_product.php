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
                alert('물품 구입은 로그인 후 이용해 주세요!');
                history.go(-1)
                </script>
    ");
            exit;
}

    $num = $_GET["num"];
    $page = $_GET["page"];

          
    $con = mysqli_connect("localhost", "user1", "12345", "sample");
    $sql = "update dealboard set status='sold', buyerid='$userid' ";
    $sql .= " where num=$num";
    mysqli_query($con, $sql);

    mysqli_close($con);     

    echo "
	      <script>
	          location.href = 'deal_board_list.php?page=$page';
	      </script>
	  ";
?>

   
