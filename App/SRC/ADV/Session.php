<?php

namespace App\SRC\ADV;
use App\SRC\FW\Response;

class Session {

	private $session_name;
	public $result;

	/**
	* Constructor for Delta_Session class
	* @param int $dim dimension of the signal
	*/
	 
	// максимальное врем¤м жизни сессии с продлением
	private $session_life = 86400;
	// private $session_life = 60;
	// минимально врем¤ жизни сессии
	private $session_life_min = 3600;
	// private $session_life_min = 30;
	private $session_domain = SESSION_DOMAIN;
	private $session_path = '/';
	private $session_update_access = true;
	private $params_list = [
		'session_update_access',
		'session_domain'
	];
	
	private function session_begin () {
		ini_set('session.gc_maxlifetime', $this->session_life);
		// echo (json_encode($this->preCookie, JSON_UNESCAPED_UNICODE));
		session_start();
	}	
	
	public function __construct($session_name, $params = array()) {
		foreach ( $params as $key => $value ) {
			if ( in_array($key, $this->params_list) ) {
				$this->$key = $value;
			}
		}
		
		$this->session_name = $session_name;
		define('SESSION_RESET_SALT', 	'd2lk9fo');
		session_name($this->session_name);
		 
		// запретить доступ к сессии через Javascript
		// *ѕ–≈ƒѕќ—Ћ≈ƒЌ»… ѕј–јћ≈“– ѕќћ≈Ќя“№ Ќј TRUE ѕ–» HTTPS
		// *это заставит сессию передаватьс¤ только по SSL,
		if (!defined('COOKIE_HTTPS_SECURE')) {
			define('COOKIE_HTTPS_SECURE', false);
		}
		$xdelta_salt = substr(md5(rand(0,99999) . time()), 0, 8);
		$xdelta_user_agent = $_SERVER['HTTP_USER_AGENT'];
		$xdelta_user_ip = 'localhost';
		
		// сгенерировать новый ключ этому пользователю
		// session_set_cookie_params($this->session_life, $this->session_path, $this->session_domain, COOKIE_HTTPS_SECURE, true);
		session_set_cookie_params($this->session_life, $this->session_path, '', COOKIE_HTTPS_SECURE, true);
	}

	public static function set($key, $value) {
		$_SESSION[$key] = $value;
	}

	public static function get($key) {
		if (isset($_SESSION)) { 
			return isset($_SESSION[$key]) ? $_SESSION[$key] : false;
		} else {
			return false;
		}
	}
	public static function getAll() {
		if (isset($_SESSION)) { 
			return isset($_SESSION) ? $_SESSION : false;
		} else {
			return false;
		}
	}
	
	// ”ничтожить сессию (разлогинить)
	public static function logout($name, $domain) {
		session_destroy();
		setcookie($name, '', 0, '/', $domain);
		unset($_SESSION);
	}

	// —генерировать новый xdelta_i, стартовать сессию
	public function session_init() {
		$xdelta_salt = substr(md5(rand(0,99999) . time()), 0, 8);
		$xdelta_user_agent = $_SERVER['HTTP_USER_AGENT'];
		$xdelta_user_ip = 'localhost';
		
		// сгенерировать новый ключ этому пользователю
		session_id(md5($xdelta_salt.$xdelta_user_agent.$xdelta_user_ip));
		
		$this->session_begin();
		$_SESSION['xdelta_salt'] = $xdelta_salt;
		$_SESSION['xdelta_user_agent'] = $xdelta_user_agent;
		$_SESSION['xdelta_user_ip'] = $xdelta_user_ip;
		$_SESSION['xdelta_session_last_request_time_unix'] = time();
		$_SESSION['isLogged'] = false;
	}

	// ќтправл¤ет пользовател¤ в скрипт который стартует ему новую сессию,
	// без изменени¤ той, на которую он по каким-то причинами подписалс¤
	// —корее всего говорит о том, что сесси¤ была украдена
	private function session_is_not_yours() {
		session_write_close();
		unset($_SESSION);
		$this->session_init();
	}

	private function session_update(){
		if ( $this->session_update_access == true ) {
			$time = time();
			$delta = $time - $_SESSION['xdelta_session_last_request_time_unix'];
			// удал¤ем сессию, если к ней обратитиль после минимального срока жизни
			if ( $delta > $this->session_life_min ) {
				$this->session_is_not_yours();
				Response::jsonError('Ошибка авторизации', ['error_code' => '4020', 'error_text' => 'Сессия устарела']);
			// обновл¤ем сессию, если врем¤ жизни сессии остаЄтс¤ меньше или равной половине еЄ жизни
			} elseif ( $delta > $this->session_life_min / 2 ) {
				$_SESSION['xdelta_session_last_request_time_unix'] = $time;
			}
		}
	}
	
	// —есси¤ в выделенной Cookie, 
	// - прив¤зываетс¤ к IP, 
	// - прив¤зываетс¤ к браузеру, 
	// - закрыт доступ из JavaScript, 
	// - передаетс¤ только по SSL
	public function session_start_secure() {
		// ≈сли пришла кука сессии, стартуем ее и провер¤ем данные
		if (isset($_COOKIE[$this->session_name])) {  
			$this->session_begin();

			if (  (!isset($_SESSION['xdelta_salt'])) || (!isset($_SESSION['xdelta_user_agent'])) || (!isset($_SESSION['xdelta_user_ip']))) {
				$this->session_is_not_yours();
				Response::jsonError('Ошибка авторизации', ['error_code' => '4000', 'error_text' => 'Ошибка при проверке данных']);	
				return false; // ошибка при проверке данных
			}
			else {
				$xdelta_salt = $_SESSION['xdelta_salt'];
				$xdelta_user_agent = $_SERVER['HTTP_USER_AGENT'];
				$xdelta_user_ip = 'localhost';
				$session_hash = $_COOKIE[$this->session_name];
				$session_hash_check = md5($xdelta_salt.$xdelta_user_agent.$xdelta_user_ip);
				if ($session_hash_check	== $session_hash) {
					// echo 'session update';
					$this->session_update();
					return "1-все ок, проверку прошел"; // все ок	
				} else {
					// echo 'session not your';
					$uri = array_pop(explode('/', $_SERVER['REQUEST_URI']));
					if ($uri != 'login') {
						$this->session_is_not_yours();
						Response::jsonError('Ошибка авторизации', ['error_code' => '4010', 'error_text' => 'Сессия устарела']);
						return false; // ошибка при проверке данных
					} else {
						return "2-команда авторизации";
					}
				}
				
			}	
		}
		else {
			$this->session_init();
			// echo 'session init';
			return false; // новый пользователь
		}
	}
	
}

?>