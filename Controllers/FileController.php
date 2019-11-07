<?php

class FileController
{
    private $tableService = NULL;

    public function __construct() {
        $this->tableService = new TableService();
    }

    public function redirect($location) {
        //header('Location: '.$location);
    }

    public function handleRequest($table = 'table', $rows = 25) {
        $pg = isset($_GET['pg']) ? $_GET['pg'] : NULL;
        try {
            if ( !$pg || $pg == 'new' ) {
                $this->newLoad();
            } elseif ( $pg == 'list') {
                $this->showTable($table, $rows);
            }
            else {
                $this->showError("Page not found", "Page for operation ".$pg." was not found!");
            }
        } catch ( Exception $e ) {
            $this->showError("Application error", $e->getMessage());
        }
    }

    /**
     * @param $paginate - Rows  per Page
     * @param $table - Table name:string
     */
    public function showTable($table, $paginate) {
        $orderby = isset($_GET['orderby']) ? $_GET['orderby'] : "title";
        if (isset($_GET["page"])) {
            $page  = $_GET["page"];
        }
        else{
            $page=1;
        };
        $start_from = ($page-1) * $paginate;
        $rows = $this->tableService->getAllItems($table, $orderby, $paginate, $start_from);
        $total = $this->tableService->paginator($table, $paginate);
        include "View/list.php";
    }

    public function newLoad() {
        if ( isset($_POST['form-submitted']) ) {
            $file       = isset($_POST['file']) ?   $_POST['file']  : NULL;
            $file = 'assets/'.$file;
            $fileObj = $this->getFileData($file);
            try {
                $this->tableService->insertFileData($fileObj,'pl2');
                $this->redirect('index.php');
                return;
            } catch (Exception $exception) { echo 'Error: '. $exception->getMessage(); }
        }
        include 'View/task-form.php';
    }

    private function getFileData($inputFileName) {

		try {
		    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
		    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
		    $objPHPExcel = $objReader->load($inputFileName);

		} catch(Exception $e) {
		    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
		}
        return $objPHPExcel;
    }


    public function showError($title, $message) {
        echo ("$title : $message");
    }

    function render($template, $vars = [])
    {
        extract($vars);
        include "View/$template.php";
    }

}