        
        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Pengaturan</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="<?=base_url("dashboard");?>">Dashboard</a></li>
                            <li class="active">Pengaturan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content mt-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label>Logo Bengkel</label>
                                <input type="file" class="dropify" data-default-file="<?=base_url("img/logo.png");?>" />
                            </div>
                            <div class="form-group">
                                <label>Nama Bengkel</label>
                                <input type="text" name="name" class="form-control" value="<?=$this->shop_info->get_shop_name();?>">
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea name="address" class="form-control"><?=$this->shop_info->get_shop_address();?></textarea>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary btn-save">Simpan</button>
                </div>
            </div>
        </div>

        <script>
            $(".btn-save").on("click",function(){
                    var form = new FormData();
                    form.append("name",jQuery('input[name=name]').val());
                    form.append("address",jQuery('textarea[name=address]').val());
                    form.append("userfile",jQuery('.dropify')[0].files[0]);
                    jQuery.ajax({
                        url: "<?=base_url("setting/save_info");?>",
                        method: "POST",
                        data: form,
                        dataType: "json",
                        processData: false,
                        contentType: false,
                        success: function(data){
                            if(data.status) {
                                Swal.fire(
                                    'Berhasil',
                                    data.msg,
                                    'success'
                                )
                            } else {
                                Swal.fire(
                                    'Gagal',
                                    data.msg,
                                    'error'
                                )
                            }
                        }
                    });
            })

            $('.dropify').dropify();
        </script>