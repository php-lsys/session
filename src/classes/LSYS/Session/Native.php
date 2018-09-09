<?php
/**
 * lsys session
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace LSYS\Session;
use LSYS\Config;
class Native extends \LSYS\Session {
	/**
	 * @param Config $config
	 * @param string $id
	 */
	public function __construct(Config $config,$id=null)
	{
		parent::__construct($config,$id);
		if (session_status()==PHP_SESSION_NONE){
			$session_cookie_domain = $this->_config->get("domain");
			$path=$this->_config->get("path");
			$secure=$this->_config->get("secure");
			$httponly=$this->_config->get("httponly");
			$lifetime = (string) $config->get("lifetime",ini_get("session.cookie_lifetime"));
			session_set_cookie_params(
					$lifetime,
					$path,
					$session_cookie_domain,
					$secure,
					$httponly
					);
			session_cache_limiter(FALSE);
			$name = (string) $config->get("name",ini_get("session.name"));
			if ($name!=ini_get("session.name")) session_name($name);
		}
		if ($id!=NULL) session_id($id);
	}
	/**
	 * {@inheritDoc}
	 * @see \LSYS\Session::start()
	 */
	public function start(){
		if(session_status()==PHP_SESSION_NONE)session_start();
	}
	/**
	 * @return  string
	 */
	public function id()
	{
		return session_id();
	}
	public function name()
	{
		return session_name();
	}
	/**
	 * @return  string
	 */
	public function regenerate()
	{
		$this->start();
		session_regenerate_id();
		return session_id();
	}
	/**
	 * @return  bool
	 */
	public function write_close()
	{
		session_write_close();
		return TRUE;
	}
	/**
	 * @return  bool
	 */
	public function restart()
	{
		$this->start();
		if(!headers_sent()){
			session_destroy();
			session_start();
		}
		session_regenerate_id();
		return true;
	}
	/**
	 * @return  bool
	 */
	public function destroy()
	{
		$this->start();
		session_destroy();
		$status = $this->id();
		if ($status)
		{
			$name=$this->name();
			unset($_COOKIE[$name]);
			$path=$this->_config->get("path",null);
			$session_cookie_domain = $this->_config->get("domain",ini_get('session.cookie_domain'));
			return @setcookie($name, NULL, -86400,$path, $session_cookie_domain);
		}
		return true;
	}
	public function get($key, $default = NULL)
	{
		$this->start();
		return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
	}
	public function set($key, $value)
	{
		$this->start();
		$_SESSION[$key] = $value;
		return $this;
	}
	public function delete($key)
	{
		$this->start();
		$args = func_get_args();
		foreach ($args as $key)
		{
			unset($_SESSION[$key]);
		}
		return $this;
	}
}
