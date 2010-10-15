<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Index extends Controller {

    /* CONSTRUCTOR
     **************************************************************************/
    function __construct(){
        parent::Controller();

        $this->load->model('contents_model');
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
        $params = $this->_get_params($ref);

        $data = array_merge($this->_data, array(
            'tlp_title'            => $params['title'],
            'tlp_title_section'    => $params['title_section'],
            'tlp_meta_description' => $params['meta_description'],
            'tlp_meta_keywords'    => $params['meta_keywords'],
            'tlp_section'          => 'frontpage/contents_view.php',
            'tlp_script'           => array('plugins_superfish'),
            'reference'            => $params['reference'],
            'content'              => $this->contents_model->get_content($ref)
        ));
        $this->load->view('template_frontpage_view', $data);
    }


    /* AJAX FUNCTIONS
     **************************************************************************/


    /* PRIVATE FUNCTIONS
     **************************************************************************/
    private function _get_params($ref){
         switch($ref){
             case 'empresa': default:
                 return array(
                     'reference'        => "home",
                     'title_section'    => '',
                     'title'            => TITLE_INDEX,
                     'meta_description' => META_DESCRIPTION_INDEX,
                     'meta_keywords'    => META_KEYWORDS_INDEX
                 );
             break;
         }
    }

}