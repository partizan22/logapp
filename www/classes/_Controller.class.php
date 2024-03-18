<?php

    class _Controller {
        
		public $account_id;
		
		public $_include_js = [];
		public $_view_name = false;
		public $_view_data = [];
		public $_js_data = [];

		public function __construct()
		{
			$this->account_id = AppGlobal::$account_id;
		}
		
		public function _run()
        {
			if (empty($_REQUEST['a']))
			{
				$e = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
				if (!empty($e[1]))
				{
					$_REQUEST['a'] = $e[1];
				}
			}
			
            $action_name = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'index';
            $action = "action_$action_name";
			
            if (method_exists($this, $action))
            {
				$this->_view_name = $action_name;
                $result = call_user_func([$this, $action], $_REQUEST);
            }
            else
            {
                return false;
            }
            
            return $result;
        }
        
        public function _run_ajax()
        {
            $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'index';
            $action = "action_$action";
			
            if (method_exists($this, $action))
            {
                $result = call_user_func([$this, $action], $_POST);
            }
            else
            {
                $result = FALSE;
            }
            
            if ($result === true)
            {
                $result = ['status' => 'ok'];
            }
            elseif ($result === false) 
            {
                $result = ['status' => 'error'];
            }
            elseif (is_array($result) && isset ($result['status']))
            {
                
            }
            else{
                $result = [
                    'status' => 'ok',
                    'result' => $result,
                ];
            } 
            
            echo json_encode($result);
        }
        
        public function redirect($url)
		{
			header('Location: ' . $url);
			exit();
		}
    }