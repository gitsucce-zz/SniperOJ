<?php
class Challenges_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    /* get functions */

    public function get_challenge_name($challengeID)
    {
        $query = $this->db->get_where('challenges', array('challengeID' => $challengeID));
        $result = $query->row_array();
        return $result['name'];
    }

    public function get_description($challengeID)
    {
        $query = $this->db->get_where('challenges', array('challengeID' => $challengeID));
        $result = $query->row_array();
        return $result['description'];
    }

    public function get_flag($challengeID)
    {
        $query = $this->db->get_where('challenges', array('challengeID' => $challengeID));
        $result = $query->row_array();
        return $result['flag'];
    }

    public function get_name($challengeID)
    {
        $query = $this->db->get_where('challenges', array('challengeID' => $challengeID));
        $result = $query->row_array();
        return $result['name'];
    }

    public function get_score($challengeID)
    {
        $query = $this->db->get_where('challenges', array('challengeID' => $challengeID));
        $result = $query->row_array();
        return $result['score'];
    }

    public function get_type($challengeID)
    {
        $query = $this->db->get_where('challenges', array('challengeID' => $challengeID));
        $result = $query->row_array();
        return $result['type'];
    }

    public function get_online_time($challengeID)
    {
        $query = $this->db->get_where('challenges', array('challengeID' => $challengeID));
        $result = $query->row_array();
        return $result['online_time'];
    }

    public function get_visit_times($challengeID)
    {
        $query = $this->db->get_where('challenges', array('challengeID' => $challengeID));
        $result = $query->row_array();
        return $result['visit_times'];
    }

    public function get_fixing($challengeID)
    {
        $query = $this->db->get_where('challenges', array('challengeID' => $challengeID));
        $result = $query->row_array();
        return $result['fixing'];
    }

    public function get_resource($challengeID)
    {
        $query = $this->db->get_where('challenges', array('challengeID' => $challengeID));
        $result = $query->row_array();
        return $result['resource'];
    }

    public function get_document($challengeID)
    {
        $query = $this->db->get_where('challenges', array('challengeID' => $challengeID));
        $result = $query->row_array();
        return $result['document'];
    }


    /* set functions */

    public function set_name($challengeID, $name)
    {
        $this->db->set(array('name' => $name));
        $this->db->where('challengeID', $challengeID);
        $this->db->update('challenges');
    }

    public function set_description($challengeID, $description)
    {
        $this->db->set(array('description' => $description));
        $this->db->where('challengeID', $challengeID);
        $this->db->update('challenges');
    }

    public function set_flag($challengeID, $flag)
    {
        $this->db->set(array('flag' => $flag));
        $this->db->where('challengeID', $challengeID);
        $this->db->update('challenges');
    }

    public function set_score($challengeID, $score)
    {
        $this->db->set(array('score' => $score));
        $this->db->where('challengeID', $challengeID);
        $this->db->update('challenges');
    }

    public function set_type($challengeID, $type)
    {
        $this->db->set(array('type' => $type));
        $this->db->where('challengeID', $challengeID);
        $this->db->update('challenges');
    }

    public function set_online_time($challengeID, $online_time)
    {
        $this->db->set(array('online_time' => $online_time));
        $this->db->where('challengeID', $challengeID);
        $this->db->update('challenges');
    }

    public function set_visit_times($challengeID, $visit_times)
    {
        $this->db->set(array('visit_times' => $visit_times));
        $this->db->where('challengeID', $challengeID);
        $this->db->update('challenges');
    }

    public function set_fixing($challengeID, $fixing)
    {
        $this->db->set(array('fixing' => $fixing));
        $this->db->where('challengeID', $challengeID);
        $this->db->update('challenges');
    }

    public function set_resource($challengeID, $resource)
    {
        $this->db->set(array('resource' => $resource));
        $this->db->where('challengeID', $challengeID);
        $this->db->update('challenges');
    }

    public function set_document($challengeID, $document)
    {
        $this->db->set(array('document' => $document));
        $this->db->where('challengeID', $challengeID);
        $this->db->update('challenges');
    }

    /* advance function */
    public function get_all_challenges()
    {
        $query = $this->db->get("challenges");
        return $query->result_array();
    }
}
