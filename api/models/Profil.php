<?php
class Profil
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



    function viewProfil($id_profil)
    {
        $query = 'SELECT * FROM users WHERE id_user= :id_profil';
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_profil", $id_profil);
        // execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);


        $this->email = $row['email'];
        $this->firstname = $row['firstname'];
        $this->lastname = $row['lastname'];
    }

    function modifyProfil($id_user)
    {

        // query to update record
        $query = "UPDATE users SET email=:email, password=:password, firstname=:firstname, lastname=:lastname WHERE id_user=:id_user";

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
        $stmt->bindParam(":id_user", $id_user);




        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
