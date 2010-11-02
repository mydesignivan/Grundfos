<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Contents extends Controller {

    /* CONSTRUCTOR
     **************************************************************************/
    function __construct(){
        parent::Controller();

        if( !$this->session->userdata('logged_in') ) redirect($this->config->item('base_url'));
        
        $this->load->model("contents_panel_model");

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
            'tlp_script'          => array('plugins_treeview', 'plugins_validator', 'plugins_picturegallery', 'plugins_fancybox', 'helpers_json', 'class_contents'),
            'tlp_script_special'  => array('plugins_tiny_mce', 'plugins_jqui_sortable'),
            'treeview'            => $this->contents_panel_model->get_treeview()
        ));
        $this->load->view('template_panel_view', $data);
    }


    /* AJAX FUNCTIONS
     **************************************************************************/
     public function ajax_show_form(){
         $data = array();
         if( is_numeric($this->uri->segment(4)) ){
             $data['info'] = $this->contents_panel_model->get_info($this->uri->segment(4));
         }
         $this->load->view('panel/ajax/contents_form_view', $data);
     }
     
     public function ajax_create(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){
            $res = $this->contents_panel_model->create();
            echo($res ? "ok" : $res);
            die();
        }
     }

     public function ajax_edit(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){
            $res = $this->contents_panel_model->edit();
            echo($res ? "ok" : $res);
            die();
        }
     }

     public function ajax_del(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){
            echo($this->contents_panel_model->delete($this->uri->segment(4)) ? "ok" : "error");
            die();
        }
     }

     public function ajax_order(){
        die($this->contents_panel_model->order() ? "success" : "error");
     }

     public function ajax_show_treeview(){
        die($this->contents_panel_model->get_treeview());
     }

    public function ajax_upload_gallery(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){

            $this->load->library('superupload');

            $config = array(
                'path'            => UPLOAD_PATH_SIDEBAR.'.tmp/',
                'thumb_width'     => IMAGESIZE_WIDTH_THUMB_SIDEBAR,
                'thumb_height'    => IMAGESIZE_HEIGHT_THUMB_SIDEBAR,
                'image_width'     => IMAGESIZE_WIDTH_FULL_SIDEBAR,
                'image_height'    => IMAGESIZE_HEIGHT_FULL_SIDEBAR,
                'maxsize'         => UPLOAD_MAXSIZE,
                'filetype'        => UPLOAD_FILETYPE,
                'filename_prefix' => $this->session->userdata('users_id')."_",
                'master_dim'      => 'height'
            );
            $this->superupload->initialize($config);
            echo json_encode($this->superupload->upload('txtUploadFile'));
            die();
        }
    }

    public function ajax_upload_delete(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){
            @unlink($_POST['au_filename_image']);
            @unlink($_POST['au_filename_thumb']);
            die("ok");
        }
    }
    
    /* PRIVATE FUNCTIONS
     **************************************************************************/
}
