<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('load_model'))
{
    function load_model($module,$model, $method = "index",$data_param="")
    {
		
        require_once(FCPATH . APPPATH . 'modules/'.$module.'/models/' . $model . '.php');

        $model = new $model();

        return $model->$method($data_param);
    }
}