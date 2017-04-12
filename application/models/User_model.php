<?php
class User_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    /* get functions */

    public function get_userID($username)
    {
        $query = $this->db->get_where('users', array('username' => $username));
        $result = $query->row_array();
        return intval($result['userID']);
    }

    public function get_username($userID)
    {
        $query = $this->db->get_where('users', array('userID' => $userID));
        $result = $query->row_array();
        return $result['username'];
    }

    public function get_password($userID)
    {
        $query = $this->db->get_where('users', array('userID' => $userID));
        $result = $query->row_array();
        return $result['password'];
    }

    public function get_score($userID)
    {
        $query = $this->db->get_where('users', array('userID' => $userID));
        $result = $query->row_array();
        return intval($result['score']);
    }

    public function get_college($userID)
    {
        $query = $this->db->get_where('users', array('userID' => $userID));
        $result = $query->row_array();
        return $result['college'];
    }

    public function get_email($userID)
    {
        $query = $this->db->get_where('users', array('userID' => $userID));
        $result = $query->row_array();
        return $result['email'];
    }

    public function get_registe_time($userID)
    {
        $query = $this->db->get_where('users', array('userID' => $userID));
        $result = $query->row_array();
        return intval($result['registe_time']);
    }

    public function get_registe_time_human($userID)
    {
        return date("Y-m-d h:i:sa", $this->get_registe_time($userID));
    }

    public function get_registe_ip($userID)
    {
        $query = $this->db->get_where('users', array('userID' => $userID));
        $result = $query->row_array();
        return $result['registe_ip'];
    }

    public function get_salt($userID)
    {
        $query = $this->db->get_where('users', array('userID' => $userID));
        $result = $query->row_array();
        return $result['salt'];
    }

    public function get_token($userID)
    {
        $query = $this->db->get_where('users', array('userID' => $userID));
        $result = $query->row_array();
        return $result['token'];
    }

    public function get_token_alive_time($userID)
    {
        $query = $this->db->get_where('users', array('userID' => $userID));
        $result = $query->row_array();
        return intval($result['token_alive_time']);
    }

    public function get_verified($userID)
    {
        $query = $this->db->get_where('users', array('userID' => $userID));
        $result = $query->row_array();
        return intval($result['verified']);
    }    

    public function get_usertype($userID)
    {
        $query = $this->db->get_where('users', array('userID' => $userID));
        $result = $query->row_array();
        return intval($result['usertype']);
    }

    /* set functions */

    public function set_username($userID, $username)
    {
        $this->db->set(array('username' => $username));
        $this->db->where('userID', $userID);
        $this->db->update('users');
    }

    public function set_password($userID, $password)
    {
        $this->db->set(array('password' => $password));
        $this->db->where('userID', $userID);
        $this->db->update('users');
    }

    public function set_score($userID, $score)
    {
        $this->db->set(array('score' => intval($score)));
        $this->db->where('userID', $userID);
        $this->db->update('users');
    }

    public function set_college($userID, $college)
    {
        $this->db->set(array('college' => $college));
        $this->db->where('userID', $userID);
        $this->db->update('users');
    }

    public function set_email($userID, $email)
    {
        $this->db->set(array('email' => $email));
        $this->db->where('userID', $userID);
        $this->db->update('users');
    }

    public function set_registe_time($userID, $registe_time)
    {
        $this->db->set(array('registe_time' => intval($registe_time)));
        $this->db->where('userID', $userID);
        $this->db->update('users');
    }

    public function set_registe_ip($userID, $registe_ip)
    {
        $this->db->set(array('registe_ip' => $registe_ip));
        $this->db->where('userID', $userID);
        $this->db->update('users');
    }

    public function set_salt($userID, $salt)
    {
        $this->db->set(array('salt' => $salt));
        $this->db->where('userID', $userID);
        $this->db->update('users');
    }

    public function set_token($userID, $token)
    {
        $this->db->set(array('token' => $token));
        $this->db->where('userID', $userID);
        $this->db->update('users');
    }

    public function set_token_alive_time($userID, $token_alive_time)
    {
        $this->db->set(array('token_alive_time' => intval($token_alive_time)));
        $this->db->where('userID', $userID);
        $this->db->update('users');
    }

    public function set_verified($userID, $verified)
    {
        $this->db->set(array('verified' => intval($verified)));
        $this->db->where('userID', $userID);
        $this->db->update('users');
    }

    public function set_usertype($userID, $usertype)
    {
        $this->db->set(array('usertype' => intval($usertype)));
        $this->db->where('userID', $userID);
        $this->db->update('users');
    }

    // set session

    public function set_session($username)
    {
        // get userID
        $userID = $this->get_userID($username);
        // set session
        $data = array(
            'userID' => $userID,
            'username' => $this->get_username($userID),
            'email' => $this->get_email($userID),
            'score' => $this->get_score($userID),
            'college' => $this->get_college($userID),
            'token' => $this->get_token($userID),
            'token_alive_time' => ($this->get_token_alive_time($userID) + $this->config->item('sess_expiration')),
            'usertype' => $this->get_usertype($userID),
        );
        $this->session->set_userdata($data);
    }


    // get_user_data($userID)
    public function get_user_data($userID)
    {
        $user_data = array(
            'userID' => $userID, 
            'username' => $this->get_username($userID), 
            'score' => $this->get_score($userID), 
            'college' => $this->get_college($userID), 
            'email' => $this->get_email($userID), 
            'registe_time' => $this->get_registe_time_human($userID), 
            'registe_ip' => $this->get_registe_ip($userID), 
        );
        return $user_data;
    }

    public function get_user_submit_log($userID){
        $query = $this->db->select(array('challengeID','flag','submit_time','is_current'))
        ->order_by('submit_time','desc')
        ->get('submit_log');
        $result = $query->result_array();
        return $result;
    }

    // get_all_score
    public function get_all_score()
    {
        $query = $this->db->select(array('username','college','score',))
                ->order_by('score','desc')
                ->get('users');
        $result = $query->result_array();
        return $result;
    }

}
