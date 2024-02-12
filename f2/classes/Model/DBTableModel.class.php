<?php

namespace BTF\Model;

use BTF\DB\Provider;
use BTF\DB\SQL\SQLExpression;
use BTF\DB\SQL\SQLQuery;

class DBTableModel extends Base {
    
    
    protected static $__scheme = [];
    
    /**
     * @return Provider $provider
     */
    protected static function provider(){
        $c = get_called_class();
        return $c::provider();
    }
        
    public function __construct($data=[]) {
        $this->__set_data($data);
    }
    
    // !!!
    public function get_data()
    {
		$data = $this->__data;
		
		$r = new \ReflectionClass(get_called_class());
		foreach ($r->getMethods() as $m)
		{
			if (strpos($m->name, '_get_') === 0)
			{
				$f = substr($m->name, 5);
				$data[$f] = call_user_func([$this, $m->name]);
			}
		}
		
        return $this->__data;
    }
    
    /**
     * @return DBTableModel
     */
    public static function create($data=[])
    {
        return self::__static_construct($data);
    }
    
    /**
     * @return DBTableModel
     */
    protected static function __static_construct($data=[])
    {
        $c = get_called_class();
        $m = new $c($data);
        return $m;
    }
    
    /**
     * @return SQLQuery
     */
    protected static function _build_select_query($where=false)
    {
		$c = get_called_class();
		$q = new DBTableQuery($c);
		$sch = $c::__scheme();
        $q->from($sch['table_name'])->where($where);
		$q->fields(SQLExpression::F('id', $sch['table_name']) , false);
		foreach ($sch['fields'] as $f)
		{
			$q->fields(SQLExpression::F($f, $sch['table_name']) , false);
		}
		return $q;
    }
    
    /**
     * @return DBTableModel[]
     */
    protected static function _select_by_query($q)
    {
        $data = self::provider()->query($q);
        $result = [];
        foreach ($data as $row)
        {
            $result[] = self::__static_construct($row);
        }
        return $result;       
    }
    
    /**
     * @return DBTableModel[]
     */
    protected static function _select_where($where='')
    {
        $c = get_called_class();
        $q = $c::_build_select_query($where);
        return self::_select_by_query($q);
    }
    
    /**
     * @return DBTableModel[]
     */
    public static function select($q=false)
    {
        if (is_a($q, '\BTF\DB\SQL\SQLQuery'))
        {
            $q->from(self::__scheme()['table_name']);
            return self::_select_by_query($q);
        }
		elseif (is_a($q, 'BTF\Model\DBTableQuery'))
		{
			return self::_select_by_query($q);
		}
        else
        {
            return self::_select_where($q);
        }
    }
    
    /**
     * @return DBTableModel
     */
    public static function select_single($q=false)
    {
		$c = get_called_class();
		if (!is_a($q, '\BTF\DB\SQL\SQLQuery') && !is_a($q, 'BTF\Model\DBTableQuery'))
		{
			$q = $c::_build_select_query($q);
		}
		elseif (is_a($q, '\BTF\DB\SQL\SQLQuery'))
		{
			$q->from(self::__scheme()['table_name'])->limit(1);
		}
        
        $r = $c::_select_by_query($q->limit(1));
        return !empty($r) ? $r[0] : false;
    }
    
    /**
     * @return DBTableModel
     */
    public static function select_by_id($id)
    {
        return self::select_single(['id' => $id]);
    }
	
	/**
     * @return DBTableQuery
     */
	public static function query($where='')
	{
		return self::_build_select_query($where);
	}
	
	public function save()
    {
        if (!empty($this->__data['id']))
        {
            $this->_update();
        }
        else
        {
            $this->_insert();
        }
    }
	
    public function _update()
    {
        $q = SQLQuery::UPDATE($this->__scheme()['table_name']);
        foreach (self::__scheme()['fields'] as $f)
        {
            if (is_null($this->__data[$f]))
            {
                $q->set([$f => SQLExpression::_NULL() ]);
            }
            else
            {
                $q->set([$f => $this->__data[$f]]);
            }
        }
        $q->where(['id' => $this->id]);
        
        $this->provider()->query($q);
    }
    
    public function delete()
    {
        $q = SQLQuery::DELETE($this->__scheme()['table_name']);
        $q->where(['id' => $this->id]);
        $this->provider()->query($q);
    }
    
    public function _insert()
    {
        $q = SQLQuery::INSERT($this->__scheme()['table_name']);
        foreach (self::__scheme()['fields'] as $f)
        {
            if (isset($this->__data[$f]))
            {
                $q->set([$f => $this->__data[$f]]);
            }
        }
        
        $this->provider()->query($q);
        
        $this->id = $this->provider()->inserted_id();
    }
    
    protected static function __scheme()
    {
        $c = get_called_class();
        return $c::$__scheme;
    }
    
    public static function insert($data, $type='ignore')
    {
        $q = SQLQuery::INSERT(self::__scheme()['table_name'], $type);
        foreach (self::__scheme()['fields'] as $f)
        {
            if (isset($data[$f]))
            {
                $q->set([$f => $data[$f]]);
            }
        }
        
        self::provider()->query($q);
    }
    
    public static function update($data, $where)
    {
        $q = SQLQuery::UPDATE(self::__scheme()['table_name']);
        foreach (self::__scheme()['fields'] as $f)
        {
            if (isset($data[$f]))
            {
                $q->set([$f => $data[$f]]);
            }
        }
        $q->where($where);
        self::provider()->query($q);
    }

	public static function _add_join_to_q($type, $table, $on=false, $q)
	{
		$scheme = self::__scheme();
		
		if (!isset($scheme['joins'][$table]))
		{
			return false;
		}
		
		if (!empty($on))
        {
			if (!is_object($on))
			{
				$on = $this->_mixed_to_where($on);
			}
			
			if (!empty($scheme['joins'][$table]['on']))
			{
				$on = BTF\DB\SQL\SQLExpression::_AND($on, $scheme['joins'][$table]['on']);
			}
        }
		else
		{
			$on = $scheme['joins'][$table]['on'];
		}
		
		$as = !empty($scheme['joins'][$table]['as']) ? $scheme['joins'][$table]['as'] : $table;
		
		$q->_q_join_type($type, $scheme['joins'][$table]['table'], $on, $as);
		
		return true;
	}
}