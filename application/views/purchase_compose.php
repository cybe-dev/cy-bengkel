        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Tambah Pembelian Stock</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="<?=base_url("dashboard");?>">Dashboard</a></li>
                            <li><a href="<?=base_url("purchase");?>">Pembelian Stock</a></li>
                            <li class="active">Tambah Pembelian Stock</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content mt-3">
            <div class="card">
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label>Supplier :</label>
                            <select class="form-control supplier">
                                <option value="">-- Pilih --</option>
                                <?php
                                foreach($suppliers as $supllier) {
                                    echo '<option value="'.$supllier->id.'">'.$supllier->name.'</option>
                                    ';
                                }
                                ?>
                            </select>
                        </div>
                        <label>Barang :</label>
                        <table class="table table-bordered" id="purchaseForm">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th style="width:25%">Harga</th>
                                    <th style="width:25%">Qty</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><div class="product-name form-control form-control-sm" data-id="" data-stock="">--Pilih--</div></td>
                                    <td><input type="number" class="form-control form-control-sm" name="price"></td>
                                    <td><input type="number" class="form-control form-control-sm" name="qty"></td>
                                    <td class="text-center"><button type="button" class="btn btn-sm btn-danger btn-del"><i class="fa fa-times"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                    <button class="btn btn-success btn-sm mb-2 btn-add-row"><i class="fa fa-plus"></i> Tambah</button>
                </div>
            </div>
            <div class="text-right mb-4">
                <button class="btn btn-secondary">Cancel</button>
                <button class="btn btn-primary btn-save"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>

        <div class="modal" id="selectProduct" data-index="">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="largeModalLabel">Pilih Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered" id="listProduct">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th style="width:20%">Opsi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <script>

            $("#listProduct").DataTable({
                info: false,
                lengthChange: false,
                autoWidth: false,
                "processing": true,
                "serverSide": true,
                "ajax": {"url": "<?=base_url("purchase/json_product");?>"}
            });

            $(".btn-add-row").on("click",function(){

                jQuery("#purchaseForm tbody").append('<tr><td><div class="product-name form-control form-control-sm" data-id="" data-stock="">--Pilih--</div></td><td><input type="number" class="form-control form-control-sm" name="price"></td><td><input type="number" class="form-control form-control-sm" name="qty"></td><td class="text-center"><button type="button" class="btn btn-sm btn-danger btn-del"><i class="fa fa-times"></i></button></td></tr>');                

            })

            $('body').on("click",".product-name",function(){
                var index = jQuery(this).parent().parent().index();

                jQuery("#selectProduct").attr("data-index",index);
                jQuery("#selectProduct").modal("toggle");
            })

            $('body').on("click",".btn-choose",function(){
                var indexAffected = parseInt(jQuery("#selectProduct").attr("data-index")) + 1;

                var id = jQuery(this).attr("data-id");
                var name = jQuery(this).attr("data-name");
                var stock = jQuery(this).attr("data-stock");

                jQuery("#purchaseForm tbody tr:nth-child("+indexAffected+") .product-name").attr("data-id",id);
                jQuery("#purchaseForm tbody tr:nth-child("+indexAffected+") .product-name").attr("data-stock",stock);
                jQuery("#purchaseForm tbody tr:nth-child("+indexAffected+") .product-name").html(name);

                jQuery("#selectProduct").modal("toggle");
            })

            $(".btn-save").on("click",function(){
                var items = [];
                var total = 0;
                var countItem = jQuery("#purchaseForm tbody tr").length;
                
                for(var i = 1;i<=countItem;i++) {
                    var item = "#purchaseForm tbody tr:nth-child("+i+")";
                    var tmp = {};
                    tmp["product_id"] = jQuery(item+" .product-name").attr("data-id");
                    tmp["product_stock"] = jQuery(item+" .product-name").attr("data-stock");
                    tmp["price"] = jQuery(item+" input[name=price]").val();
                    tmp["qty"] = jQuery(item+" input[name=qty]").val();
                    total = total + (tmp["price"] * tmp["qty"]);

                    items.push(tmp);
                }

                var form = {};
                form["supplier_id"] = jQuery(".supplier").val();
                form["total"] = total;
                form["details"] = items;

                postJson(JSON.stringify(form));

            })

            function postJson(json) {  
                jQuery.ajax({
                    url: "<?=base_url('purchase/create');?>",
                    method: "POST",
                    data: json,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    success: function(data){
                        if(data.status) {
                            jQuery(".supplier").val("");
                            jQuery("#purchaseForm tbody").html('<tr><td><div class="product-name form-control form-control-sm" data-id="" data-stock="">--Pilih--</div></td><td><input type="number" class="form-control form-control-sm" name="price"></td><td><input type="number" class="form-control form-control-sm" name="qty"></td><td class="text-center"><button type="button" class="btn btn-sm btn-danger btn-del"><i class="fa fa-times"></i></button></td></tr>');

                            Swal.fire(
                                "Berhasil",
                                data.msg,
                                "success"
                            );
                        } else {
                            Swal.fire(
                                "Gagal",
                                data.msg,
                                "error"
                            );
                        }
                    }
                })
            }

            $("body").on("click",".btn-del",function(){
                jQuery(this).parent().parent().remove();
            })
        </script>