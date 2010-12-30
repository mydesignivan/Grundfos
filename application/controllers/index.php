<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Index extends MY_Controller {

    /* CONSTRUCTOR
     **************************************************************************/
    function __construct(){
        parent::MY_Controller();

        $this->load->model('contents_model');
        $this->load->model('lists_model');
        $this->load->helpers('form');
    }

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function index(){
        $ref = $this->uri->segment(1);
        $params = $this->_get_params($ref);
        $content = $this->contents_model->get_content($ref=="" ? "home" : null);

        $j=2;
        if( $ref=="" || $ref=="home" || $ref=="servicios" || $ref=="testimoniales" || $ref=="contacto" || $ref=="donde-estamos" ){
            $j=1;
        }
        if( isset($content['gallery']) && count($content['gallery'])>1 ){
            $this->assets->add_js_group(array('plugins_adgallery'));
        }
        if( strpos($content['content'], '{widget}') ){
            $j=1;
            $this->assets->add_js_group(array('plugins_validate'));
            $this->assets->add_js(array('plugins/formatnumber/formatnumber.min', 'class/solcapacitacion'));
            $this->_data = array('listCountry' => $this->lists_model->get_country(array(''=>'Seleccione un pa&iacute;s')));
        }

        if( $j==1 ){
            $this->assets->add_css(array('plugins_easyslider'));
            $this->assets->add_js(array('plugins/easySlider/easySlider.packed'));
        }

        $this->_render('front/contents_view', array_merge($this->_data, array(
            'listMenu'             => $this->contents_model->get_menu(),
            'data_banner'          => $this->contents_model->get_list_banner(),
            'content_footer'       => $this->contents_model->get_footer(),
            'class_num_header'     => $j,
            'tlp_title'            => $params['title'],
            'tlp_meta_description' => $params['meta_description'],
            'tlp_meta_keywords'    => $params['meta_keywords'],
            'reference'            => $params['reference'],
            'content'              => $content
        )));
    }

    public function send_formcapacitacion(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){
            $this->load->library('email');
            $this->load->model('users_model');

            $config = array();
            $config['nl2br'] = 'txtMessage';
            $config['default'] = '---';
            $config['data'] = array('country' => $this->lists_model->get_country_name($this->input->post('cboCountry')));

            $message = set_message(json_decode(EMAIL_SOLCAP_MESSAGE), $config);

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