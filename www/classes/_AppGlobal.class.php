<?php

    class _AppGlobal
    {
        /**
         * @var \BTF\DB\Provider $_db DB Provider
         */
        protected $_db;
        
        protected static $_instance = false;
        
		public static $account_id = 1;
		
		public static $is_admin_mode = false;
		public static $is_dev_mode = false;

		public function __construct() {
			
			if (self::$is_dev_mode)
			{
				define('SQL_SHOW_ERRORS', true);
			}
			
            $this->_db = BTF\DB\MySQLiProvider::connect('localhost', 'root', 'root');
            $this->_db->use_db( strpos($_SERVER['HTTP_HOST'], 'logappdev') !== false ? 'logapp_dev' : 'logapp');
			//$this->_db->use_db(  'logapp2' );
            
        }
        
        /**
         * @return AppGlobal instance
         */
        public static function i()
        {
            if (!self::$_instance)
            {
                $c = get_called_class();
                self::$_instance = new $c();
            }
            
            return self::$_instance;
        }
        
        protected function save()
        {
            
        }
        
        /**
         * @return \BTF\DB\Provider DB Provider
         */
        public static function db()
        {
            return self::i()->_db;
        }
		
		public static function set_locals()
		{
			
		}
    }
