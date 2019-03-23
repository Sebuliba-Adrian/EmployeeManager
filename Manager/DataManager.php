<?php
require_once("Manager.php");

class DataManager extends Manager
{
    /**
     * @var Manager
     */
    private $_db;

    public function __construct() {

        require_once dirname(__FILE__) . '/../Data/Data.php';

        try{
            $this->_db = parent::__construct();
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }



    public function GetAllEmployees() {
        $result =  Array();

        $sql = "SELECT * FROM employees";
        $request= $this->_db->prepare($sql);

            $request->execute();
            $request->setFetchMode(PDO::FETCH_ASSOC);

            while($single = $request->fetch(PDO::FETCH_ASSOC)) 
            {
                $result[]=array_map("utf8_encode", $single);
            }

            if(count($result)>0) 
            {
                return $result;

            }else{
                return null;
            }

    }

    public function GetEmployee($id) {
        $result =  Array();

        $sql = "SELECT * FROM employees WHERE `id`=:id";
        $request= $this->_db->prepare($sql);
        $request->bindValue(":id", $id);


            $request->execute();
            $request->setFetchMode(PDO::FETCH_ASSOC);

            while($single = $request->fetch(PDO::FETCH_ASSOC)) 
            {
                $result[]=array_map("utf8_encode", $single);
            }

            if(count($result)>0) 
            {
                return $result;

            }else{
                return null;
            }

    }


    public function insertEmployee(Data $employee) {

        $sql = "INSERT INTO `employees`(`title`,`emp_name`, `salary`) VALUES (:title,:emp_name,:salary)";

        $request= $this->_db->prepare($sql);
        $request->bindValue(":title", $employee->getTitle());
        $request->bindValue(":emp_name",  $employee->getName());
        $request->bindValue(":salary",  $employee->getSalary());

            if($request->execute()){
                return $this->_db->lastInsertId();
            }else{ return   null;}
    }

    public function updateEmployee(Data $employee) {

        $sql = "UPDATE `employees` SET `title`=:title,`emp_name`=:emp_name,`salary`=:salary WHERE id=:id";

        $request= $this->_db->prepare($sql);
        $request->bindValue(":id", $employee->getId());
        $request->bindValue(":title", $employee->getTitle());
        $request->bindValue(":emp_name",  $employee->getName());
        $request->bindValue(":salary",  $employee->getSalaly());

            if($request->execute()){
                return $this->GetEmployee($employee->getId());
            }else{ return null;}
    }

    public function deleteEmployee($id) {

        $sql = "DELETE FROM `employees` WHERE `id`=:id";

        $request= $this->_db->prepare($sql);
        $request->bindValue(":id", $id);

            if($request->execute()){
                return 1;
            }else{ return -1;}
    }




}