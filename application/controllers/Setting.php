<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {
    private $dataAdmin;

    function __construct() {
        parent::__construct();

        if(!$this->session->auth) {
            redirect(base_url("auth/login"));
        }

        $this->load->model("user_model");

        $this->dataAdmin = $this->user_model->get(["id" => $this->session->auth['id']])->row();
    }


	public function shop_info()
	{

        $push = [
            "pageTitle" => "Pengaturan",
            "dataAdmin" => $this->dataAdmin
        ];

        $this->load->view('header',$push);
		$this->load->view('setting',$push);
        $this->load->view('footer',$push);
    }
	public function change_password()
	{

        $push = [
            "pageTitle" => "Ganti Password",
            "dataAdmin" => $this->dataAdmin
        ];

        $this->load->view('header',$push);
		$this->load->view('change_password',$push);
        $this->load->view('footer',$push);
    }

    public function save_info() {
        $name = $this->input->post("name");
        $address = $this->input->post("address");

        if($name and $address) {
            $config['upload_path']          = '././img/';
            $config['allowed_types']        = 'jpeg|jpg|png';
            $config['max_size']             = 2048;
            $config['file_name']            = "logo.png";
            $config['overwrite']            = TRUE;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('userfile'))
            {
            }

            $response = [
                "status" => TRUE,
                "msg" => "Info bengkel telah diperbaharui"
            ];

            $this->user_model->set_shop(["name" => $name,"address" => $address]);
        } else {
            $response = [
                "status" => FALSE,
                "msg" => "Periksa kembali data anda"
            ];
        }

        echo json_encode($response);
    }

    function save_password() {
        $oldpw = $this->input->post("oldpw");
        $newpw1 = $this->input->post("newpw1");
        $newpw2 = $this->input->post("newpw2");

        if(!password_verify($oldpw,$this->dataAdmin->password)) {
            $response = [
                "status" => FALSE,
                "msg" => "Password lama yang anda masukkan salah"
            ];
        } else {
            if(!$newpw1 AND !$newpw2) {
                $response = [
                    "status" => FALSE,
                    "msg" => "Masukkan password baru"
                ];
            } else {
                if($newpw1 != $newpw2) {
                    $response = [
                        "status" => FALSE,
                        "msg" => "Ulangi password baru dengan benar"
                    ];
                } else {
                    $response = [
                        "status" => TRUE,
                        "msg" => "Password telah diganti"
                    ];

                    $this->user_model->set_user($this->dataAdmin->id,["password" => password_hash($newpw1,PASSWORD_BCRYPT)]);
                }
            }
        }

        echo json_encode($response);
    }
}
?>