<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reply extends CI_Model {
    
    function get_all_replies_of_review($review_id) {
        $query = 'SELECT replies.id as reply_id, reply, replies.created_at as reply_date,
                  CONCAT(first_name," ",last_name) as user_name FROM replies
                  LEFT JOIN reviews on replies.review_id = reviews.id
                  LEFT JOIN users on replies.users_id = users.id
                  WHERE replies.review_id = ?
                  ORDER BY replies.created_at ASC';
        return $this->db->query($query,$review_id)->result_array();
    }
    
    public function validate_reply() 
    {
        $this->form_validation->set_error_delimiters('<div>','</div>');
        $this->form_validation->set_rules('reply_message', 'Message', 'required');
        if(!$this->form_validation->run()) {
            return validation_errors();
        } 
        else 
        {
            return "success";
        }
    }
    public function add_reply($post) {
        $query = 'INSERT INTO replies(users_id,review_id,reply,created_at,updated_at)
                  VALUES(?,?,?,now(),now())';
        $values = array(
            $this->security->xss_clean($this->session->userdata('user_id')),
            $this->security->xss_clean($post['review_id']),
            $this->security->xss_clean($post['reply_message'])
        );
        return $this->db->query($query,$values);
    }
    public function remove_reply($review_id) {
        return $this->db->query('DELETE FROM replies WHERE review_id = ?',$review_id);
    }
}
?>