<?php
class Login
{

    // database connection and table name
    private $conn;


    // object properties
    public $id_user;
    public $email;
    public $password;
    public $firstname;
    public $lastname;
    public $role;


    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function emailExists()
    {

        // query to check if email exists
        $query = "SELECT *
                FROM users
                WHERE email = ?
                LIMIT 0,1";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->email = htmlspecialchars(strip_tags($this->email));

        // bind given email value
        $stmt->bindParam(1, $this->email);

        // execute the query
        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();

        // if email exists, assign values to object properties for easy access and use for php sessions
        if ($num > 0) {

            // get record details / values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // assign values to object properties


            $this->id_user = $row['id_user'];
            $this->role = $row['role'];
            $this->email = $row['email'];
            $this->password = $row['password'];
            $this->firstname = $row['firstname'];
            $this->lastname = $row['lastname'];


            // return true because email exists in the database
            return true;
        }
        // return false if email does not exist in the database
        return false;
    }

    public function connected($id_user)
    {
        $strt = strtotime("now");
        $query = 'INSERT INTO connected (id_user, str_connect) VALUES( :id_user, :str_connect)';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('id_user', $id_user);
        $stmt->bindParam('str_connect', $strt);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function cleanConnected($strt)
    {
        $query = 'DELETE FROM connected WHERE str_connect < :strt';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('strt', $strt);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function disconnected($id_user)
    {

        $query = 'DELETE FROM connected WHERE id_user = :id_user';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('id_user', $id_user);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
