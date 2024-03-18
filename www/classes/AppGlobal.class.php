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
           
			$db_host = getenv('DB_HOST');
			$db_name = getenv('DB_NAME');
			$db_user = getenv('DB_USER');
			
			// Read the password file path from an environment variable
			$password_file_path = getenv('PASSWORD_FILE_PATH');

			// Read the password from the file
			$db_pass = trim(file_get_contents($password_file_path));
			
            $this->_db = BTF\DB\MySQLiProvider::connect($db_host, $db_user, $db_pass);
			
            $this->_db->use_db(  $db_name );
            
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
