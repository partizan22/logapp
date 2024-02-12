<?php

namespace BTF\DB;

class MySQLiProvider extends Provider {

    public function escapeValue($value)
    {
        return "'" . mysqli_real_escape_string($this->connection, $value) . "'";
    }
    
    public function escapeField($name, $dbname)
    {
        return  (
                $dbname ? "`" . mysqli_real_escape_string($this->connection, $dbname) . "`." : ''
        ) . "`" . mysqli_real_escape_string($this->connection, $name) . "`";
    }
    
    public static function connect($host, $username, $password, $port=null)
    {
        $connection = mysqli_connect($host, $username, $password, $port);
        mysqli_set_charset($connection, 'utf8');
        return new MySQLiProvider($connection);
    }
    
    public function use_db($dbname)
    {
        return mysqli_select_db($this->connection, $dbname);
    }
    
    protected function _query($sql)
    {
        $res = mysqli_query($this->connection, $sql);
        if (is_object($res))
        {
            $result = [];
            while ($row = mysqli_fetch_assoc($res))
            {
                $result[] = $row;
            }
            
            return $result;
        }
        else
        {
            return $res;
        }
    }
    
    public function inserted_id()
    {
        return mysqli_insert_id($this->connection);
    }
}