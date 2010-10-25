<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Products extends Controller {

    /* CONSTRUCTOR
     **************************************************************************/
    function __construct(){
        parent::Controller();

        if( !$this->session->userdata('logged_in') ) redirect($this->config->item('base_url'));
        
        //$this->load->model("products_model");

        $this->_data = array(
            'tlp_section'        =>  'panel/products_view.php',
            'tlp_title'          =>  TITLE_INDEX,
            'tlp_title_section'  => "Productos"
        );
    }

    /* PRIVATE PROPERTIES
     **************************************************************************/
    private $_data;

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function index(){
        $data = array_merge($this->_data, array(
            'tlp_script'    =>  array('plugins_treeview_inc', 'class_products'),
        ));
        $this->load->view('template_panel_view', $data);
    }


    /* AJAX FUNCTIONS
     **************************************************************************/
     public function ajax_showform_categorie(){
         $this->load->view('');
     }


    /* PRIVATE FUNCTIONS
     **************************************************************************/
}
