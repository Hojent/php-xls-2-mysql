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
    function tableNoExists(PDO $pdo, $table) {
            $result = $pdo->query("SELECT 1 FROM $table LIMIT 1");

            if($result) {
                return false;
            }
            else {
                return true;
            }
    }

    /**
     * @param $table
     */
    public function createTable($table)
    {
        try {
            $pdo = DataBase::connect();
              $sql = $pdo->prepare("CREATE TABLE IF NOT EXISTS $table (
                        id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
                        title text ,
                        rozn decimal(12,2) DEFAULT 0.00,
                        opt decimal(12,2) DEFAULT 0.00,
                        sklad1 int,
                        sklad2 int,
                        country text,
                        prim text) ");
              $sql->execute();
            DataBase::disconnect();
        } catch (PDOException  $e ){
            echo "Error: ".$e;
        }
        return ;
    }

    public function getAllItems1($table, $order = 'id')
    {
        try {
            $pdo = DataBase::connect();
            $sth = $pdo->prepare("SELECT * FROM $table ORDER BY $order ");
            $sth->execute();
            $result = $sth->fetchAll();
            DataBase::disconnect();
        } catch (PDOException  $e ){
            echo "Error: ".$e;
        }
        return $result;
    }
    public function getAllItems($table, $order = 'id', $paginate, $start_from)
    {
        try {
            $pdo = DataBase::connect();
            $sth = $pdo->prepare("SELECT * FROM $table ORDER BY $order ");
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

     /**
     * @param $table string
     * @param $options array
     */
    public function selectRows ($table = 'pl2', $curMin, $curMax, $curCost, $curZnak, $curSklad)
    {
    	 try{
            $pdo = DataBase::connect();
            if ($curCost == 2) {
            	$cost = 'opt';
            } else {
            	$cost = 'rozn';
            }
            $query = "SELECT * FROM $table WHERE ($cost BETWEEN $curMin AND $curMax) ";
	        if ($curZnak == 3) {
	        	$znak = '>';
	        } elseif ($curZnak == 4) {
	        	$znak = '<';
	        }
            $query .= " AND (sklad1 $znak $curSklad OR sklad2 $znak $curSklad) ORDER BY id";
            $sth = $pdo->prepare($query);
            $sth->execute();
            $result = $sth->fetchAll();
            DataBase::disconnect();
        }catch(PDOException  $e ){
            echo "Error: ".$e;
        }
        return ($result);
    }

    public function insertFileData($fileObj,$table) {
        $this->createTable($table);
        $sheet = $fileObj->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        //$sheetData = $fileObj->getActiveSheet()->toArray(null,true,true,true);
        $sheetData = $sheet->rangeToArray(
            'A2:' . $highestColumn . $highestRow,
            NULL,FALSE,FALSE
        );
        try {
            $pdo = DataBase::connect();
            $str = $pdo->prepare("SET SESSION sql_mode = ''");
            $str->execute();
            //$this->createTable('priselist');
            foreach ($sheetData as $row) {
                $stmt = $pdo->prepare("INSERT INTO $table (title, rozn, opt, sklad1, sklad2,country) VALUES (?,?,?,?,?,?)");
                    $rozn = ($row[1] == 0) ? null : $row[1];
                    $opt = ($row[2] == 0.00) ? null : $row[2];
                    $stmt->execute([$row[0], $rozn, $opt, $row[3],$row[4],$row[5]]);

                    //$stmt->execute([$name,$email,$task,$done]);
                }

            //$this->validateItemParams($name, $email, $task);
            DataBase::disconnect();;
        } catch (Exception $e) {
            DataBase::disconnect();
            throw $e;
        }
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