<?php
class User extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->helper('url_helper');
		$this->config->load('navigation_bar');
		$this->load->config('email');
		$this->load->helper('string');
		$this->load->library('email');
		$this->load->library('session');
		$this->load->helper('email');
		$this->load->helper('url');
	}


	public function check_username($username)
	{
	    if (strlen($username) > 16 || strlen($username) < 6) {
	        // echo "username <= 16 chars >=6";
	        return false;
	    }
	    if(preg_match("/[\',.:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$username)){ 
	        // echo "请不要在用户名中包含符号 , 只有英文字母和数字是被允许的";
	        return false;
	    }
	    return true;
	}

	public function check_password($password)
	{
	    if (strlen($password) > 16 || strlen($password) < 6) {
	        // echo "password <= 16 chars >=6";
	        return false;
	    }
	    // because the password is hashed before insert to db, so the following check is not necessary
	    // if(preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$password)){ 
	    //     return false;
	    // }
	    return true;
	}

	public function check_college($college)
	{
	    if (strlen($college) > 64) {
	        return false;
	    }
	    return true;
	}

	public function check_email($email)
	{
		return valid_email($email);
	}

	public function verify_captcha($captcha)
	{
	    // First, delete old captchas
	    $expiration = time() - 7200; // Two hour limit
	    $this->db->where('captcha_time < ', $expiration)
	        ->delete('captcha');

	    // Then see if a captcha exists:
	    $sql = 'SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?';
	    $binds = array($captcha, $this->input->ip_address(), $expiration);
	    $query = $this->db->query($sql, $binds);
	    $row = $query->row();

	    if ($row->count > 0)
	    {
	    	return true;
	    }else{
	    	return false;
	    }
	}


	private function getEncryptedPassword($passord, $salt)
	{
	    return md5(md5($passord.$salt));
	}

	public function do_login($username, $password)
	{
		if($this->user_model->get_userID($username) == NULL){
			// user is not existed
			return false;
		}else {
			$userID = $this->user_model->get_userID($username);
			$current_password = $this->user_model->get_password($userID);
			$salt = $this->user_model->get_salt($userID);
	        return ($this->getEncryptedPassword($password, $salt) === $current_password);
		}
	}


	public function is_user_not_exist($username)
	{
	    $query = $this->db->get_where('users', array('username' => $username));
	    if ($query->num_rows() === 0){
	        return true;
	    }else{
	        return false;
	    }
	}

	public function send_active_code($active_code, $reciver_email)
	{
		$this->email->from('admin@sniperoj.cn', 'admin');
		$this->email->to($reciver_email);
		$this->email->subject('[No Reply] Sniper OJ Register Email');
		$this->email->message("Thank you for registering this website!\nyou can activate your account by visiting the following link, which is valid for 2 hours.\nYour active code : http://www.sniperoj.cn/user/active/".$active_code."\n");
		if($this->email->send()==1){ 
			return true;
		}else{ 
			return false;
		} 
	}

	public function do_register($username, $password, $email, $college)
	{
		$salt = random_string('alnum', 16);
		$time = time();
		$token_alive_time = $time + $this->config->item('sess_expiration');
		$token = md5($username.$time);

		$data = array(
			'username' => $username,
			'salt' => $salt,
			'password' => $this->getEncryptedPassword($password,$salt),
			'score' => 0,
			'college' => $college,
			'email' => $email,
			'registe_time' => time(),
			'registe_ip' => $this->input->ip_address(),
			'token' => $token,
			'token_alive_time' => $token_alive_time,
			'usertype' => 0,
			'verified' => 0,
		);
		if($this->db->insert('users', $data) && $this->send_active_code($token, $email)){
			return true;
		}else{
			return false;
		}
	}

	public function do_active($active_code)
	{
		// TODO create a table to save active_code
		if (strlen($active_code) < 0){
			return false;
		}

		$query = $this->db->get_where('users', array('token' => $active_code));

		$result_count = $query->result();
		if ($query->num_rows() === 1){
			// clear token , wait for user login
			$data = array(
			    'verified' => '1',
			    'token' => '',
			    // 'token_alive_time' => 0, // is it safe ??? 
			);
			$this->db->where('token', $active_code);
			$this->db->update('users', $data);
			return true;
		}else{
			return false;
		}
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

	// check whether the account is verified
	public function check_verified($username)
	{
		if($this->user_model->get_userID($username) == NULL){
			// user is not existed
			return false;
		}else {
			$userID = $this->user_model->get_userID($username);
			if ($this->user_model->get_verified($userID) === 1){
				return true;
			}else{
				return false;
			}
		}
	}


	public function login()
	{
		if($this->is_logined()){
			// login success
			$this->load->view('templates/header',  array('navigation_bar' => $this->config->item('navigation_bar_user')));
			$this->load->view('user/profile');
			$this->load->view('templates/footer');
		}else{
			$this->load->helper('form');
			$this->load->library('form_validation');

			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('captcha', 'Captcha', 'required');

			if ($this->form_validation->run() === FALSE)
			{
				// get form data failed
				$this->load->view('templates/header', array('navigation_bar' => $this->config->item('navigation_bar_visitor')));
				$this->load->view('user/login');
				$this->load->view('templates/footer');
			}
			else
			{
				// get form data success
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				$captcha = $this->input->post('captcha');
				$userID = $this->user_model->get_userID($username);
				$token_alive_time = $this->user_model->get_token_alive_time($userID);

				if ($this->verify_captcha($captcha)){
					// verify captcha success
					if ($this->check_username($username)){
						if ($this->check_password($password)){
							if($this->do_login($username, $password)){
								if($this->check_verified($username)){
									// login success
									// $this->load->view('templates/header',  array('navigation_bar' => $this->config->item('navigation_bar_user')));
									// $this->load->view('notice/view', array('message' => 'Login success'));
									// $this->load->view('user/profile');
									// $this->load->view('templates/footer');
									// set session
									$this->user_model->set_session($username);
									// update db token_alive_time
									$this->user_model->set_token_alive_time($userID, $token_alive_time + $this->config->item('sess_expiration'));
									redirect("/challenges/view");
								}else{
									// Account have not verified
									$this->load->view('templates/header', array('navigation_bar' => $this->config->item('navigation_bar_visitor')));
									$this->load->view('notice/view', array('message' => 'Account have not verified!'));
									$this->load->view('user/login');
									$this->load->view('templates/footer');
								}
							}else{
								// login failed, must be password error!
								$this->load->view('templates/header', array('navigation_bar' => $this->config->item('navigation_bar_visitor')));
								$this->load->view('notice/view', array('message' => 'Login failed!'));
								$this->load->view('user/login');
								$this->load->view('templates/footer');
							}
						}else{
							// password illegal
							$this->load->view('templates/header', array('navigation_bar' => $this->config->item('navigation_bar_visitor')));
							$this->load->view('notice/view', array('message' => 'Password illegal!'));
							$this->load->view('user/login');
							$this->load->view('templates/footer');
						}
					}else{
						// username illegal
						$this->load->view('templates/header', array('navigation_bar' => $this->config->item('navigation_bar_visitor')));
						$this->load->view('notice/view', array('message' => 'Username illegal!'));
						$this->load->view('user/login');
						$this->load->view('templates/footer');
					}
				}else{
					// verify captcha failed
					$this->load->view('templates/header', array('navigation_bar' => $this->config->item('navigation_bar_visitor')));
						$this->load->view('notice/view', array('message' => 'Captcha error!'));
					$this->load->view('user/login');
					$this->load->view('templates/footer');
				}
			}
		}
	}



	public function register()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('email', 'Email', 'valid_email');
		$this->form_validation->set_rules('captcha', 'Captcha', 'required');


		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('templates/header', array('navigation_bar' => $this->config->item('navigation_bar_visitor')));
			$this->load->view('user/register');
			$this->load->view('templates/footer');
		}
		else
		{
			// get form data success
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$email = $this->input->post('email');
			$college = $this->input->post('college');
			$captcha = $this->input->post('captcha');

			if ($this->verify_captcha($captcha)){
				// verify captcha success
				if ($this->check_username($username)){
					if ($this->check_password($password)){
						if ($this->check_college($college)){
							if ($this->check_email($email)){
								if ($this->is_user_not_exist($username)){
									if($this->do_register($username, $password, $email, $college)){
										// register success
										$this->load->view('templates/header', array('navigation_bar' => $this->config->item('navigation_bar_visitor')));
										$this->load->view('notice/view', array('message' => 'Register success! Please check your mailbox to verify your account!'));
										$this->load->view('user/login'); // jump to login or profile ?
										$this->load->view('templates/footer');
									}else{
										// register failed
										$this->load->view('templates/header', array('navigation_bar' => $this->config->item('navigation_bar_visitor')));
										$this->load->view('notice/view', array('message' => 'Register failed! Please contact : admin@sniperoj.cn'));
										$this->load->view('user/register');
										$this->load->view('templates/footer');
									}
								}else{
									// User existed!
									$this->load->view('templates/header', array('navigation_bar' => $this->config->item('navigation_bar_visitor')));
									$this->load->view('notice/view', array('message' => 'User existed!'));
									$this->load->view('user/register');
									$this->load->view('templates/footer');
								}
							}else{
								// Email illegal
								$this->load->view('templates/header', array('navigation_bar' => $this->config->item('navigation_bar_visitor')));
								$this->load->view('notice/view', array('message' => 'Email illegal!'));
								$this->load->view('user/register');
								$this->load->view('templates/footer');
							}
						}else{
							// College illegal
							$this->load->view('templates/header', array('navigation_bar' => $this->config->item('navigation_bar_visitor')));
							$this->load->view('notice/view', array('message' => 'College length < 64!'));
							$this->load->view('user/register');
							$this->load->view('templates/footer');
						}
					}else{
						// password illegal
						$this->load->view('templates/header', array('navigation_bar' => $this->config->item('navigation_bar_visitor')));
						$this->load->view('notice/view', array('message' => 'Password illegal!'));
						$this->load->view('user/register');
						$this->load->view('templates/footer');
					}
				}else{
					// username illegal
					$this->load->view('templates/header', array('navigation_bar' => $this->config->item('navigation_bar_visitor')));
					$this->load->view('notice/view', array('message' => 'Username illegal!'));
					$this->load->view('user/register');
					$this->load->view('templates/footer');
				}
			}else{
				// verify captcha failed
				$this->load->view('templates/header', array('navigation_bar' => $this->config->item('navigation_bar_visitor')));
					$this->load->view('notice/view', array('message' => 'Captcha error!'));
				$this->load->view('user/register');
				$this->load->view('templates/footer');
			}
		}
	}

	public function active()
	{
		// ??? safe ???
		$active_code = $this->uri->segment(3);

		if($this->do_active($active_code)){
			// active success
			$this->load->view('templates/header', array('navigation_bar' => $this->config->item('navigation_bar_visitor')));
			$this->load->view('notice/view', array('message' => 'Active success'));
			$this->load->view('user/login');
			$this->load->view('templates/footer');
		}else{
			// active failed
			$this->load->view('templates/header', array('navigation_bar' => $this->config->item('navigation_bar_visitor')));
			$this->load->view('notice/view', array('message' => 'Active failed'));
			$this->load->view('user/login');
			$this->load->view('templates/footer');
		}
	}

	public function profile()
	{
		if($this->is_logined()){
			$this->load->view('templates/header', array('navigation_bar' => $this->config->item('navigation_bar_user')));
			$this->load->view('user/profile');
			$this->load->view('templates/footer');
		}else{
			$this->session->sess_destroy();
			redirect("/");
		}
	}

	public function score()
	{
		if($this->is_logined()){
			$this->load->view('templates/header', array('navigation_bar' => $this->config->item('navigation_bar_user')));
			$this->load->view('user/score');
			$this->load->view('templates/footer');
		}else{
			$this->session->sess_destroy();
			redirect("/");
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect("/");
	}

}
