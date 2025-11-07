<?php
require 'functions.php';

if (isset($_POST['id'])) {
  $id = $_POST['id'];
  mysqli_query($conn, "UPDATE ulasan SET status='read' WHERE id=$id");
}

header("Location: dashboardadmin.php");
exit;
