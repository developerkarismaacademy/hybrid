<?php

class Authentication extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

    }

    public function login()
    {
        if ($this->session->userdata('instruktur')) {
            redirect('back-v2');
        }
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE) {
            return $this->load->view('back-v2/auth/login');
        } else {
            $email = $this->input->post('email');
            $password = crypt(crypt($this->input->post('password'), garem), garem);

            $user = $this->db->get_where('user', ['email_user' => $email, 'password' => $password])->row();
            if ($user) {
                if ($user->level_user == 'instruktur') {
                    $this->session->set_userdata('instruktur', $user);
                    $this->session->set_flashdata('success', 'Login berhasil !');
                    return redirect('back-v2/');
                } else {
                    $this->session->set_flashdata('error', 'Username atau password salah !');
                    return redirect('back-v2/login');
                }
            } else {
                $this->session->set_flashdata('error', 'Username atau password salah');
                return redirect('back-v2/login');
            }
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('instruktur');
        $this->session->set_flashdata('success', 'Logout successfully !');
        return redirect('back-v2/login');
    }
}
