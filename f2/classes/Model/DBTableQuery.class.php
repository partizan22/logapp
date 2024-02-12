<?php

namespace BTF\Model;

use BTF\DB\SQL\_SQLQuery;

class DBTableQuery extends _SQLQuery {
    
	protected $model_class;
	
	function __construct($model) {
		parent::__construct();
		$this->model_class = $model;
		$this->fields();
	}
	/**
     * @return DBTableQuery
     */
//    protected static function _create($model)
//    {
//        $c = get_called_class();
//        $m = new $c();
//		$m->model_class = $model;
//        return $m;
//    }
	
    /**
     * @return DBTableModel[]
     */
    public function select()
    {
		$c = $this->model_class;
		return $c::select($this);
    }
    
    /**
     * @return DBTableModel
     */
    public function single()
    {
		$c = $this->model_class;
		return $c::select_single($this);
    }
	
	/**
     * @return DBTableModel
     */
    public function by_id($id)
    {
		$this->where(['id' => $id]);
		$c = $this->model_class;
		return $c::select_single($this);
    }
	
	/**
     * @return DBTableQuery
     */
	public function join_type($type, $table, $on=false, $as=false)
	{
		if (call_user_func([$this->model_class, '_add_join_to_q'], $type, $table, $on, $this))
		{
			return $this;
		}
		
		return parent::join_type($type, $table, $on, $as);
	}
	
	/**
     * @return DBTableQuery
     */
	public function _q_join_type($type, $table, $on=false, $as=false)
	{		
		return parent::join_type($type, $table, $on, $as);
	}
	
	/**
     * @return DBTableQuery
     */
	public function join($table, $on=false, $as=false)
	{
		return $this->join_type('inner', $table, $on, $as);
	}
	
	/**
     * @return DBTableQuery
     */
	public function left_join($table, $on=false, $as=false)
	{
		return $this->join_type('left', $table, $on, $as);
	}
    
}