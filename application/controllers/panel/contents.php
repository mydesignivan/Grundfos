<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Contents extends Controller {

    /* CONSTRUCTOR
     **************************************************************************/
    function __construct(){
        parent::Controller();

        if( !$this->session->userdata('logged_in') ) redirect($this->config->item('base_url'));
        
        $this->load->model("contents_model");

        $this->_data = array(
            'tlp_section'        =>  'panel/contents_view.php',
            'tlp_title'          =>  TITLE_INDEX,
            'tlp_title_section'  => "Contenidos"
        );
    }

    /* PRIVATE PROPERTIES
     **************************************************************************/
    private $_data;

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function index(){
        $data = array_merge($this->_data, array(
            //'tlp_script'    =>  array('plugins_validator', 'class_myaccount'),
        ));
        $this->load->view('template_panel_view', $data);
    }


    /* AJAX FUNCTIONS
     **************************************************************************/

    /* PRIVATE FUNCTIONS
     **************************************************************************/
}
