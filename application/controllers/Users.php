<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function index() {
        $this->output->enable_profiler(TRUE);
        $current_user_id = $this->session->userdata('user_id');

        if(!$current_user_id) {
            $this->load->view('users/login');
        }
        else { // If user exists then redirect to main page (dashboard)
            redirect('dashboard');
        }
    }
    
    public function login() {
        $this->output->enable_profiler(TRUE);
        $current_user_id = $this->session->userdata('user_id');

        if(!$current_user_id) {
            $this->load->view('users/login');
        }
        else {
            redirect('dashboard');
        }
    }
    public function register() {
        $current_user_id = $this->session->userdata('user_id');
        
        if(!$current_user_id) { 
            $this->load->view('users/register');
        }  
        else {
            redirect('dashboard');
        }
    }
    public function logout() {
        $this->session->sess_destroy();
        redirect('/');
    }

    public function process_login() {
        $this->output->enable_profiler(TRUE);
        $result = $this->user->validate_login_form();
        
        if($result != 'success') {
            $this->session->set_flashdata('input_errors',$result);
            redirect('login');
        }
        else {
            $email = $this->input->post('email_address',true);
            $user = $this->user->get_user_by_email($email);

            $result = $this->user->validate_login_match($user,$this->input->post('password',true));

            if($result == 'success') {
                $this->session->set_userdata(array(
                    'user_id' => $user['id'],
                    'first_name' => $user['first_name'],
                    'user_level' => $user['user_level']
                ));
                redirect('dashboard');
            }
            else {
                $this->session->set_flashdata('input_errors',$result);
                redirect('login');
            }
        }
    }

    public function process_registration() {
        
        $email = $this->input->post('email_address',true);
        $result = $this->user->validate_registration($email);

        if($result != null) {
            $this->session->set_flashdata('input_errors',$result);
            redirect('register');
        }
        else {
            $form_data = $this->input->post(null,true);
            $this->user->create_user($form_data);
            var_dump($form_data);
            $new_user = $this->user->get_user_by_email($form_data['email_address']);

            /**
             *  Set first user to be an admin
             */
            if($new_user['id'] == 1) {
                $this->user->update_user_level();
            }
            $this->session->set_userdata(array(
                'user_id' => $new_user['id'],
                'first_name' => $new_user['first_name']
            ));
            redirect('dashboard');
        }
    }

    /**
     *  Profile 
     */
    public function profile() {
        $current_user_id = $this->session->userdata('user_id');
        if(!$current_user_id) {
            $this->load->view('users/login');
        }
        else {
            $user_data['user_data'] = $this->user->get_user_by_id($current_user_id);
            $this->load->view('users/profile',$user_data);
        }
    }
    public function edit_profile() {
        $result = $this->user->validate_edit_form();

        if($result != null) {
            $this->session->set_flashdata('input_errors',$result);
            redirect('profile');
        }
        else {
            //refractor to only change either the password or the userdata
            $form_data = $this->input->post(null,true);
            $form_data['id'] = $this->session->userdata('user_id');
            $user = $this->user->get_user_by_id($form_data['id']);

            if($user['password'] == md5($form_data['password'])) {
                $result = $this->user->update_profile($form_data);
                $this->session->set_userdata(array(
                    'user_id' => $form_data['id'],
                    'first_name' => $form_data['first_name']
                ));
                redirect('/');
            }
        }
    }
    public function edit_information() {
        $result = $this->user->validate_profile_information();

        if($result != null) {
            $this->session->set_flashdata('input_errors',$result);
            redirect('profile');
        }
        else {
            $form_data = $this->input->post(null,true);
            $form_data['id'] = $this->session->userdata('user_id');
            $result = $this->user->update_profile_information($form_data);
            $this->session->set_userdata(array(
                'user_id' => $form_data['id'],
                'first_name' => $form_data['first_name']
            ));
            redirect('/');
        }
    }
    public function change_password() {
        $result = $this->user->validate_profile_password();

        if($result != null) {
            $this->session->set_flashdata('input_errors',$result);
            redirect('profile');
        }
        else {
            $form_data = $this->input->post(null,true);
            $form_data['id'] = $this->session->userdata('user_id');
            $user = $this->user->get_user_by_id($form_data['id']);
            
            if($user['password'] == md5($form_data['old_password'])) {
                $result = $this->user->update_profile_password($form_data);
                $this->session->set_userdata(array(
                    'user_id' => $form_data['id'],
                ));
                
            }
            redirect('/');
        }
    }
}   
?>