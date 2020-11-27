<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('load_view'))
{
    function load_view($module,$view, $data = "")
    {
        require_once(FCPATH . APPPATH . 'modules/'.$module.'/views/' . $view . '.php');

      // $view = new $view();

       // return $view->$method($data);
    }
}