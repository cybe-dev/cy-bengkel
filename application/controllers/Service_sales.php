<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_sales extends CI_Controller {
    private $dataAdmin;

    function __construct() {
        parent::__construct();

        if(!$this->session->auth) {
            redirect(base_url("auth/login"));
        }

        $this->load->model("user_model");
        $this->load->model("datatables");
        $this->load->model("transaction_model");

        $this->dataAdmin = $this->user_model->get(["id" => $this->session->auth['id']])->row();
    }


	public function index()
	{

        $push = [
            "pageTitle" => "Riwayat Service",
            "dataAdmin" => $this->dataAdmin 
        ];

		$this->load->view('header',$push);
		$this->load->view('service_sales',$push);
		$this->load->view('footer',$push);
    }

    public function print($id = 0) {
        $query = $this->transaction_model->get($id);
        if($query->num_rows() > 0) {
            $push["fetch"] = $query->row();
            $push["details"] = $this->transaction_model->get_details($id)->result();

            $title = "Invoice";

            $this->load->library("pdf");

            $this->pdf->setPaper('A4', 'portrait');
            $this->pdf->filename = $title;

            $this->pdf->load_view("service_sales_pdf",$push);
        }
    }
    
    public function json() {
        $this->datatables->setTable("transactions");
        $this->datatables->setWhere("type","service");
        $this->datatables->setColumn([
            '<index>',
            '[reformat_date=<get-date>]',
            '<get-customer>',
            '<get-plat>',
            '[rupiah=<get-total>]',
            '<div class="text-center">
                <button type="button" class="btn btn-sm btn-warning btn-view" data-id="<get-id>" data-total="<get-total>"><i class="fa fa-eye"></i></button>
                <a href="[base_url=service_sales/print/<get-id>]" class="btn btn-sm btn-primary"><i class="fa fa-print"></i></a>
            </div>'
        ]);
        $this->datatables->setOrdering(["id","date","customer","plat","total",NULL]);
        $this->datatables->setSearchField("date");
        $this->datatables->generate();
    }

    public function json_details($id = 0) {
        $this->datatables->setTable("details");
        $this->datatables->setWhere("transaction_id",$id);
        $this->datatables->setColumn([
            '<index>',
            '<get-name>',
            '[rupiah=<get-price>]',
            '<get-qty>',
            '[math=<get-qty> * <get-price>]'
        ]);
        $this->datatables->setOrdering(["id","name","price",NULL]);
        $this->datatables->setSearchField("name");
        $this->datatables->generate();
    }
}
