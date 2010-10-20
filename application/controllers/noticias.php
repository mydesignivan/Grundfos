<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Noticias extends Controller {

    /* CONSTRUCTOR
     **************************************************************************/
    function __construct(){
        parent::Controller();

        $this->load->model('contents_model');
        $this->load->model('noticias_model');
        $this->_data=array(
            'listMenu'  =>  $this->contents_model->get_menu(),
            'tlp_script'  => array('plugins_easyslider')
        );
    }

    /* PRIVATE PROPERTIES
     **************************************************************************/
    private $_data;

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function index(){
        die("pase");
        $ref = $this->uri->segment(1);        

        $data = array_merge($this->_data, array(
            'tlp_title'            => TITLE_TESTIMONIALES,
            'tlp_title_section'    => 'Testimoniales',
            'tlp_meta_description' => META_DESCRIPTION_TESTIMONIALES,
            'tlp_meta_keywords'    => META_KEYWORDS_TESTIMONIALES,
            'tlp_section'          => 'frontpage/testimoniales_view.php',
            'list'                 => $this->testimoniales_model->get_list_front()
        ));
        $this->load->view('template_frontpage_view', $data);
    }

    /* AJAX FUNCTIONS
     **************************************************************************/

    /* PRIVATE FUNCTIONS
     **************************************************************************/

}