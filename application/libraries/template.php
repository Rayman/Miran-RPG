<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Template Class
*
* Template View Parse Class
*
* @package     CodeIgniter
* @subpackage  Libraries
* @category    Templates
* @author      Koola
* @link
*/
class Template {

    /**
     * Constructor
     *
     * @access    public
     */
    function __construct()
    {
        log_message('debug', "Template Class Initialized");
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Load template
     *
     * @access   public
     * @param    String
     * @param    Array
     * @param    Array
     * @param    bool
     * @return   parsed view
     */
    function load($template = '', $view = array(), $vars = array(), $return = FALSE)
    {
    $this->CI =& get_instance();
    $tpl = array();
        
    // Check for partials to load
    if (count($view) > 0)
    {
        // Load views into var array
        foreach($view as $key => $file)
        {
            $tpl[$key] = $this->CI->load->view($file, $vars, TRUE);
        }
        // Merge into vars array
        $vars = array_merge($vars, $tpl);
    }
    
    // Load master template
    return $this->CI->load->view($template, $vars, $return);
    }
}
?>
