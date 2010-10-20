<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class noticias_model extends Model {

    /* CONSTRUCTOR
     **************************************************************************/
    function  __construct() {
        parent::Model();
    }

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function get_list_front(){
        $this->db->order_by('order', 'asc');
        return $this->db->get_where(TBL_TESTIMONIALES)->result_array();
    }

    /* PRIVATE FUNCTIONS
     **************************************************************************/
    
}