<?php
/**
 * lsys session
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace LSYS;
/**
 * Base session class.
 *
 * @package    
 */
abstract class Session {
	/**
	 * Creates a singleton session of the given type. Some session types
	 * (native, database) also support restarting a session by passing a
	 * session id as the second parameter.
	 *
	 *     $session = Session::factory($config);
	 *
	 * [!!] [Session::write] will automatically be called when the request ends.
	 *
	 * @param   string  $id     session identifier
	 * @return  Session
	 * @uses    ::$config
	 */
    public static function factory(Config $config,?string $id = NULL)
	{
		$_id=strval($id);
		$class = $config->get("handler");
		if (!class_exists($class,true)||!in_array(__CLASS__,class_parents($class))){
		    throw new \LSYS\Exception(strtr("config [:class] wong,not extends :pclass",array("class"=>$class,"pclass"=>__CLASS__)));
		}
		return new $class($config,$id);
	}
	/**
	 * @var Config
	 */
	protected $_config;
	protected $_id;
	/**
	 * Overloads the name, lifetime, and encrypted session settings.
	 *
	 * @param   array   $config configuration
	 * @param   string  $id     session id
	 * @return  void
	 * @uses    Session::read
	 */
	public function __construct(Config $config,?string $id=null)
	{
	    $this->_config=$config;
		$this->_id=$id;
	}
	/**
	 * Get the current session id, if the session supports it.
	 *
	 *     $id = $session->id();
	 *
	 * @return  string
	 */
	public function id():string
	{
	    return $this->_id;
	}
	/**
	 * start session
	 */
	abstract public function start();
	/**
	 * Get the current session cookie name.
	 *
	 *     $name = $session->name();
	 *
	 * @return  string
	 */
	abstract public function name():string;
	/**
	 * Get a variable from the session array.
	 *
	 *     $foo = $session->get('foo');
	 *
	 * @param   string  $key        variable name
	 * @param   mixed   $default    default value to return
	 * @return  mixed
	 */
	abstract public function get(string $key, $default = NULL);
	/**
	 * Set a variable in the session array.
	 *
	 *     $session->set('foo', 'bar');
	 *
	 * @param   string  $key    variable name
	 * @param   mixed   $value  value
	 * @return  $this
	 */
	abstract public function set(string $key, $value);
	/**
	 * Removes a variable in the session array.
	 *
	 *     $session->delete('foo');
	 *
	 * @param   string  $key,...    variable name
	 * @return  $this
	 */
	abstract public function delete(string $key);
	/**
	 * Sets the last_active timestamp and saves the session.
	 *
	 *     $session->writeClose();
	 *
	 * @return  boolean
	 */
	abstract public function writeClose():bool;
	/**
	 * Completely destroy the current session.
	 *
	 *     $success = $session->destroy();
	 *
	 * @return  boolean
	 */
	abstract public function destroy():bool;
	/**
	 * Restart the session.
	 *
	 *     $success = $session->restart();
	 *
	 * @return  boolean
	 */
	abstract public function restart():bool;
	/**
	 * Generate a new session id and return it.
	 *
	 * @return  string
	 */
	abstract public function regenerate():string;
}
