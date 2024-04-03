<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    //Base shit from Wallbug wall
    //Registration and login is working
    public function index() {
        $current_user_id = $this->session->userdata('user_id');
        $user_level = $this->session->userdata('user_level');
        if(!$current_user_id) {
            $this->load->view('users/login');
        }
        else if($user_level == 9) {
            $id = $this->session->userdata('user_id');
            $this->session->set_flashdata('is_admin',true);
            redirect('dashboard/admin');
        }
        else {
            $view_data['products_list'] = $this->product->get_all_products();
            $this->load->view('dashboard/dashboard',$view_data);
        }
    }
    public function admin() {
        $view_data['products_list'] = $this->product->get_all_products();
        $this->session->set_flashdata('is_admin',true);
        $this->load->view('dashboard/admin',$view_data);
    }
}
?>