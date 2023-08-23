<?php
class User
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

    function userById($id_user)
    {
        $select = "SELECT * FROM users WHERE id_user = :id_user";

        // Prepare the query
        $stmt = $this->conn->prepare($select);

        // Bind
        $stmt->bindParam('id_user', $id_user);

        // Execute
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function listUsers()
    {
        $select = "SELECT * FROM users";

        // Prepare the query
        $stmt = $this->conn->prepare($select);

        // Execute
        $stmt->execute();

        return $stmt;
    }
}
