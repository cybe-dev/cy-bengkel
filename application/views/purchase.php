        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Pembelian Stock</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="<?=base_url("dashboard");?>">Dashboard</a></li>
                            <li class="active">Pembelian Stock</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content mt-3">
            <div class="card">
                <div class="card-header">
                    <a href="<?=base_url("purchase/new");?>" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambah</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="data">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>Supplier</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="details" data-index="">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="largeModalLabel">Detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table-detail">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Barang</th>
                                        <th>Harga</th>
                                        <th>Qty</th>
                                        <th>Sub</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td colspan="4">Total</td>
                                        <td><span class="total"></span></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
                $("#table-detail").DataTable({autoWidth: false,info:false,filter:false,lengthChange:false,paging:false});

                $("body").on("click",".btn-view",function(){
                    var id = jQuery(this).attr("data-id");

                    jQuery.getJSON("<?=base_url("purchase/detail");?>/"+id,function(data){

                        jQuery("#table-detail").DataTable().clear();

                        data.items.forEach(function(item,index){
                            var tmp = [];
                            var sub = item.price * item.qty;
                            tmp.push(index+1);
                            tmp.push(item.name);
                            tmp.push("Rp "+item.price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
                            tmp.push(item.qty);
                            tmp.push("Rp "+sub.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));

                            jQuery("#table-detail").DataTable().row.add(tmp).draw();
                        })

                        jQuery("#table-detail .total").html("Rp "+data.total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));

                        jQuery("#details").modal("toggle");
                    });
                })
                $("#data").DataTable({
                    "processing": true,
                    "serverSide": true,
                    "autoWidth":true,
                    "order": [[0,"desc"]],
                    "ajax": {"url": "<?=base_url("purchase/json");?>"}
                });
        </script>