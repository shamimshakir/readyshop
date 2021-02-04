<?php


class User{
    private $servername = "localhost";
    private $username   = "root";
    private $password   = "";
    private $database   = "oopcrud";
    public  $con;

    function __construct()
    {
        $this->con = new mysqli($this->servername, $this->username,$this->password,$this->database);
        if(mysqli_connect_errno()){
            die('connection failed');
        }else{
            return $this->con;
        }
    }
    function fetchAllUser(){
        $sql = "SELECT * FROM tbl_user";
        $result = $this->con->query($sql);
        if($result->num_rows > 0){
            $data = array();
            while ($row = $result->fetch_assoc()){
                $data[] = $row;
            }
            return $data;
        }else{
            echo 'No record found';
        }
    }
    function fetchOneUser($id){
        $sql = "SELECT * FROM tbl_user WHERE id = $id";
        $result = $this->con->query($sql);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            return $row;
        }else{
            echo 'No record found';
        }
    }
    function insertUser($data){
        $name = $this->con->real_escape_string($data['name']);
        $email = $this->con->real_escape_string($data['email']);
        $query="INSERT INTO tbl_user(name,email) VALUES('$name','$email')";
        $sql = $this->con->query($query);
        if ($sql==true) {
            header("Location:index.php?msg1=insert");
        }else{
            echo "Registration failed try again!";
        }
    }
    function updateUser($data){
        $name = $this->con->real_escape_string($data['name']);
        $email = $this->con->real_escape_string($data['email']);
        $id = $this->con->real_escape_string($data['id']);
        echo $query="UPDATE tbl_user SET name = '$name', email = '$email' WHERE id = $id";
        $sql = $this->con->query($query);
        if ($sql==true) {
            header("Location:index.php?msg2=update");
        }else{
            echo "Registration updated failed try again";
        }
    }
    function deleteUser($deleteid){
        $query = "DELETE FROM tbl_user WHERE id = '$deleteid'";
        $sql = $this->con->query($query);
        if ($sql==true) {
            header("Location:index.php?msg3=delete");
        }else{
            echo "Record does not delete try again";
        }
    }
}