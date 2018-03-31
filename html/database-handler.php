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
            $data =file("dbFile.txt", true);
            self::$connection =  mysqli_connect(trim($data[0]), trim($data[1]), trim($data[2]), trim($data[3]));
        }
        return self::$connection;

    }

    public function getUserCount()
    {
        $query = mysqli_prepare(self::getConnection(), "
        SELECT COUNT(*) FROM  headread.kasutaja");
        mysqli_stmt_execute($query);
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
        mysqli_stmt_bind_param($query, 's', $uid);
        mysqli_stmt_execute($query);
        $result =  mysqli_stmt_get_result($query);
        $row = mysqli_fetch_array($result, MYSQLI_NUM);

        mysqli_stmt_free_result($query); // vabastame päringu vastuse
        mysqli_stmt_close($query); // sulgeme lause
        mysqli_free_result($result);
        return $row;
    }

    public function isUser($uid, $ipaddr)
    {
        $query = mysqli_prepare(self::getConnection(), "SELECT * FROM  headread.kasutaja WHERE headread.kasutaja.fb_id = ? ;");
        mysqli_stmt_bind_param($query, 's', $uid);
        mysqli_stmt_execute($query);
        $result = mysqli_stmt_get_result($query);
        $num_rows = mysqli_num_rows($result);
        if ($num_rows>0) {
            mysqli_stmt_free_result($query); // vabastame päringu vastuse
            mysqli_stmt_close($query); // sulgeme lause
            mysqli_free_result($result);
            $query2 = mysqli_prepare($this->getConnection(), "
            UPDATE headread.kasutaja_andmed AS B
            INNER JOIN headread.kasutaja AS A ON A.k_id = B.k_id
            SET B.ip_addr = ?, B.lastLogin = CURRENT_TIMESTAMP 
            
            WHERE A.fb_id = ?;");
            mysqli_stmt_bind_param($query2, 'ss', $ipaddr, $uid);
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

        $query = mysqli_prepare(self::getConnection(), "INSERT INTO  headread.kasutaja VALUES (NULL , ?, ? ,? ) ");
        mysqli_stmt_bind_param($query, 'sss', $uid, $username, $email);
        mysqli_stmt_execute($query); // saadame päringu AB-le
        mysqli_stmt_free_result($query); // vabastame päringu vastuse
        mysqli_stmt_close($query); // sulgeme lause
        $query2 = mysqli_prepare(self::getConnection(), "INSERT INTO  headread.kasutaja_andmed VALUES (? , CURRENT_TIMESTAMP , ?) ");
        mysqli_stmt_bind_param($query2, 'is', mysqli_insert_id(self::getConnection()), $ipaddr);
        mysqli_stmt_execute($query2); // saadame päringu AB-le
        mysqli_stmt_free_result($query2); // vabastame päringu vastuse
        mysqli_stmt_close($query2); // sulgeme lause
        mkdir("uploads/" . $uid, 0777, true);

    }

    public function insertImage($uid, $path)
    {
        $query = mysqli_prepare(self::getConnection(), "INSERT INTO  headread.laadimised VALUES (NULL , ?, ?) ");
        mysqli_stmt_bind_param($query, 'ss', $uid, $path);
        mysqli_stmt_execute($query); // saadame päringu AB-le
        mysqli_stmt_free_result($query); // vabastame päringu vastuse
        mysqli_stmt_close($query); // sulgeme lause
    }

    public function getImages($uid)
    {
        $query1 = mysqli_prepare(self::getConnection(), "SELECT headread.laadimised.path FROM headread.laadimised WHERE (headread.laadimised.k_id = ?) ");
        mysqli_stmt_bind_param($query1, 's', $uid);
        mysqli_stmt_execute($query1); // saadame päringu AB-le
        $rows = [];
        $result = mysqli_stmt_get_result($query1);
        if ($result) {
            while ($row = mysqli_fetch_row($result)) {
                $rows[]=$row;
            }
        }


        //mysqli_stmt_free_result($query1); // vabastame päringu vastuse
        //mysqli_stmt_close($query1); // sulgeme lause
        return $rows;
    }
    public function removeImage($uid, $path)
    {
        $query1 = mysqli_prepare(self::getConnection(), "DELETE FROM headread.laadimised WHERE (headread.laadimised.k_id = ? AND headread.laadimised.path = ?) ");
        mysqli_stmt_bind_param($query1, 'ss', $uid, $path);
        mysqli_stmt_execute($query1); // saadame päringu AB-le
        unlink($path);

    }
    /**
    function __destruct()
    {
        mysqli_close(self::getConnection());
    }
     */
}
?>