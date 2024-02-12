<?php

namespace BTF\DB\SQL;

class SQLQuery extends _SQLQuery
{
    /**
     * @return SQLQuery
     */
    public static function SELECT($list = '*')
    {
        $q = self::__static_construct();
        return $q->_select($list);
    }
    
    /**
     * @return SQLQuery
     */
    public static function INSERT($table, $type='ignore')
    {
        $q = self::__static_construct('INSERT');
        $q->table_name = $table;
        $q->flags = [$type];
        return $q;
    }
    
    /**
     * @return SQLQuery
     */
    public static function UPDATE($table)
    {
        $q = self::__static_construct('UPDATE');
        $q->table_name = $table;
        return $q;
    }
    
    /**
     * @return SQLQuery
     */
    public static function DELETE($table)
    {
        $q = self::__static_construct('DELETE');
        $q->table_name = $table;
        return $q;
    }
    
}
