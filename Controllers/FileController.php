<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2019/11/06
 * Time: 14:47
 */
require_once 'Entity/TableService.php';

class FileController
{

    private $tableService = NULL;
    private $file;

    public function __construct() {
        $this->tableService = new TableService();
    }

    public function redirect($location) {
        header('Location: '.$location);
    }

    public function handleRequest() {
        $op = isset($_GET['op']) ? $_GET['op'] : NULL;
        $id = isset($_GET['id']) ? $_GET['id'] : NULL;
        try {
            if ( !$op || $op == 'list' ) {
                $this->listTask();
            } elseif ( $op == 'new') {
                $this->saveTask();
            } elseif ( $op == 'edit') {
                $this->editTask($id);
            }
            else {
                $this->showError("Page not found", "Page for operation ".$op." was not found!");
            }
        } catch ( Exception $e ) {
// some unknown Exception got through here, use application error page to display it
            $this->showError("Application error", $e->getMessage());
        }
    }

    public function listTask() {
        $paginate = 3;
        $orderby = isset($_GET['orderby']) ? $_GET['orderby'] : "name";
        if (isset($_GET["page"])) {
            $page  = $_GET["page"];
        }
        else{
            $page=1;
        };
        $start_from = ($page-1) * $paginate;
        $tasks = $this->tableService->getAllItems($orderby, $paginate, $start_from);
        $total = $this->tableService->paginator($paginate);
        include "Views/list.php";
    }

    public function saveTask() {

        $title = 'Add new task';
        $form = 'new';
        $name = '';
        $email = '';
        $task = '';


        if ( isset($_POST['form-submitted']) ) {

            $name       = isset($_POST['name']) ?   $_POST['name']  :NULL;
            $email      = isset($_POST['email'])?   $_POST['email'] :NULL;
            $task    = isset($_POST['task'])? $_POST['task']:NULL;
            try {
                $this->taskService->createNewTask($name, $email, $task, $done = 1);
                $this->redirect('index.php');
                return;
            } catch (Exception $exception) { echo 'Error: '. $exception->getMessage(); }
        }
        include 'Views/task-form.php';
    }

    public function editTask($id) {
        $title = 'Edit task';
        $item = $this->taskService->getTask($id);
        $name = $item['name'];
        $email = $item['email'];
        $task = $item['task'];
        $done = $item['done'];

        if ( isset($_POST['form-submitted']) ) {
            $name       = isset($_POST['name']) ?   $_POST['name']  : NULL;
            $email      = isset($_POST['email']) ?   $_POST['email'] : NULL;
            $task    = isset($_POST['task']) ? $_POST['task'] : NULL;
            $done = isset($_POST['done']) ? 0 : 1;
            try {
                $this->taskService->updateTask($name, $email, $task, $id, $done);
                $this->redirect('index.php');
                return;
            } catch (Exception $exception) { echo 'Error: '. $exception->getMessage(); }
        }
        if ( isset($_SESSION['USERNAME']) ) {
            include 'Views/task-form.php';
        } else {header("location: ../Views/login-form.php");}
    }

    public function showError($title, $message) {
        echo ("$title : $message");
    }

    function render($template, $vars = [])
    {
        extract($vars);
        include "Views/$template.php";
    }

}