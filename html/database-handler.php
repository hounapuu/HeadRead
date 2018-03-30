<?php

Class Dtb
{
    private static $connection;

    /**
     * Dtb constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public static function getConnection()
    {
        if (self::$connection===null){
            self::$connection =  mysqli_connect("localhost", "vrl2018", 'vrl2018', 'headread');
        }
        return self::$connection;

    }

    public function getUserCount()
    {
        $query = mysqli_prepare(self::getConnection(), "
        SELECT COUNT(*) FROM  headread.kasutaja");
        $query->execute();
        $result =  mysqli_stmt_get_result($query);
        $rows = mysqli_fetch_row($result);

        mysqli_stmt_free_result($query); // vabastame päringu vastuse
        mysqli_stmt_close($query); // sulgeme lause
        mysqli_free_result($result);
        return $rows[0];
    }

    public function getUserData($uid)
    {
        $query = mysqli_prepare(self::getConnection(), "
        SELECT B.lastLogin, B.ip_addr FROM  headread.kasutaja_andmed AS B
            INNER JOIN headread.kasutaja AS A ON A.k_id = B.k_id
                        WHERE A.fb_id = ?;");
        $query->bind_param('s', $uid);
        $query->execute();
        $result =  mysqli_stmt_get_result($query);
        $row = $result->fetch_array(MYSQLI_NUM);

        mysqli_stmt_free_result($query); // vabastame päringu vastuse
        mysqli_stmt_close($query); // sulgeme lause
        mysqli_free_result($result);
        return $row;
    }

    public function isUser($uid, $ipaddr)
    {
        $query = mysqli_prepare($this->getConnection(), "SELECT * FROM  headread.kasutaja WHERE headread.kasutaja.fb_id = ? ;");
        $query->bind_param('s', $uid);
        $query->execute();
        $query->bind_result($result);
        if ($query->fetch()) {
            mysqli_stmt_free_result($query); // vabastame päringu vastuse
            mysqli_stmt_close($query); // sulgeme lause
            mysqli_free_result($result);
            $query2 = mysqli_prepare($this->getConnection(), "
            UPDATE headread.kasutaja_andmed AS B
            INNER JOIN headread.kasutaja AS A ON A.k_id = B.k_id
            SET B.ip_addr = ?, B.lastLogin = CURRENT_TIMESTAMP 
            
            WHERE A.fb_id = ?;");
            $query2->bind_param('ss', $ipaddr, $uid);
            mysqli_stmt_execute($query2); // saadame päringu AB-le
            mysqli_stmt_free_result($query2); // vabastame päringu vastuse
            mysqli_stmt_close($query2); // sulgeme lause
            return true;
        } else {
            mysqli_stmt_free_result($query); // vabastame päringu vastuse
            mysqli_stmt_close($query); // sulgeme lause
            mysqli_free_result($result);
            return false;
        }
    }

    public function insertUser($uid, $username, $email, $ipaddr)
    {

        $query = mysqli_prepare($this->getConnection(), "INSERT INTO  headread.kasutaja VALUES (NULL , ?, ? ,? ) ");
        $query->bind_param('sss', $uid, $username, $email);
        mysqli_stmt_execute($query); // saadame päringu AB-le
        mysqli_stmt_free_result($query); // vabastame päringu vastuse
        mysqli_stmt_close($query); // sulgeme lause
        $query2 = mysqli_prepare($this->getConnection(), "INSERT INTO  headread.kasutaja_andmed VALUES (? , CURRENT_TIMESTAMP , ?) ");
        $query2->bind_param('is', mysqli_insert_id($this->getConnection()), $ipaddr);
        mysqli_stmt_execute($query2); // saadame päringu AB-le
        mysqli_stmt_free_result($query2); // vabastame päringu vastuse
        mysqli_stmt_close($query2); // sulgeme lause
    }


    function __destruct()
    {
        mysqli_close($this->getConnection());
    }
}
?>