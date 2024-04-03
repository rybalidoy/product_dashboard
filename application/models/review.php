<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review extends CI_Model {

    function get_reviews_of_product($product_id) {
        $query = 'SELECT reviews.id as review_id, message, reviews.created_at as review_date,
                  CONCAT(first_name," ",last_name) as user_name FROM reviews
                  LEFT JOIN products on reviews.products_id = products.id
                  LEFT JOIN users on reviews.users_id = users.id
                  WHERE reviews.products_id = ?
                  ORDER BY reviews.created_at DESC';
        return $this->db->query($query,$product_id)->result_array();
    }
    public function validate_review() {
        $this->form_validation->set_error_delimiters('<div>','</div>');
        $this->form_validation->set_rules('review_input', 'Review', 'required');

        if(!$this->form_validation->run()) 
        {
            return validation_errors();
        }
        else {
            return 'success';
        }
    }
    public function add_review($post) {
        $query = 'INSERT INTO reviews(products_id,users_id,message,created_at,updated_at)
                  VALUES(?,?,?,now(),now())';
        $values = array(
            $this->security->xss_clean($post['product_id']),
            $this->security->xss_clean($this->session->userdata('user_id')),
            $this->security->xss_clean($post['review_input'])
        );
        return $this->db->query($query,$values);
    }
    public function remove_review($product_id) {
        return $this->db->query('DELETE FROM reviews WHERE product_id = ?',$product_id);
    }
    public function get_time_diff($date) {
        $day = $this->db->query('SELECT DATEDIFF(?, now()) as time',$date)->row_array()['time'];
        $hour = $this->db->query('SELECT HOUR(TIMEDIFF(?, now())) as time',$date)->row_array()['time'];
        $min = $this->db->query('SELECT MINUTE(TIMEDIFF(?, now())) as time',$date)->row_array()['time'];
        $seconds = $this->db->query('SELECT SECOND(TIMEDIFF(?, now())) as time',$date)->row_array()['time'];
        
        if($day > 7)
        {
            return $date;
        }
        else if($day >= 1 && $day <= 7 )
        {
            if($day == 1)
            {
                return $day . " day ago";
            }
            else
            {
                return $day . " days ago";
            }
        }
        else if($hour >= 1 && $hour <= 24)
        {
            if($hour == 1)
            {  
                return $hour . " hour ago";
            }
            else
            {
                return $hour . " hours ago";
            }  
        }
        else if($min >= 1 && $min <= 60)
        {
            if($min == 1)
            {
                return $min . " minute ago";
            } 
            else
            {
                return $min . " minutes ago";
            }
        }
        else if($seconds >= 1 && $seconds <= 60)
        {
            if($seconds == 1)
            { 
                return $seconds . " second ago";
            }
            else
            {
                return $seconds . " seconds ago";
            }
        }
        
    }
}
?>