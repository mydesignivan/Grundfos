<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Productos extends MY_Controller {

    /* CONSTRUCTOR
     **************************************************************************/
    function __construct(){
        parent::MY_Controller();

        $this->load->model('contents_model');
        $this->load->model('products_model');

        $this->assets->add_css(array('plugins_easyslider'));
        $this->assets->add_js(array('plugins/easySlider/easySlider.packed'));

        $this->_data=array(
            'tlp_title'            => TITLE_PRODUCTOS,
            'tlp_meta_description' => META_DESCRIPTION_PRODUCTOS,
            'tlp_meta_keywords'    => META_KEYWORDS_PRODUCTOS,
            'class_num_header'     => 1,
            'listMenu'             => $this->contents_model->get_menu(),
            'data_banner'          => $this->contents_model->get_list_banner(),
            'content_footer'       => $this->contents_model->get_footer()
        );
    }

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function index(){
        if( $this->uri->total_segments()==1 ) redirect($this->config->item('base_url'));

        $info = $this->products_model->get_list_front($this->uri->segment(2));
        if( !$info ) redirect($this->config->item('base_url'));

        $this->_render('front/products_view', array_merge($this->_data, array(
            'info' => $info
        )));
    }

    public function leermas(){
        $info = $this->products_model->get_product($this->uri->segment(3));
        if( !$info ) redirect($this->config->item('base_url'));
        $this->_render('front/products_details_view', array_merge($this->_data, array(
            'info' => $info
        )));
    }

    public function search(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){            
            $this->_render('front/products_resultsearch_view', array_merge($this->_data, array(
                'info' => $this->products_model->search()
            )));
        }
    }


    /* AJAX FUNCTIONS
     **************************************************************************/

    /* PRIVATE FUNCTIONS
     **************************************************************************/

}