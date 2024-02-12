<?php

namespace BTF\Model;

class Base {
    
    protected $__data = [];
        
    public function __get($name)
    {
		$m = "_get_$name";
		if (method_exists(get_called_class(), $m))
		{
			return call_user_func([$this, $m]);
		}
		
        if (isset($this->__data[$name]))
        {
            return $this->__data[$name];
        }
		
        return FALSE;
    }

    public function __set($name, $value)
    {
        $this->__data[$name] = $value;
    }
    
    protected function __set_data($data)
    {
        $this->__data = $data;
    }
        
}