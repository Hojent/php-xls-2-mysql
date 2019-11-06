<?php
require_once 'DataBase.php';

class TableService {

    /**
     * Check if a table exists in the current database.
     *
     * @param PDO $pdo PDO instance connected to a database.
     * @param string $table Table to search for.
     * @return bool TRUE if table exists, FALSE if no table found.
     */
    function tableExists(PDO $pdo, $table) {

        // Try a select statement against the table
        // Run it in try/catch in case PDO is in ERRMODE_EXCEPTION.
        try {
            $result = $pdo->query("SELECT 1 FROM $table LIMIT 1");
        } catch (Exception $e) {
            // We got an exception == table not found
            return FALSE;
        }

        // Result is either boolean FALSE (no table found) or PDOStatement Object (table found)
        return $result !== FALSE;
    }

    /**
     * @param $table
     * @param $options array
     */
    public function createTable($table)
    {
        try {
            $pdo = DataBase::connect();
            if (!$this->tableExists($pdo,$table)){
              $sql = $pdo->prepare("CREATE TABLE '$table' 
                        'id' int PRIMARY KEY NOT NULL AUTO_INCREMENT,
                        'title' varchar,
                        'roznica' decimal DEFAULT 0.00,
                        'opt' decimal DEFAULT 0.00,
                        'sklad1' int,
                        'sklad2' int,
                        'country' varchar int DEFAULT Россия");
              $sql->execute();

            } else {
                echo 'Table is exist.';
            }
            DataBase::disconnect();
        } catch (PDOException  $e ){
            echo "Error: ".$e;
        }
        return ;
    }

    public function getAllItems($table, $order = 'name', $paginate, $start_from)
    {
        try {
            $pdo = DataBase::connect();
            $sth = $pdo->prepare("SELECT * FROM $table ORDER BY $order LIMIT $start_from, $paginate");
            $sth->execute();
            $result = $sth->fetchAll();
            DataBase::disconnect();
        } catch (PDOException  $e ){
            echo "Error: ".$e;
        }
        return $result;
    }

    public function getItem($table, $id) {
        try{
            $pdo = DataBase::connect();
            $sth = $pdo->prepare("SELECT * FROM $table WHERE id = $id");
            $sth->execute();
            $result = $sth->fetch();
            DataBase::disconnect();
        }catch(PDOException  $e ){
            echo "Error: ".$e;
        }
        return ($result);
    }

    private function validateItemParams( $name, $email) {
        $errors = array();
        if ( !isset($name) || empty($name) ) {
            $errors[] = 'Name is required';}
        elseif (!isset($email) || empty($email) ) {
            $errors[] = 'E-mail is required';
            }
        if ( empty($errors) ) {
            return;
        }
            throw new Exception ( $errors [0].' '.$errors[1]);
    }

    public function createNewTask( $name, $email, $task, $done =1 ) {
        try {
            $pdo = DataBase::connect();
            $this->validateItemParams($name, $email, $task);
            $stmt = $pdo->prepare("INSERT INTO tasks (name, email, task, done) VALUES (?,?,?,?)");
			$stmt->execute([$name,$email,$task,$done]);
            DataBase::disconnect();;
            } catch (Exception $e) {
            DataBase::disconnect();
            throw $e;
        }
    }

     public function updateTask( $name, $email, $task, $id, $done ) {
         try {
             $pdo = DataBase::connect();
             $this->validateTaskParams($name, $email);

             $stmt = $pdo->prepare(
                 "UPDATE tasks SET name = ?, email = ?, task = ? , done = ?, edit = true
                           WHERE id = $id");
             $stmt->execute([$name, $email, $task, $done]);
             DataBase::disconnect();;
         } catch (Exception $e) {
             DataBase::disconnect();
             throw $e;
         }
    }

    public function getUser($login, $password) {
        try{
            $pdo = DataBase::connect();
            $sth = $pdo->prepare("SELECT * FROM users WHERE login = '".$login."' AND password = '".$password."' ");
            $sth->execute();
            $result = $sth->fetch();
            DataBase::disconnect();
        }catch(PDOException  $e ){
            echo "Error: ".$e;
        }
        return $result;
    }

    public function paginator ($table, $limit)
    {
        try {
            $pdo = DataBase::connect();
            $sth = $pdo->prepare("SELECT COUNT(id) FROM $table");
            $sth->execute();
            $result = $sth->fetchColumn();

            DataBase::disconnect();
            $total_pages = ceil($result / $limit);
            return $total_pages;
        } catch (PDOException  $e ){
            echo "Error: ".$e;
        }
    }

}
