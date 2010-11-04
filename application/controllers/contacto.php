<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Contacto extends Controller {

    /* CONSTRUCTOR
     **************************************************************************/
    function __construct(){
        parent::Controller();

        $this->load->model('contents_model');
        $this->load->model('lists_model');
        $this->_data=array(
            'listMenu'       => $this->contents_model->get_menu(),
            'data_banner'    => $this->contents_model->get_list_banner(),
            'content_footer' => $this->contents_model->get_footer()
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
            'tlp_meta_description' => META_DESCRIPTION_CONTACTO,
            'tlp_meta_keywords'    => META_KEYWORDS_CONTACTO,
            'tlp_section'          => 'frontpage/contact_view.php',
            'tlp_script'           => array('plugins_easyslider', 'plugins_validator','plugins_formatnumber', 'class_account'),
            'listCountry'          => $this->lists_model->get_country(array(''=>'Seleccione un pa&iacute;s'))
        ));
        $this->load->view('template_frontpage_view', $data);
    }

    public function send(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){
            $this->load->library('email');
            $this->load->model('users_model');

            $phone = $this->input->post('txtPhoneNum');
            if( $this->input->post('txtPhoneCode')!='' ) $phone = $this->input->post('txtPhoneCode')." - ".$phone;
            $fax = $this->input->post('txtFaxNum');
            if( $this->input->post('txtFaxCode')!='' ) $fax = $this->input->post('txtFaxCode')." - ".$fax;
            
            $message = EMAIL_CONTACT_MESSAGE;
            $message = str_replace('{company}', $this->input->post('txtCompany'), $message);
            $message = str_replace('{name}', $this->input->post('txtName'), $message);
            $message = str_replace('{address}', $this->input->post('txtAddress'), $message);
            $message = str_replace('{city}', $this->input->post('txtCity'), $message);
            $message = str_replace('{postcode}', $this->input->post('txtPC'), $message);
            $message = str_replace('{country}', $this->input->post('cboCountry'), $message);
            $message = str_replace('{state}', $this->input->post('cboState'), $message);
            $message = str_replace('{email}', $this->input->post('txtEmail'), $message);
            $message = str_replace('{phone}', $phone, $message);
            $message = str_replace('{fax}', $fax, $message);
            $message = str_replace('{theme}', $this->input->post('txtTheme'), $message);
            $message = str_replace('{message}', nl2br($this->input->post('txtMessage')), $message);

            //die($message);

            //$datauser = $this->users_model->get_info(array('username'=>'mydesignadmin'));
            $datauser = $this->users_model->get_info(array('username'=>'admin'));
            $to = $datauser['email'];

            $this->email->from($this->input->post('txtEmail'), $this->input->post('txtName'));
            $this->email->to($to);
            $this->email->subject(EMAIL_CONTACT_SUBJECT);
            $this->email->message($message);
            $status = $this->email->send();
            $this->session->set_flashdata('status_sendmail', $status ? "ok" : "error");

            redirect('/contacto/');
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