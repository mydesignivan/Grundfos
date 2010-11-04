<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Productos extends Controller {

    /* CONSTRUCTOR
     **************************************************************************/
    function __construct(){
        parent::Controller();

        $this->load->model('contents_model');
        $this->load->model('products_model');
        $this->_data=array(
            'tlp_title'            => TITLE_PRODUCTOS,
            'tlp_meta_description' => META_DESCRIPTION_PRODUCTOS,
            'tlp_meta_keywords'    => META_KEYWORDS_PRODUCTOS,
            'tlp_script'           => array('plugins_easyslider'),
            'listMenu'             => $this->contents_model->get_menu(),
            'data_banner'          => $this->contents_model->get_list_banner(),
            'content_footer'       => $this->contents_model->get_footer()
        );
    }

    /* PRIVATE PROPERTIES
     **************************************************************************/
    private $_data;

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function index(){
        if( $this->uri->total_segments()==1 ) redirect($this->config->item('base_url'));

        $info = $this->products_model->get_list_front($this->uri->segment(2));
        if( !$info ) redirect($this->config->item('base_url'));

        $data = array_merge($this->_data, array(
            'tlp_section'          => 'frontpage/products_view.php',
            'tlp_script'           => array('plugins_easyslider'),
            'info'                 => $info
        ));
        $this->load->view('template_frontpage_view', $data);
    }

    public function leermas(){
        $info = $this->products_model->get_product($this->uri->segment(3));
        if( !$info ) redirect($this->config->item('base_url'));
        $data = array_merge($this->_data, array(
            'tlp_section'          => 'frontpage/products_details_view.php',
            'info'                 => $info
        ));
        $this->load->view('template_frontpage_view', $data);
    }

    public function search(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){            
            $data = array_merge($this->_data, array(
                'tlp_section'          => 'frontpage/products_resultsearch_view.php',
                'tlp_script'           => array('plugins_easyslider'),
                'info'                 => $this->products_model->search()
            ));
            $this->load->view('template_frontpage_view', $data);
        }
    }


    /* AJAX FUNCTIONS
     **************************************************************************/

    /* PRIVATE FUNCTIONS
     **************************************************************************/

}