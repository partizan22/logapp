<?php

namespace BTF\DB\SQL;

class _SQLQuery
{
    protected $type;
    protected $select;
    protected $flags;
    protected $from;
    protected $joins;
    protected $where;
    protected $group_by;
    protected $having;
    protected $order_by;
    protected $limit;
    protected $offset;
    protected $set;
    protected $table_name;


    /**
    * @var Provider $provider
    */
    protected $provider;
            
    function __construct($type='SELECT') {
        $this->type = $type;
        $this->select = [];
        $this->from = [];
        $this->joins = [];
        $this->where = [];
        $this->group_by = [];
        $this->having = [];
        $this->order_by = [];
        $this->limit = FALSE;
        $this->offset = 0;
        $this->set = [];
        $this->flags = [];        
    }
    
    /**
     * @return SQLQuery
     */
    protected static function __static_construct($type='SELECT')
    {
        $c = get_called_class();
        $m = new $c($type);
        return $m;
    }
    
    /**
     * @return SQLQuery
     */
    public function fields($list = '*', $clear = true)
    {
		if ($clear)
		{
			$this->select = [];
		}
		
        if (!is_array($list))
        {
            $list = [$list];
        }
        
        foreach ($list as $k=>$i)
        {
            if (!is_object($i))
            {
                //$i = ($i == '*') ? SQLExpression::E($i) : SQLExpression::F($i);
                $i = SQLExpression::E($i);
            }
            
            if (is_int($k))
            {
                $this->select[] = $i;
            }
            else
            {
                $this->select[] = SQLExpression::_AS($i, $k);
            }
        }
        
        return $this;
    }
	
	/**
     * @return SQLQuery
     */
    public function group_by($list, $clear = true)
    {
		if ($clear)
		{
			$this->group_by = [];
		}
		
        if (!is_array($list))
        {
            $list = [$list];
        }
        
        foreach ($list as $k=>$i)
        {
            if (!is_object($i))
            {
                $i = SQLExpression::F($i);
            }
            
			$this->group_by[] = $i;            
        }
        
        return $this;
    }
    
    /**
     * @return SQLQuery
     */
    public function from($from)
    {
        if (!is_array($from))
        {
            $from = [$from];
        }
        
        foreach ($from as $k=>$i)
        {
            if (!is_object($i))
            {
                $i = SQLExpression::F($i);
            }
            
            if (is_int($k))
            {
                $this->from[] = $i;
            }
            else
            {
                $this->from[] = SQLExpression::_AS($i, $k);
            }
        }
        
        return $this;
    }
    
    /**
     * @return SQLQuery
     */
    public function join_type($type, $table, $on=false, $as=false)
    {
        if (!is_object($table))
        {
            $table = SQLExpression::F($table);
        }
        
        if ($as)
        {
            $table = SQLExpression::_AS($table, $as);
        }
        
        if (!empty($on) && !is_object($on))
        {
            $on = $this->_mixed_to_where($on);
        }
        
        $this->joins[] = [
            'type' => $type,
            'table' => $table,
            'on' => $on,
        ];
        
        return $this;
    }
	
	/**
     * @return SQLQuery
     */
	public function join($table, $on=false, $as=false)
	{
		return $this->join_type('inner', $table, $on, $as);
	}
	
	/**
     * @return SQLQuery
     */
	public function left_join($table, $on=false, $as=false)
	{
		return $this->join_type('left', $table, $on, $as);
	}
    
    protected function _mixed_to_where($where)
    {
        if (is_object($where))
        {
            return $where;
        }
        
        if (is_array($where))
        {
            $list = [];
            foreach ($where as $k=>$v)
            {
                if (is_int($k))
                {
                    if (is_a($v, 'BTF\DB\SQL\SQLExpression'))
                    {
                        $list[] = $v;
                    }
                    else
                    {
                        $list[] = SQLExpression::E($v);
                    }
                }
                else
                {
                    if (is_a($v, 'BTF\DB\SQL\SQLExpression'))
                    {
                        if ($v->is_null_expression())
                        {
                            $list[] = SQLExpression::IS_NULL(SQLExpression::F($k));
                        }
                        else
                        {
                            $list[] = SQLExpression::Eq(
                                SQLExpression::F($k), $v
                            );
                        }
                    }
                    elseif (is_array($v))
                    {
                        $list[] = SQLExpression::IN(
                            SQLExpression::F($k), array_map(function($x){ return  SQLExpression::V($x); }, $v)
                        );
                    }
                    else
                    {
                        $list[] = SQLExpression::Eq(
                            SQLExpression::F($k), SQLExpression::V($v)
                        );
                    }
                }
            }
			
            return SQLExpression::_AND($list);
        }
        
        return SQLExpression::E($where);
    }
	
    /**
     * @return SQLQuery
     */
    public function where($where)
    {
        if (!empty($where))
        {
            $this->where[] = $this->_mixed_to_where($where);
        }
        
        return $this;
    }
    
    /**
     * @return SQLQuery
     */
    public function order_by($field, $order)
	{
        if (!is_object($field))
        {
            $field = SQLExpression::F($field);
        }
        
        if (is_numeric($order))
        {
            $order = $order > 0 ? 'ASC' : 'DESC';
        }
        
        $this->order_by[] = [$field, $order];
        
        return $this;
    }
    
    /**
     * @return SQLQuery
    */
    public function limit($limit, $offset=0)
    {
       $this->limit = $limit;
       $this->offset = $offset;
       return $this;
    }
    
    /**
     * @return SQLQuery
    */
    public function set($set)
    {
        foreach ($set as $k=>$v)
        {
            if (!is_object($k))
            {
                $k = SQLExpression::F($k);
            }
            
            if (!is_object($v))
            {
                $v = SQLExpression::V($v);
            }
            
            $this->set[]  = [$k,$v];
        }
        
        return $this;
    }
   
   /**
    * @param Provider $provider
    */
   public function build($provider)
   {
       $this->provider = $provider;
       return call_user_func([$this, "_type_" . strtolower($this->type)]);
   }
   
   protected function _type_select()
   {
       $q = "SELECT {$this->_build_flags()} {$this->_build_select_part()}\n"
            . "FROM {$this->_build_from_part()}\n"
            . "{$this->_build_join_part()}\n"
            . "{$this->_build_where_part()}\n"
			. "{$this->_build_groupby_part()}"
            . "{$this->_build_order_part()}\n"
            . "{$this->_build_limit_part()}\n";
        
        return $q;
   }
      
   protected function _build_select_part()
   {
       
       $e = SQLExpression::_list($this->select, ',', false, false );
       return $e->_toString($this->provider);
   }
   
   protected function _build_from_part()
   {
       $e = SQLExpression::_list($this->from, ',', false, false );
       return $e->_toString($this->provider);
   }
   
   protected function _build_groupby_part()
   {
	   if (empty($this->group_by))
	   {
		   return '';
	   }
       $e = SQLExpression::_list($this->group_by, ',', false, false );
       return 'GROUP BY ' . $e->_toString($this->provider) . "\n";
   }
   
   protected function _build_join_part()
   {
       if (!empty($this->joins))
       {
           $str = '';
           foreach ($this->joins as $j)
           {
               $str .= "{$j['type']} JOIN {$j['table']->_toString($this->provider)} ON {$j['on']->_toString($this->provider)}\n";
           }
           return $str;
       }
       return '';
   }   
   
   protected function _build_where_part()
   {
       if (!empty($this->where))
       {
           $e = SQLExpression::_AND($this->where);
           return "WHERE {$e->_toString($this->provider)}";
       }
       
       return '';
   }
   
   protected function _build_order_part()
   {
       if (!empty($this->order_by))
       {
           $list = [];
           foreach ($this->order_by as $o) 
           {
               $list[] = $o[0]->_toString($this->provider) . ' ' . $o[1];
           }
           
           return "ORDER BY " . implode(',', $list);
       }
       
       return '';
   }
   
   protected function _build_limit_part()
   {
       if ($this->limit)
       {
           $limit = "";
           if ($this->offset)
           {
               $limit .= "{$this->offset},";
           }
           
           $limit .= $this->limit;
           
           return "LIMIT $limit";
       }
       
       return '';
   }
   
   protected function _build_set_part()
   {
       $set = [];
       foreach ($this->set as $kv)
       {
           $set[] = SQLExpression::E($kv[0], '=', $kv[1]);
       }
       return SQLExpression::_list($set, ',')->_toString($this->provider);
   }
   
   protected function _build_flags()
   {
        return implode(' ', $this->flags);
   }
   
   protected function _type_insert()
   {
       $type = "INSERT";
       foreach ($this->flags as $i=>$f)
       {
           if (strtolower($f)=='replace')
           {
               unset($this->flags[$i]);
               $type = 'REPLACE';
           }
       }
       
       return "
           $type {$this->_build_flags()} INTO {$this->table_name}       
               SET {$this->_build_set_part()}
       ";
   }
   
   protected function _type_update()
   {
       return "
           UPDATE {$this->table_name}
               SET {$this->_build_set_part()}
           {$this->_build_where_part()}
       ";
   }
   
   protected function _type_delete()
   {
       return "
           DELETE FROM {$this->table_name}
               {$this->_build_where_part()}
       ";
   }
   
    
}
