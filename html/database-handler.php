<?php

class Dtb
{
    public $server = 'localhost';
    public $user = 'vrl2018';
    public $pass = 'vrl2018';
    public $db_name = 'headread';
    private $connection;

    /**
     * @return mysqli
     */
    public function getConnection()
    {
        return $this->connection;
    }

    public function isUser($uid)
    {
        $query = mysqli_prepare($this->getConnection(), "SELECT * FROM  headread.kasutaja WHERE headread.kasutaja.fb_id = ? ;");
        $query->bind_param('s', $uid);
        $query -> execute();
        $query-> bind_result($result);
        if($query->fetch()){
            mysqli_stmt_free_result($query); // vabastame päringu vastuse
            mysqli_stmt_close($query); // sulgeme lause
            mysqli_free_result($result);
            return true;
        }
        else{
            mysqli_stmt_free_result($query); // vabastame päringu vastuse
            mysqli_stmt_close($query); // sulgeme lause
            mysqli_free_result($result);
            return false;
        }
    }

    public function insertUser($uid, $username, $email)
    {

        $query = mysqli_prepare($this->getConnection(), "INSERT INTO  headread.kasutaja VALUES (NULL , ?, ? ,? ) ");
        $query->bind_param('sss', $uid, $username, $email);


        mysqli_stmt_execute($query); // saadame päringu AB-le
        mysqli_stmt_free_result($query); // vabastame päringu vastuse
        mysqli_stmt_close($query); // sulgeme lause
    }

    function __construct()
    {
        $this->connection = mysqli_connect($this->server, $this->user, $this->pass, $this->db_name);
    }

    function __destruct()
    {
        mysqli_close($this->getConnection());
    }
}

?>