<?php

namespace BTF\DB\SQL;

class SQLExpression
{
    protected $type;
    protected $args;
    
    function __construct($type, $args) {
        $this->type = $type;
        $this->args = $args;
    }
    
    public function is_null_expression()
    {
        return ($this->type == 'expression') && (count($this->args) == 1) && ($this->args[0] == 'NULL');
    }
	
    /**
     * @return SQLExpression SQLExpression
     */
    public static function F($name, $dbname=false) {
		if (strpos($name, '.') !== false)
		{
			$e = explode('.', $name);
			return self::F($e[1], $e[0]);
		}
        return new SQLExpression('field', ['name' => $name, 'dbname' => $dbname]);
    }
    
    /**
     * @return SQLExpression SQLExpression
     */
    public static function V($value) {
        return new SQLExpression('value', ['value' => $value]);
    }
    
    /**
     * @return SQLExpression SQLExpression
     */
    public static function E($args)
    {
        if (!is_array($args))
        {
            $args = func_get_args();
        }
        return new SQLExpression('expression', $args);
    }
            
    /**
     * @return SQLExpression SQLExpression
     */
    public static function BinOp($op, $arg1, $arg2)
    {
        if (!is_object($arg1))
        {
            $arg1 = SQLExpression::F($arg1);
        }
        
        if (!is_object($arg2))
        {
            $arg2 = SQLExpression::V($arg2);
        }
        
        $e = SQLExpression::E($arg1, $op, $arg2);
        return $e;
    }
    
    /**
     * @return SQLExpression SQLExpression
     */
    public static function Eq($arg1, $arg2)
    {
        return SQLExpression::BinOp('=', $arg1, $arg2);
    }
    
    /**
     * @return SQLExpression SQLExpression
     */
    public static function Lt($arg1, $arg2)
    {
        return SQLExpression::BinOp('<', $arg1, $arg2);
    }
    
    /**
     * @return SQLExpression SQLExpression
     */
    public static function Gt($arg1, $arg2)
    {
        return SQLExpression::BinOp('>', $arg1, $arg2);
    }
    
    /**
     * @return SQLExpression SQLExpression
     */
    public static function Lte($arg1, $arg2)
    {
        return SQLExpression::BinOp('<=', $arg1, $arg2);
    }
    
    /**
     * @return SQLExpression SQLExpression
     */
    public static function Gte($arg1, $arg2)
    {
        return SQLExpression::BinOp('>=', $arg1, $arg2);
    }
    
    /**
     * @return SQLExpression SQLExpression
     */
    public static function Like($arg1, $arg2)
    {
        return SQLExpression::BinOp('LIKE', $arg1, $arg2);
    }
    
    /**
     * @return SQLExpression SQLExpression
     */
    public static function NotEq($arg1, $arg2)
    {
        return SQLExpression::BinOp('!=', $arg1, $arg2);
    }
    
    /**
     * @return SQLExpression SQLExpression
     */
    public static function Bkt($arg)
    {
        return SQLExpression::E('(', $arg, ')');
    }
    
    /**
     * @return SQLExpression SQLExpression
     */
    public static function Distinct($arg)
    {
        return SQLExpression::E('DISTINCT', $arg);
    }
    
    /**
     * @return SQLExpression SQLExpression
     */
    public static function _list($list, $op, $outBkt=false, $inBkt=false)
    {
        $result = [];
        foreach ($list as $item)
        {
            if (count($result)>0)
            {
                $result[] = $op;
            }
            
            $result[] = $inBkt ? SQLExpression::Bkt($item) : $item;
        }
                
        $e = SQLExpression::E($result);
        return  $outBkt ? SQLExpression::Bkt($e) : $e;
    }
    
    /**
     * @return SQLExpression SQLExpression
     */
    public static function _AND($args)
    {
        if (!is_array($args))
        {
            $args = func_get_args();
        }
                
        return SQLExpression::_list($args, 'AND', TRUE, TRUE);
    }
    
    /**
     * @return SQLExpression SQLExpression
     */
    public static function _OR($args)
    {
        if (!is_array($args))
        {
            $args = func_get_args();
        }
                
        return SQLExpression::_list($args, 'OR', TRUE, TRUE);
    }
    
    /**
     * @return SQLExpression SQLExpression
     */
    public static function _NOT($arg)
    {
        return SQLExpression::E('NOT', '(', $arg, ')');
    }
    
    /**
     * @return SQLExpression SQLExpression
     */
    public static function IS_NULL($arg)
    {
        return SQLExpression::E($arg, 'IS NULL');
    }
    
    /**
     * @return SQLExpression SQLExpression
     */
    public static function IS_NOT_NULL($arg)
    {
        return SQLExpression::E($arg, 'IS NOT NULL');
    }
    
     /**
     * @return SQLExpression SQLExpression
     */
    public static function _NULL()
    {
        return SQLExpression::E('NULL');
    }
    
    /**
     * @return SQLExpression SQLExpression
     */
    public static function IN($arg, $list)
    {
        return SQLExpression::E($arg, 'IN', SQLExpression::_list($list, ',', TRUE, FALSE));
    }
    
    /**
     * @return SQLExpression SQLExpression
     */
    public static function FUNC($name, $args)
    {
        if (!is_array($args))
        {
            $args = func_get_args();
            $args = array_slice($args, 1);
        }
        
        return SQLExpression::E($name, SQLExpression::_list($args, ',', TRUE, FALSE) );
    }
    
    /**
     * @return SQLExpression SQLExpression
     */
    public static function _AS($arg, $alias)
    {
        if (!is_object($alias))
        {
            $alias = SQLExpression::F($alias);
        }
        return SQLExpression::E($arg, 'AS', $alias);
    }
    
    /**
     * @param Provider $provider
     * @return String
     */
    public function _toString($provider)
    {
        return call_user_func([$this, "_type_{$this->type}"], $provider);
    }
    
    /**
     * @param Provider $provider
     * @return String
     */
    protected function _type_field($provider)
    {
        return $provider->escapeField($this->args['name'], $this->args['dbname']);
    }
    
    /**
     * @param Provider $provider
     * @return String
     */
    protected function _type_value($provider)
    {
        return $provider->escapeValue($this->args['value']);
    }
    
    /**
     * @param Provider $provider
     * @return String
     */
    protected function _type_expression($provider)
    {
        $result = '';
        foreach ($this->args as $a)
        {
            if (is_object($a))
            {
                if (is_a($a, 'BTF\DB\SQL\SQLQuery') || is_a($a, 'BTF\Model\DBTableQuery'))
                {
                    debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
                }
                
                $v = $a->_toString($provider);
            }
            else
            {
                $v = $a;
            }
            
            $result .= " $v ";
        }
        return $result;
    }
    
}
