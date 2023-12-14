<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon.png" type="image/png">
    <title>ECビジネスサポート オークウィル</title>
    <link href="<?php echo base_url(); ?>assets/css/icons.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/responsive.css" rel="stylesheet">
</head>
<body class="sticky-header">

<!--Start login Section-->
<section class="login-section">
    <div class="mw-500 absolute-center">
        <div class="card">
            <div class="logo login-title">
                <h2 class="text-center p-b-10" style="color:white; z-index: 5 !important; position: relative;">ログイン</h2>
            </div>
            <div class="login-inner">

                <!-- <h2 class="header-title text-center"></h2> -->

                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
                
                <?php
                $error = $this->session->flashdata('login_error');
                
                if($error != '') { ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php echo $error; ?>
                    </div>
                <?php 
                } ?>

                <?php echo form_open(base_url()."login"); ?>
                    <div class="form-group">
                        <input type="text" class="form-control login-input" placeholder="会員番号" name="member_id" required />
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control login-input" placeholder="パスワード" name="password" required />
                    </div>

                    <div class="form-group" style="display:none">
                        <div class="pull-left">
                            <div class="checkbox primary">
                                <input name="remember" id="checkbox-2" type="checkbox">
                                <label for="checkbox-2">Remember me</label>
                            </div>
                        </div>

                        <div class="pull-right">
                            <a href="<?php echo base_url() ?>forgotPassword" class="a-link">
                                <i class="fa fa-unlock-alt"></i> Forgot password?
                            </a>
                        </div>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary btn-block login-btn">ログイン</button>
                    </div>
                <?php echo form_close(); ?>

            </div>
        </div>
    </div>
</section>

<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
</body>
</html>
