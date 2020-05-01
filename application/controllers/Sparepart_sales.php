<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sparepart_sales extends CI_Controller {
    private $dataAdmin;

    function __construct() {
        parent::__construct();

        if(!$this->session->auth) {
            redirect(base_url("auth/login"));
        }

        $this->load->model("user_model");
        $this->load->model("datatables");

        $this->dataAdmin = $this->user_model->get(["id" => $this->session->auth['id']])->row();
    }


	public function index()
	{

        $push = [
            "pageTitle" => "Riwayat Penjualan",
            "dataAdmin" => $this->dataAdmin 
        ];

		$this->load->view('header',$push);
		$this->load->view('sparepart_sales',$push);
		$this->load->view('footer',$push);
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
    
    public function json() {
        $this->datatables->setTable("transactions");
        $this->datatables->setWhere("type","sparepart");
        $this->datatables->setColumn([
            '<index>',
            '[reformat_date=<get-date>]',
            '[rupiah=<get-total>]',
            '<div class="text-center">
                <button type="button" class="btn btn-sm btn-warning btn-view" data-id="<get-id>" data-total="<get-total>"><i class="fa fa-eye"></i></button>
            </div>'
        ]);
        $this->datatables->setOrdering(["id","date","total",NULL]);
        $this->datatables->setSearchField("date");
        $this->datatables->generate();
    }
}
