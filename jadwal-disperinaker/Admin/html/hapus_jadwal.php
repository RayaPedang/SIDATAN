<?php 
session_start();
include_once '../../db.php';
if(!isset($_SESSION['login'])){
  header("Location: ../../login.php");
} else if ($_SESSION['role'] != 'Admin'){
  header("location: ../../dashboard.php");
}
$id = $_GET['id'];
$query = "DELETE FROM Jadwal_Kegiatan WHERE id = '$id'";
$data = mysqli_query($conn, $query);
if($data){
    header("Location: index.php?hapus=0");
}else{
    header("Location: index.php?hapus=1");
}

?>