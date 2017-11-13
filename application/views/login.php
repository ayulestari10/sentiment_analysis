<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=$title?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?=base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/login/stylelogin.css')?>">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class ="container">
        <div class="login">
            <img src="<?=base_url('assets/img/logo/asof.png')?>">
            <?=form_open('login')?>
                <fieldset>
                  <?= $this->session->flashdata('msg') ?>
                    <input type="text" name="u" placeholder="Username" required="required" />
                    <input type="password" name="p" placeholder="Password" required="required" />
                    <button type="submit" class="btn button-color btn-block btn-large">Masuk</button>
                </fieldset>
            <?=form_close()?>
        </div>
    </div>

    <!-- jQuery -->
    <script src="<?=base_url('assets/vendor/jquery/jquery.min.js')?>"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?=base_url('assets/vendor/bootstrap/js/bootstrap.min.js')?>"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?=base_url('assets/vendor/metisMenu/metisMenu.min.js')?>"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?=base_url('assets/dist/js/sb-admin-2.js')?>"></script>

</body>

</html>
