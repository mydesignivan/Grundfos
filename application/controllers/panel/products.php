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
            'tlp_script'          => array('plugins_treeview', 'plugins_validator', 'helpers_json', 'class_products'),
            'tlp_script_special'  => array('plugins_tiny_mce', 'plugins_jqui_sortable'),
            'treeview'            => $this->categories_model->get_treeview()
        ));
        $this->load->view('template_panel_view', $data);
    }


    /* AJAX FUNCTIONS
     **************************************************************************/
     public function ajax_form_categorie(){
         $data = array();
         if( is_numeric($this->uri->segment(4)) ){
             $data['info'] = $this->categories_model->get_info($this->uri->segment(4));
         }
         $this->load->view('panel/ajax/categorie_form_view', $data);
     }
     
     public function ajax_form_products(){
         $data = array('reference' => $this->categories_model->get_reference($this->uri->segment(4)));

         if( is_numeric($this->uri->segment(5)) ){
             $data['info'] = $this->products_panel_model->get_info($this->uri->segment(5));
         }
         $this->load->view('panel/ajax/products_form_view', $data);
     }
     
     public function ajax_list_products(){
         $data = array(
             'List' => $this->products_panel_model->get_list($this->uri->segment(4))
         );
         $this->load->view('panel/ajax/products_list_view', $data);
     }

     public function ajax_categories_create(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){
            echo($this->categories_model->create());
            die();
        }
     }

     public function ajax_categories_edit(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){
            echo($this->categories_model->edit());
            die();
        }
     }

     public function ajax_categories_del(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){
            echo($this->categories_model->delete($this->uri->segment(4)) ? "ok" : "error");
            die();
        }
     }

     public function ajax_categories_order(){
        die($this->categories_model->order() ? "success" : "error");
     }

     public function ajax_products_create(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){
            echo($this->products_panel_model->create());
            die();
        }
     }

     public function ajax_products_edit(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){
            echo($this->products_panel_model->edit());
            die();
        }
     }

     public function ajax_products_del(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){
            $id = $this->uri->segment_array();
            array_splice($id, 0,3);
            echo($this->products_panel_model->delete($id) ? "ok" : "error");
            die();
        }
     }

     public function ajax_products_order(){
        die($this->products_panel_model->order() ? "success" : "error");
     }

     public function ajax_show_treeview(){
        die($this->categories_model->get_treeview());
     }

     public function ajax_upload_products(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){

            $this->load->library('superupload');

            $config = array(
                'path'          => UPLOAD_PATH_PRODUCTS.'.tmp/',
                'thumb_width'   => IMAGESIZE_WIDTH_THUMB_PRODUCTS,
                'thumb_height'  => IMAGESIZE_HEIGHT_THUMB_PRODUCTS,
                'maxsize'       => UPLOAD_MAXSIZE,
                'filetype'      => UPLOAD_FILETYPE,
                'resize_image_original' => false,
                'master_dim'            => 'width',
                'filename_prefix'       => $this->session->userdata('users_id')."_"
            );
            $this->superupload->initialize($config);
            echo json_encode($this->superupload->upload(key($_FILES)));
        }
     }



    /* PRIVATE FUNCTIONS
     **************************************************************************/
}
