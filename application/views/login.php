      <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <a href="#" style="color:#FFF;font-size: 28px">
                        <?=$this->shop_info->get_shop_name();?>
                    </a>
                </div>
                <div class="login-form">
                    <?php if($error) { ?>
                    
                    <div class="alert alert-danger"><?=$error;?></div>
                    <?php } ?>

                    <form action="<?=base_url("auth/login");?>" method="post">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Sign in</button>
                    </form>
                </div>
            </div>
        </div>
    </div>