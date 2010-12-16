<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Index extends Controller {

    /* CONSTRUCTOR
     **************************************************************************/
    function __construct(){
        parent::Controller();
        $this->load->library("simplelogin");
        $this->load->model('contents_model');
        $this->_data=array(
            'listMenu'  =>  $this->contents_model->get_menu(),
            'content_footer' => $this->contents_model->get_footer()
        );
    }

    /* PRIVATE PROPERTIES
     **************************************************************************/
    private $_data;

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function index(){
        if( $this->session->userdata('logged_in') ) {
            redirect('/panel/myaccount/');
        }else{
            $data = array_merge($this->_data, array(
                'tlp_section'        =>  'panel/login_view.php',
                'tlp_title'          =>  TITLE_INDEX
            ));
            $this->load->view('template_frontpage_view', $data);
        }
    }

    public function login(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){
            $statusLogin = $this->simplelogin->login($_POST["txtUser"], $_POST["txtPass"]);
            
            if( $statusLogin['status']=="error" ){
                if( $statusLogin['error']=="loginfaild" ){
                    $message = "El usuario y/o password son incorrectos.";
                }
                $this->session->set_flashdata('message_login', $message);
                redirect('/panel/');

            }else{
                redirect('/panel/myaccount/');
            }
        }
    }

    public function logout(){
        $this->simplelogin->logout();
        redirect($this->config->item('base_url'));
    }


    /* AJAX FUNCTIONS
     **************************************************************************/

    /* PRIVATE FUNCTIONS
     **************************************************************************/
}