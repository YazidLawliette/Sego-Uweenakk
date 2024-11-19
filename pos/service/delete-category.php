<?php 

require_once __DIR__ . '../../DB/Conection.php';
require_once __DIR__ . '../../Model/Category.php';

$id = $_GET['id'];
if(!isset($id)) {
    header("Location: ../views/index-category.php");
    exit;
}

$categories = new Category();
$categories->delete($id);   
header("Location: ../views/index-category.php");