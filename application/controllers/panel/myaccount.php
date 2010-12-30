<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Myaccount extends MY_Controller {

    /* CONSTRUCTOR
     **************************************************************************/
    function __construct(){
        parent::MY_Controller();

        if( !$this->session->userdata('logged_in') ) redirect('panel');
        
        $this->load->model("users_model");
    }

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function index(){
        $this->assets->add_js_group('plugins_validate');
        $this->assets->add_js('class/myaccount');
        $this->_render('panel/myaccount_view', array(
            'tlp_section'   =>  'panel/myaccount_view.php',
            'tlp_title'     =>  TITLE_INDEX,
            'info'          =>  $this->users_model->get_info(array('username'=>$this->session->userdata('username')))
        ), 'panel_view');
    }

    public function save(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){
            $res = $this->users_model->save();
            $this->session->set_flashdata('status', $res ? "success" : "error");
            redirect('/panel/myaccount/');
        }
    }

    /* AJAX FUNCTIONS
     **************************************************************************/
    public function ajax_check_pass(){
        if( $_SERVER['REQUEST_METHOD']=="POST" && $this->input->post('txtPassOld') ){
            $this->load->library('encpss');
            $res = $this->users_model->get_info(array('username'=>$this->session->userdata('username')));
            echo json_encode($this->encpss->decode($res['password'])==trim($this->input->post('txtPassOld')));
        }
    }

    /* PRIVATE FUNCTIONS
     **************************************************************************/
}
