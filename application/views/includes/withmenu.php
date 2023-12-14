<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?= base_url() ?>assets/images/favicon.png" type="image/png">
    <title><?= ('ECビジネスサポート オークウィル') ?></title>

    <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet"> -->

    <!-- <link href="<?= base_url() ?>assets/plugins/datatables/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"> -->
    <link href="<?= base_url() ?>assets/plugins/datatables/css/jquery.dataTables-custom.css" rel="stylesheet" type="text/css">

    <!--Begin  Page Level  CSS -->
    <link href="<?= base_url() ?>assets/plugins/morris-chart/morris.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet"/>
    <!--End  Page Level  CSS -->
    
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    <link href="<?= base_url() ?>assets/css/icons.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/css/responsive.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/css/custom.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/css/parts.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/css/reset.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/css/admin.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/css/common.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/css/csv.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="<?= base_url() ?>assets/js/html5shiv.min.js"></script>
    <script src="<?= base_url() ?>assets/js/respond.min.js"></script>
    <![endif]-->

    <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    
    <script src="<?= base_url() ?>assets/js/modal.min.js"></script>
    <script src="<?= base_url() ?>assets/js/common.js"></script>
</head>

<body class="sticky-header">


    <!--Start left side Menu-->
    <div id="menuG">
        <div class="vessel">
            <div class="inner">
                <div class="bg01">
                    <div class="vessel">
                        <div class="logo01"><a href="https://aucwill.com"><img src="<?= base_url() ?>assets/images/logo.jpg" alt="オークウィル"></a></div>
                        <!-- <p class="tagline01"><span>お金のこと、</span><br><span>はじめての人が始めやすく</span></p> -->
                    </div>
                </div>
                <div class="bg02">
                    <ul class="categoryList01">
                        <?php if($this->session->userdata('isadmin')) { ?>
                        <li>
                            <a href="<?= base_url() ?>management">
                                <span>管理者</span>
                            </a>
                        </li>
                        <?php } ?>
                        <li>
                            <a href="<?= base_url() ?>dashboard">
                                <span>ホーム</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url() ?>csv/create">
                                <span>CSVで納品予定連絡</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url() ?>schedule">
                                <span>納品予定連絡</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url() ?>schedulelist">
                                <span>納品予定一覧</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url() ?>photos">
                                <span>撮影済写真</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url() ?>stock">
                                <span>在庫</span>
                                <!-- <div class="counter">19</div> -->
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url() ?>domestic">
                                <span>国内発送一覧</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url() ?>address">
                                <span>発送元登録</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url() ?>invoice">
                                <span>請求予定</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url().($this->session->userdata('isadmin')?'admin-enquiry':'enquiry') ?>">
                                <span>お問い合わせ</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url() ?>logout">
                                <span>ログアウト</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--End left side menu-->

    <!-- header section start-->
    <div class="header-section">
        <a class="toggle-btn"><i class="fa fa-bars"></i></a>
        <div class="menu-right">
            <?php if($this->session->userdata('isadmin')) { ?><a href="<?=base_url()?>users" class="member-register-btn">会員リスト</a><?php } ?><span>会員番号 : <b><?= $this->session->userdata('member_id') ?></b></span>&nbsp;&nbsp;&nbsp;&nbsp;<span><b><?= $this->session->userdata('name') ?> 様</b></span>
        </div>

    </div>
    <!-- header section end-->

    <!-- main content start-->
    <div class="main-content" >
        <!--body wrapper start-->
        <div class="wrapper">

            <!--Start Page Title-->
            <!-- <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="clearfix"></div>
            </div> -->
            <!--End Page Title-->
            <?= ($contents) ?>
        </div>
        <!-- End Wrapper-->


        <!--Start  Footer -->
        <footer class="footer-main"> 2023 &copy; AUCWILL</footer>
        <!--End footer -->

    </div>
    <!--End main content -->



<!--Begin core plugin -->
<script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/moment/moment.js"></script>
<script  src="<?= base_url() ?>assets/js/jquery.slimscroll.js "></script>
<script src="<?= base_url() ?>assets/js/jquery.nicescroll.js"></script>
<script src="<?= base_url() ?>assets/js/functions.js"></script>
<script src="<?= base_url() ?>assets/plugins/select2/js/select2.full.min.js"></script>
<!-- End core plugin -->

<!--Begin Page Level Plugin-->
<script src="<?= base_url() ?>assets/plugins/morris-chart/morris.js"></script>
<script src="<?= base_url() ?>assets/plugins/morris-chart/raphael-min.js"></script>
<!-- <script src="<?= base_url() ?>assets/plugins/jquery-sparkline/jquery.sparkline.min.js"></script> -->

<script>
    
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2();
    });
  </script>
<!--End Page Level Plugin-->
</body>

</html>
