<?php

namespace BTF\DB;

use BTF\DB\SQL\SQLQuery;

class Provider {
    
    protected $connection;

    public function __construct($connection) 
    {
        $this->connection = $connection;
    }

    public function escapeValue($value)
    {
        
    }
    
    public function escapeField($name, $dbname)
    {
        
    }
    
    public static function connect($host, $username, $password, $port=null)
    {
        
    }
    
    public function use_db($dbname)
    {
        
    }
    
    /**
     * @param SQLQuery $query
     */
    public function query($query)
    {
		if (is_object($query))
		{
			$sql = $query->build($this);
		}
		else
		{
			$sql = $query;
		}
        
		//echo $sql . "\n\n";
        return $this->_query($sql);
    }
    
    protected function _query($sql)
    {
        
    }
    
    public function inserted_id()
    {
        
    }
	
	public function _connection() 
	{
		return $this->connection;
	}
}