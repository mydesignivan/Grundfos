<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Ajax extends Controller {

    /* CONSTRUCTOR
     **************************************************************************/
    function __construct(){
        parent::Controller();
    }

    /* PRIVATE PROPERTIES
     **************************************************************************/

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function show_formcv(){
        $this->load->view('frontpage/ajax/cv_view');
    }
    
    public function send_formcv(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){
            $this->load->model('users_model');
            $file = $_FILES['txtCV'];
            
            if( is_uploaded_file($file['tmp_name']) ){
                $filename = UPLOAD_PATH_CV . get_filename($file['name']);
                if( move_uploaded_file($file['tmp_name'], $filename) ){
                    chmod($filename, 0777);
                    
                    $message = EMAIL_CV_MESSAGE;
                    $message = str_replace('{name}', $this->input->post('txtName'), $message);
                    $message = str_replace('{email}', $this->input->post('txtEmail'), $message);
                    $message = str_replace('{comment}', nl2br($this->input->post('txtComment')), $message);

                    $datauser = $this->users_model->get_info(array('username'=>'admin'));
                    $to = $datauser['email_cv'];

                    $this->load->library('email');
                    $this->email->from($this->input->post('txtEmail'), $this->input->post('txtName'));
                    $this->email->to($to);
                    $this->email->subject(EMAIL_CV_SUBJECT);
                    $this->email->message($message);
                    $this->email->attach($filename);
                    echo $this->email->send() ? "send" : "notsend";
                }
            }else echo "notupload";
        }
        die();
    }

}