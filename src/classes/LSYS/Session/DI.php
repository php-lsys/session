<?php
namespace LSYS\Session;
/**
 * @method \LSYS\Session session($id=null,$config=null)
 */
class DI extends \LSYS\DI{
    /**
     *
     * @var string default config
     */
    public static $config = 'session.native';
    /**
     * @return static
     */
    public static function get(){
        $di=parent::get();
        !isset($di->session)&&$di->session(new \LSYS\DI\ShareCallback(function($id=null,$config=null){
            return ($config?$config:self::$config)."-".$id;
        },function($id=null,$config=null){
            $config=\LSYS\Config\DI::get()->config($config?$config:self::$config);
            return \LSYS\Session::factory($config,$id);
        }));
        return $di;
    }
}