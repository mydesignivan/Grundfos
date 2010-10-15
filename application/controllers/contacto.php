<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Contacto extends Controller {

    /* CONSTRUCTOR
     **************************************************************************/
    function __construct(){
        parent::Controller();

        $this->load->model('contents_model');
        $this->load->model('lists_model');
        $this->_data=array(
            'listMenu'  =>  $this->contents_model->get_menu()
        );
    }

    /* PRIVATE PROPERTIES
     **************************************************************************/
    private $_data;

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function index(){
        $ref = $this->uri->segment(1);
        $this->load->helpers('form');

        $data = array_merge($this->_data, array(
            'tlp_title'            => TITLE_CONTACTO,
            'tlp_title_section'    => 'Contacto',
            'tlp_meta_description' => META_DESCRIPTION_CONTACTO,
            'tlp_meta_keywords'    => META_KEYWORDS_CONTACTO,
            'tlp_section'          => 'frontpage/contact_view.php',
            'tlp_script'           => array('class_account'),
            'content'              => $this->contents_model->get_content($ref),
            'listCountry'          => $this->lists_model->get_country(array(''=>'Seleccione un pa&iacute;s'))
        ));
        $this->load->view('template_frontpage_view', $data);
    }

    public function send(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){
            $this->load->library('email');

            $message = EMAIL_CONTACT_MESSAGE;
            $message = str_replace('{name}', $_POST['txtName'], $message);
            $message = str_replace('{mail}', $_POST['txtEmail'], $message);
            $message = str_replace('{message}', $_POST['txtMessage'], $message);

            //$datauser = $this->users_model->get_info(array('username'=>'mydesignadmin'));
            $datauser = $this->users_model->get_info(array('username'=>'admin'));
            $to = $datauser['email'];

            $this->email->from($_POST['txtEmail'], $_POST['txtName']);
            $this->email->to($to);
            $this->email->subject(EMAIL_CONTACT_SUBJECT);
            $this->email->message(nl2br($message));
            $status = $this->email->send();
            $this->session->set_flashdata('status_sendmail', $status ? "ok" : "error");

            redirect('/contact-us/');
        }
    }


    /* AJAX FUNCTIONS
     **************************************************************************/
     public function ajax_show_states(){
        $arr = $this->lists_model->get_states($this->input->post('country_id'));
        echo '<option value="">Seleccione una provincia</option>';
        foreach( $arr as $val ) echo '<option value="'.$val['name'].'">'.$val['name'].'</option>';
     }

    /* PRIVATE FUNCTIONS
     **************************************************************************/

}