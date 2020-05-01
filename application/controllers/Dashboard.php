<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    private $dataAdmin;

    function __construct() {
        parent::__construct();

        if(!$this->session->auth) {
            redirect(base_url("auth/login"));
        }

        $this->load->model("user_model");
        $this->load->model("report_model");

        $this->dataAdmin = $this->user_model->get(["id" => $this->session->auth['id']])->row();
    }


	public function index()
	{

        $push = [
            "pageTitle" => "Dashboard",
            "dataAdmin" => $this->dataAdmin,
            "today_income" => $this->report_model->get_today_income(),
            "today_service" => $this->report_model->get_today_transaction("service"),
            "today_items_sold" => $this->report_model->get_today_transaction("sparepart"),
            "items_sold_out" => $this->report_model->get_sold_out()
        ];

        $now = date("m");

        $before = $now - 5;

        $arrayTitle = [];
        $arrayNumber = [];
        $arrayValueSparepart = [];
        $arrayValueService = [];

        $month = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];

        for($i = $before;$i <= $now;$i++) {
            if($i <= 0) {
                $temp = 12 + $i;
                $arrayTitle[] = '"'.$month[$temp - 1]." ".(date("Y") - 1).'"';
            } else {
                $temp = $i;
                $arrayTitle[] = '"'.$month[$temp - 1]." ".date("Y").'"';
            }
            $arrayNumber[] = str_pad($temp,2,0,STR_PAD_LEFT);
            $arrayValueSparepart[] = 0;
            $arrayValueService[] = 0;
        }

        $data1 = $this->report_model->get_graph($arrayNumber)->result();
        $data2 = $this->report_model->get_graph($arrayNumber,"service")->result();

        foreach($data1 as $row) {
            $key = array_search(str_pad($row->date,2,0,STR_PAD_LEFT),$arrayNumber);
            $arrayValueSparepart[$key] = $row->total;
        }
        foreach($data2 as $row) {
            $key = array_search(str_pad($row->date,2,0,STR_PAD_LEFT),$arrayNumber);
            $arrayValueService[$key] = $row->total;
        }

        $push["title"] = $arrayTitle;
        $push["valueService"] = $arrayValueService;
        $push["valueSparepart"] = $arrayValueSparepart;

		$this->load->view('header',$push);
		$this->load->view('dashboard',$push);
		$this->load->view('footer',$push);
    }
    
}
