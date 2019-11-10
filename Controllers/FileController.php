<?php

class FileController
{
    private $tableService = NULL;

    public function __construct() {
        $this->tableService = new TableService();
    }

    public function redirect($location) {
        header('Location: '.$location);
    }

    public function handleRequest($table = 'pl2', $paginate = 25) {
        $pg = isset($_GET['pg']) ? $_GET['pg'] : NULL;
        try {
            if ( !$pg || $pg == 'new' ) {
                $this->newLoad();
            } elseif ( $pg == 'list') {
                $this->showTable($table, $rows);
            } elseif ( $pg == 'filter') {
                $this->showSelectedRows();
            } elseif ( $pg == 'getrows'){
                $this->getAjaxRows();
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
        $orderby = isset($_GET['orderby']) ? $_GET['orderby'] : "id";
        if (isset($_GET["page"])) {
            $page  = $_GET["page"];
        }
        else{
            $page=1;
        };
        $start_from = ($page-1) * $paginate;
        $rows = $this->tableService->getAllItems($table, $orderby, $paginate, $start_from);
        //$total = $this->tableService->paginator($table, $paginate);
        $opt = array_filter(array_column($rows, 'opt'));
        $opt_id = array_keys($opt, min($opt))[0];
        $opt_min = min($opt);
        $opt_aver = round(array_sum($opt) / count($opt),2);
        $rozn = array_filter(array_column($rows, 'rozn'));
        $rozn_id = array_keys($rozn, max($rozn))[0];
        $rozn_max = max($rozn);
        $rozn_aver = round(array_sum($rozn) / count($rozn),2);
        $sklad1 = array_filter(array_column($rows, 'sklad1'));
        $sklad1Sum = array_sum($sklad1);
        $sklad2 = array_filter(array_column($rows, 'sklad2'));
        $sklad2Sum = array_sum($sklad2);
        include "View/list.php";
        return ;
    }

    public function showSelectedRows() {
        include "View/filter.php";
    }

    /**
     * @param $table string
     * @param $options array
     */
    public function getAjaxRows() {

        $curMax = filter_input(INPUT_POST, 'curMax', FILTER_VALIDATE_INT);
        $curMin = filter_input(INPUT_POST, 'curMin', FILTER_VALIDATE_INT);
        $curSklad = filter_input(INPUT_POST, 'curSklad', FILTER_VALIDATE_INT);
        //$curSklad = $_POST['curSklad'];
        $curCost = $_POST['curCost']; //rozn=1, opt=2
        //$curCost = 1;
        $curZnak = $_POST['curZnak'];// > =3, < =4

        $rows = $this->tableService->selectRows('pl2', $curMin, $curMax, $curCost, $curZnak, $curSklad);
        echo ('Всего найдено '.count($rows).' позиций.');

        $html = "<table class='table-inbox' border='1' cellpadding='8' cellspacing='0'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>наименование</th>
                    <th>Стоимость, руб</th>
                    <th>Стоимость опт, in</th>
                    <th>Остаток на складе 1, шт</th>
                    <th>Остаток на складе 2, шт</th>
                    <th>Страна производитель </th>
                </tr>
            </thead>
            <tbody>";

        if ($rows) {
            foreach ($rows as $task) {

                $html .= "<tr class='some-div'><td>" . $task['id'] .
                    "</td><td>" . $task['title'] . "</td><td>" . $task['rozn'] . "</td><td>" . $task['opt'] .
                    "</td><td>" . $task['sklad1'] . "</td><td>" . $task['sklad2'] . "</td><td>" . $task['country'] . "</td></tr>";
            }
            $html .= "</tbody></table>";
        } else {
            $html .= "</tbody></table><P>Не найдено ...</P>";
        }

        echo $html;
    }

    public function newLoad() {
        if ( isset($_POST['form-submitted']) ) {
            $file       = isset($_POST['file']) ?   $_POST['file']  : NULL;
            $file = 'assets/'.$file;
            $fileObj = $this->getFileData($file);
            try {
                $this->tableService->insertFileData($fileObj,'pl2');
                $this->redirect('index.php?pg=list');
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