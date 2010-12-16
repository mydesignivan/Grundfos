<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Index extends Controller {

    /* CONSTRUCTOR
     **************************************************************************/
    function __construct(){
        parent::Controller();

        $this->load->model('contents_model');
        $this->load->model('lists_model');
        $this->load->helpers('form');
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
        $params = $this->_get_params($ref);
        $content = $this->contents_model->get_content($ref=="" ? "home" : null);

        $tlp_script=array();
        if( $ref=="" || $ref=="home" || $ref=="servicios" || $ref=="testimoniales" || $ref=="contacto" || $ref=="donde-estamos" ){
            $tlp_script[] = 'plugins_easyslider';
        }
        if( isset($content['gallery']) && count($content['gallery'])>1 ){
            $tlp_script[] = 'plugins_adgallery';
        }
        if( strpos($content['content'], '{widget}') ){
            $tlp_script = array_merge($tlp_script, array('plugins_easyslider', 'plugins_validator','plugins_formatnumber', 'class_solcapacitacion'));
            $cboCountry =  array('listCountry' => $this->lists_model->get_country(array(''=>'Seleccione un pa&iacute;s')));
            $this->_data = array_merge($this->_data, $cboCountry);
        }

        if( count($tlp_script)>0 ) $this->_data['tlp_script'] = $tlp_script;

        $data = array_merge($this->_data, array(
            'tlp_title'            => $params['title'],
            'tlp_meta_description' => $params['meta_description'],
            'tlp_meta_keywords'    => $params['meta_keywords'],
            'tlp_section'          => 'frontpage/contents_view.php',
            'reference'            => $params['reference'],
            'content'              => $content
        ));
        $this->load->view('template_frontpage_view', $data);
    }

    public function send_formcapacitacion(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){
            $this->load->library('email');
            $this->load->model('users_model');

            $phone = $this->input->post('txtPhoneNum');
            if( $this->input->post('txtPhoneCode')!='' ) $phone = $this->input->post('txtPhoneCode')." - ".$phone;
            $fax = $this->input->post('txtFaxNum');
            if( $this->input->post('txtFaxCode')!='' ) $fax = $this->input->post('txtFaxCode')." - ".$fax;

            $message = EMAIL_SOLCAP_MESSAGE;
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
            $to = $datauser['email_solcap'];

            $this->email->from($this->input->post('txtEmail'), $this->input->post('txtName'));
            $this->email->to($to);
            $this->email->subject(EMAIL_SOLCAP_SUBJECT);
            $this->email->message($message);
            $status = $this->email->send();
            $this->session->set_flashdata('status_sendmail', $status ? "ok" : "error");

            redirect($this->input->post('redirect'));
        }
    }

    /* AJAX FUNCTIONS
     **************************************************************************/
    
    /* PRIVATE FUNCTIONS
     **************************************************************************/
    private function _get_params($ref){
         switch($ref){
             default:
                 return array(
                     'title'            => TITLE_INDEX,
                     'meta_description' => META_DESCRIPTION_INDEX,
                     'meta_keywords'    => META_KEYWORDS_INDEX,
                     'reference'        => 'home'
                 );
             break;
             case 'empresa':
                 return array(
                     'title'            => TITLE_EMPRESA,
                     'meta_description' => META_DESCRIPTION_EMPRESA,
                     'meta_keywords'    => META_KEYWORDS_EMPRESA,
                     'reference'        => 'empresa'
                 );
             break;
             case 'servicios':
                 return array(
                     'title'            => TITLE_SERVICIOS,
                     'meta_description' => META_DESCRIPTION_SERVICIOS,
                     'meta_keywords'    => META_KEYWORDS_SERVICIOS,
                     'reference'        => 'servicios'
                 );
             break;
             case 'testimoniales':
                 return array(
                     'title'            => TITLE_TESTIMONIALES,
                     'meta_description' => META_DESCRIPTION_TESTIMONIALES,
                     'meta_keywords'    => META_KEYWORDS_TESTIMONIALES,
                     'reference'        => 'testimoniales'
                 );
             break;
             case 'donde-estamos':
                 return array(
                     'title'            => TITLE_DONDESTAMOS,
                     'meta_description' => META_DESCRIPTION_DONDESTAMOS,
                     'meta_keywords'    => META_KEYWORDS_DONDESTAMOS,
                     'reference'        => 'donde-estamos'
                 );
             break;
         }
    }

}