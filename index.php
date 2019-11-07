<?php

require_once 'Controllers/FileController.php';
require_once 'Classes/PHPExcel/IOFactory.php';
require_once 'Entity/TableService.php';

$controller = new FileController();

$controller->handleRequest();

