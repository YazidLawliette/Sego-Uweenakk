<?php 

require_once __DIR__ . '../../DB/Conection.php';
require_once __DIR__ . '../../Model/Item.php';

$id = $_GET['id'];
if(!isset($id)) {
    header("Location: ../views/index-menu.php");
    exit;
}

$menu = new Item();
$menu->delete($id);   
header("Location: ../views/index-menu.php");