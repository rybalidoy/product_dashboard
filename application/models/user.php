<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model {

    function get_user_by_email($email) {
        $query = 'SELECT * FROM users WHERE email=?';
        return $this->db->query($query,$this->security->xss_clean($email))->result_array()[0];
    }
    function get_user_by_id($id)
    { 
        $query = "SELECT * FROM users WHERE id=?";
        return $this->db->query($query, $this->security->xss_clean($id))->result_array()[0];
    }
    function create_user($user) {
        $query = 'INSERT INTO users(first_name,last_name,email,password,created_at,updated_at) 
                  VALUES(?,?,?,?,now(),now())';
        $values = array(
            $this->security->xss_clean($user['first_name']),
            $this->security->xss_clean($user['last_name']),
            $this->security->xss_clean($user['email_address']),
            md5($this->security->xss_clean($user['password']))
        );
        return $this->db->query($query,$values);
    }

    function update_user_level() {
        $query = 'UPDATE users SET user_level = 9 WHERE id = ?';
        return $this->db->query($query,1);
    }
    /** 
     *  This checks if all required fields were filled up
     */
    function validate_login_form() {
        
        $this->form_validation->set_error_delimiters('<p>','</p>');
        $this->form_validation->set_rules('email_address', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if(!$this->form_validation->run()) {
            return validation_errors();
        } 
        else {
            return "success";
        }
    }

    function validate_login_match($user, $password) {
        
        $hash_password = $this->security->xss_clean($password);
        $hash_password = md5($hash_password);
        if($user && $user['password'] == $hash_password) {
            return "success";
        }
        else {
            return "Incorrect email/password.";
        }
    }

    function validate_registration($email) {
        $this->form_validation->set_error_delimiters('<p>','</p>');
        $this->form_validation->set_rules('email_address','Email address','required|valid_email');
        $this->form_validation->set_rules('first_name','First name','required|min_length[3]');
        $this->form_validation->set_rules('last_name','Last name','required|min_length[3]');
        $this->form_validation->set_rules('password','Password','required|min_length[8]');
        $this->form_validation->set_rules('confirm_password','Password confirmation','required|matches[password]');

        if(!$this->form_validation->run()) {
            return validation_errors();
        }
        else if($this->get_user_by_email($email)) {
            return "Email already taken.";
        }
    }

    function update_profile($user) {
        $query = 'UPDATE users SET first_name=?, last_name=?, email_address=?,
                  password=?, updated_at=now() WHERE id = ?';
        $values = array(
            $this->security->xss_clean($user['first_name']),
            $this->security->xss_clean($user['last_name']),
            $this->security->xss_clean($user['email_address']),
            md5($this->security->xss_clean($user['password'])),
            $this->security->xss_clean($user['id'])
        );
        return $this->db->query($query,$values);
    }
    function validate_profile_password() {
        $this->form_validation->set_error_delimiters('<p>','</p>');
        $this->form_validation->set_rules('old_password','Old password','required');
        $this->form_validation->set_rules('new_password','New password','required|min_length[8]');
        $this->form_validation->set_rules('confirm_password','Password confirmation','required|matches[new_password]');
        
        if(!$this->form_validation->run()) {
            return validation_errors();
        }
    }
    function validate_profile_information() {
        $this->form_validation->set_rules('email_address','Email address','required|valid_email');
        $this->form_validation->set_rules('first_name','First name','required|min_length[3]');
        $this->form_validation->set_rules('last_name','Last name','required|min_length[3]');

        if(!$this->form_validation->run()) {
            return validation_errors();
        }
    }
    function update_profile_information($user_info) {
        $query = 'UPDATE users SET email = ?, first_name = ?, last_name = ?, updated_at = now()
                  WHERE id = ?';
        $values = array(
            $this->security->xss_clean($user_info['email_address']),
            $this->security->xss_clean($user_info['first_name']),
            $this->security->xss_clean($user_info['last_name']),
            $this->security->xss_clean($user_info['id'])
        );
        return $this->db->query($query,$values);
    }
    function update_profile_password($user_info) {
        $query = 'UPDATE users SET password=?, updated_at = now() WHERE id=?';
        $values = array(
            md5($this->security->xss_clean($user_info['new_password'])),
            $this->security->xss_clean($user_info['id'])
        );
        $this->db->query($query,$values);
    }
}
?>