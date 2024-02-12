<?php

class _Model extends BTF\Model\DBTableModel
{
    public static function provider() {
        return AppGlobal::db();
    }
    
}