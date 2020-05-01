        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Ganti Password</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="<?=base_url("dashboard");?>">Dashboard</a></li>
                            <li class="active">Ganti Password</li>
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
                                <label>Password Lama</label>
                                <input type="password" name="oldpw" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Password Baru</label>
                                <input type="password" name="newpw1" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Ulangi Password Baru</label>
                                <input type="password" name="newpw2" class="form-control">
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary btn-save">Simpan</button>
                </div>
            </div>
        </div>

        <script>
            $(".btn-save").on("click",function(){
                    var form = {
                        "oldpw": jQuery('input[name=oldpw]').val(),
                        "newpw1": jQuery('input[name=newpw1]').val(),
                        "newpw2": jQuery('input[name=newpw2]').val(),
                    };
                    jQuery.ajax({
                        url: "<?=base_url("setting/save_password");?>",
                        method: "POST",
                        data: form,
                        dataType: "json",
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
        </script>