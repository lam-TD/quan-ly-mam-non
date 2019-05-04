<?php ob_start();?>
<?php include "../../inc/myconnect.php";?>
<?php
session_start();
if(!isset($_SESSION['uid']))
{
	$redirectUrl = substr($_SERVER['REQUEST_URI'],(strrpos($_SERVER['REQUEST_URI'],'/')+1));	
    header('Location: login.php?redirect='.$redirectUrl);
}
?>
<!doctype html>
<html class="no-js h-100" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Trang quản trị - vành khuyên</title>
    <meta name="description" content="A high-quality &amp; free Bootstrap admin dashboard template pack that comes with lots of templates and components.">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="../css/all.css" rel="stylesheet">
    <link href="../css/icon.css" rel="stylesheet">
	<link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" id="main-stylesheet" data-version="1.1.0" href="../styles/shards-dashboards.1.1.0.min.css">
    <link rel="stylesheet" href="../styles/extras.1.1.0.min.css">
	<link rel="stylesheet" href="../css/select2.min.css">
	<script language="JavaScript" type="text/javascript" src="../js/jquery2.min.js"></script>
	<script language="JavaScript" type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
	<script language="JavaScript" type="text/javascript" src="../ckeditor/ckeditor.js"></script>
	<script language="JavaScript" type="text/javascript" src="../ckfinder/ckfinder.js"></script>
	
<!--    <script async defer src="js/buttons.js"></script>-->
    <link rel="stylesheet" href="../../css/mystyle.css">    
    <link rel="stylesheet" type="text/css" href="../styles/admin/style.css">
</head>
<body class="h-100">

<div class="container-fluid">
    <div class="row">

        <!-- Main Sidebar -->
        <?php include "admin-left-menu.php"; ?>
        <!-- End Main Sidebar -->

        <main class="main-content col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3">

            <!-- Main Navbar -->
            <?php include "admin-navbar.php";?>
            <!-- / .main-navbar -->