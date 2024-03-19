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
           
			// Read the password from the file
			$db_pass = trim(getenv('DB_PASSWORD'));
			
            $this->_db = BTF\DB\MySQLiProvider::connect('127.0.0.1', 'root', $db_pass);
			
            $this->_db->use_db(  'logapp' );
            
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
