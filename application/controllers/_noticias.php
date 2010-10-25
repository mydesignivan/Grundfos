<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Noticias extends Controller {

    /* CONSTRUCTOR
     **************************************************************************/
    function __construct(){
        parent::Controller();

        $this->load->model('contents_model');
        $this->load->model('noticias_model');
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
       
        $ref = $this->uri->segment(2);
        $content = $this->contents_model->get_content($ref=="" ? "home" : null);
        $data = array_merge($this->_data, array(
            'tlp_title'            => TITLE_NOTICIAS,
            'tlp_meta_description' => META_DESCRIPTION_NOTICIAS,
            'tlp_meta_keywords'    => META_KEYWORDS_NOTICIAS,
            'tlp_section'          => 'frontpage/noticias_view.php',
            'list'                 => $this->noticias_model->get_list_front(),
            'content'              => $content
        ));
        $this->load->view('template_frontpage_view', $data);
    }

    /* AJAX FUNCTIONS
     **************************************************************************/

    /* PRIVATE FUNCTIONS
     **************************************************************************/

}