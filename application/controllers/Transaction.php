<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends CI_Controller {
    private $dataAdmin;

    function __construct() {
        parent::__construct();

        if(!$this->session->auth) {
            redirect(base_url("auth/login"));
        }

        $this->load->model("user_model");
        $this->load->model("transaction_model");

        $this->dataAdmin = $this->user_model->get(["id" => $this->session->auth['id']])->row();
    }


	public function index()
	{

        $push = [
            "pageTitle" => "Transaksi",
            "dataAdmin" => $this->dataAdmin 
        ];

		$this->load->view('header',$push);
		$this->load->view('transaction',$push);
		$this->load->view('footer',$push);
    }

    function insert($action = "sparepart") {
        $data = json_decode($this->input->raw_input_stream,TRUE);

        $customer = NULL;
        $plat = NULL;

        if($action == "service") {
            $customer = $data['customer'];
            $plat = $data['plat'];
        }
        
        $push = [
            "id" => NULL,
            "type" => $action,
            "total" => $data['total'],
            "date" => date("Y-m-d H:i:s"),
            "customer" => $customer,
            "plat" => $plat
        ];

        $transaction_id = $this->transaction_model->create($push);

        $sparepart_batch = [];
        $service_batch = [];
        $stock_batch = [];

        foreach($data['sparepart'] as $itemSp) {
            $temp = array();

            $temp["id"] = NULL;
            $temp["transaction_id"] = $transaction_id;
            $temp["product_id"] = $itemSp["id"];
            $temp["name"] = $itemSp["name"];
            $temp["price"] = $itemSp["price"];
            $temp["qty"] = $itemSp["qty"];

            $stocktmp = array();
            $stocktmp["id"] = $itemSp["id"];
            $stocktmp["stock"] = $itemSp["stock"] - $itemSp["qty"];

            $sparepart_batch[] = $temp;
            $stock_batch[] = $stocktmp;
        }

        if($action == "service") {
            foreach($data['service'] as $itemSrv) {
                $temp = array();
                $temp["id"] = NULL;
                $temp["transaction_id"] = $transaction_id;
                $temp["product_id"] = $itemSrv["id"];
                $temp["name"] = $itemSrv["name"];
                $temp["price"] = $itemSrv["price"];
                $temp["qty"] = $itemSrv["qty"];

                $service_batch[] = $temp;
            }
        }


        if($sparepart_batch) {
            $this->transaction_model->post_details($sparepart_batch);
            $this->transaction_model->sparepart_update($stock_batch);
        }

        if($service_batch) {
            $this->transaction_model->post_details($service_batch);
        }

        $response = [
            "status" => TRUE,
            "type" => $action,
            "msg" => "Transaksi sukses",
            "id" => $transaction_id
        ];

        echo json_encode($response);
    }
    
    public function json_service() {
        $addFunc = "addServiceCart({id:<get-id>,name:'<get-name>',price:<get-price>})";

        $this->load->model("datatables");
        $this->datatables->setTable("products");
        $this->datatables->setColumn([
            '<get-name>',
            '[rupiah=<get-price>]',
            '<div class="text-center">
                <button type="button" class="btn btn-sm btn-success btn-add" onclick="'.$addFunc.'"><i class="fa fa-plus"></i></button>
            </div>'
        ]);
        $this->datatables->setOrdering(["name","price",NULL]);
        $this->datatables->setWhere("type","service");
        $this->datatables->setSearchField("name");
        $this->datatables->generate();
    }
    public function json_sparepart() {
        $addFunc = "addSparepartCart({id:<get-id>,name:'<get-name>',price:<get-price>,stock:<get-stock>})";

        $this->load->model("datatables");
        $this->datatables->setTable("products");
        $this->datatables->setColumn([
            '<get-name>',
            '[rupiah=<get-price>]',
            '<div class="text-center">
                <button type="button" class="btn btn-sm btn-success" onclick="'.$addFunc.'"><i class="fa fa-plus"></i></button>
            </div>'
        ]);
        $this->datatables->setOrdering(["name","price",NULL]);
        $this->datatables->setWhere("type","sparepart");
        $this->datatables->setSearchField("name");
        $this->datatables->generate();
    }
}
