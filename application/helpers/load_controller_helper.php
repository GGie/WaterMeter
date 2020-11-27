<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('load_controller'))
{
    function load_controller($module,$controller, $method = 'index',$data_param="")
	
    {
        require_once(FCPATH . APPPATH . 'modules/'.$module.'/controllers/' . $controller . '.php');

        $controller = new $controller();

        return $controller->$method($data_param);
    }
}