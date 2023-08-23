<?php
class SignUp
{

    // database connection and table name
    private $conn;


    // object properties
    public $id;
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
        $query = "SELECT id_user, email FROM users WHERE email=:email";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        $email = $this->email;

        // bind given email value
        $stmt->bindParam(":email", $email);

        // execute the query
        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();

        // if email exists, return false
        if ($num > 0) {
            return false;
        } else {
            return true;
        }
        // return true if email does not exist in the database

    }

    function create_user()
    {

        // query to insert record
        $query = "INSERT INTO users SET email=:email, password=:password, firstname=:firstname, lastname=:lastname, role=:role";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize

        $this->email = htmlspecialchars($this->email);
        $this->password = htmlspecialchars($this->password);
        $this->firstname = htmlspecialchars(strip_tags($this->firstname));
        $this->lastname = htmlspecialchars(strip_tags($this->lastname));

        // bind values

        $stmt->bindParam(":email", $this->email);

        // hash the password before saving to database
        $options = array("cost" => 4);
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT, $options);
        $stmt->bindParam(":password", $password_hash);

        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);
        $stmt->bindParam(":role", $this->role);




        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
