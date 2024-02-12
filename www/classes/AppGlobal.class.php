<?php
       
    class AppGlobal
    {
        /**
         * @var \BTF\DB\Provider $_db DB Provider
         */
        protected $_db;
        
        protected static $_instance = false;
        
		public static $account_id = 3;

		public function __construct() {
            
            $this->_db = BTF\DB\MySQLiProvider::connect('localhost', 'root', 'root');
            $this->_db->use_db( strpos($_SERVER['HTTP_HOST'], 'logappdev') !== false ? 'logapp_dev' : 'logapp');
            
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
                        
        
    }
