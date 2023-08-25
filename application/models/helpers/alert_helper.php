<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function _base_alert($type, $title, $message = false)
{
  $CI =& get_instance();
  $alert = json_encode(array('type' => $type, 'head' => $title, 'message' => $message));
  $process_alert = process_alert($alert);
  $CI->session->set_flashdata('alert', $process_alert);
}

function process_alert($json)
{
  $config = json_decode($json);
  $icon   = '';
  switch($config->{'type'})
  {
    case 'success':
    $icon = 'ok-sign';
    $head = 'Success!';
    break;
    
    case 'info':
    $icon = 'info-sign';
    $head = 'Info!';
    break;
      
    case 'warning':
    $icon = 'warning-sign';
    $head = 'Warning!';
    break;
        
    case 'danger':
    $icon = 'exclamation-sign';
    $head = 'Error!';
    break;
  }
  
  $head = (!empty($config->{'head'})) ? $config->{'head'} : $head;
  $msg  = (empty($config->{'message'})) ? '' : $config->{'message'};
  return '
    <div class="mt-3 row">
      <div class="col-md-12">
        <div class="alert alert-'.$config->{'type'}.' alert-with-icon" data-notify="container">
          <button type="button" data-dismiss="alert" aria-hidden="true" class="close">×</button>
          <span data-notify="icon" class="glyphicon glyphicon-'.$icon.'"></span> 
          <span data-notify="message"><strong>'.$head.'</strong> - '. $msg .'</span>
        </div>
      </div>
    </div>
  ';
}

if (!function_exists('alert_success'))
{
  function alert_success($title, $message = false)
  {
    _base_alert('success', $title, $message);
  }
}
if (!function_exists('alert_warning'))
{
  function alert_warning($title, $message = false)
  {
    _base_alert('warning', $title, $message);
  }
}
if (!function_exists('alert_error'))
{
  function alert_error($title, $message = false)
  {
    _base_alert('danger', $title, $message);
  }
}
if (!function_exists('alert_info'))
{
  function alert_info($title, $message = false)
  {
    _base_alert('info', $title, $message);
  }
}
/* End of file alert_helper.php */
/* Location: ./application/helpers/alert_helper.php */
// https://gist.github.com/gpedro/9010740/revisions (Edited)
