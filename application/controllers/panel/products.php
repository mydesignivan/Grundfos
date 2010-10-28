<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Products extends Controller {

    /* CONSTRUCTOR
     **************************************************************************/
    function __construct(){
        parent::Controller();

        if( !$this->session->userdata('logged_in') ) redirect($this->config->item('base_url'));
        
        $this->load->model("products_panel_model");
        $this->load->model("categories_model");

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
            'tlp_script'          => array('plugins_treeview', 'plugins_validator', 'class_products'),
            'tlp_script_special'  => array('plugins_tiny_mce'),
            'treeview'            => $this->categories_model->get_treeview()
        ));
        $this->load->view('template_panel_view', $data);
    }


    /* AJAX FUNCTIONS
     **************************************************************************/
     public function ajax_showform_categorie(){
         $this->load->view('panel/ajax/categorie_form_view');
     }
     
     public function ajax_showform_products(){
         $data = array(
             'list' => $this->products_panel_model->get_list($this->uri->segment(3))
         );
         $this->load->view('panel/ajax/categorie_products_view', $data);
     }

     public function ajax_categories_create(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){
            echo($this->categories_model->create());
            die();
        }
     }

     public function ajax_show_treeview(){
        die($this->categories_model->get_treeview());
     }


    /* PRIVATE FUNCTIONS
     **************************************************************************/
}
