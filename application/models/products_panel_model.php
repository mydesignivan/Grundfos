<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Products_panel_model extends Model {

    /* CONSTRUCTOR
     **************************************************************************/
    function  __construct() {
        parent::Model();
    }

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function get_list($ref){
        $output = array();

        $this->db->order_by('order', 'asc');
        $query = $this->db->get_where(TBL_PRODUCTS, array('categorie_reference'=>$ref));
        $output['listProducts'] = $query->result_array();

        $output['childs'] = $this->_get_childs($output['parent_id']);

        return $output;
    }


    /* PRIVATE FUNCTIONS
     **************************************************************************/
}