<?php
class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->config->load('navigation_bar');
		$this->load->library('session');
		$this->load->model('user_model');
		$this->load->helper('url');
	}


	public function is_overdue($token_alive_time)
	{
	    $now_time = time();

	    if ($now_time > $token_alive_time) {
	    	return false;
	    }else{
	    	return true;
	    }
	}

	// is logined
	public function is_logined()
	{
	    // is set in session
	    if ($this->session->userID == NULL){
	        return false;
	    }else{
	        // is overdue
	        $userID = $this->session->userID;
	        $token_alive_time = $this->user_model->get_token_alive_time($userID);

	        if ($this->is_overdue($token_alive_time)){
	        	return true;
	        }else{
	        	return false;
	        }
	    }
	}


	public function view()
	{
		if($this->is_logined()){
			redirect("/user/profile");

		}else{
			$this->load->view('templates/header', array('navigation_bar' => $this->config->item('navigation_bar_visitor')));
			$this->load->view('home/view');
			$this->load->view('templates/footer');
		}
	}
}
