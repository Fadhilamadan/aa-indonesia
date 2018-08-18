<?php
session_start();
require './db.php';
$cmd = $_GET['cmd'];

switch ($cmd) {
    case 'chart_komisi':
        $nama = array();
        $hasil = array();
        $semua = 0;
        $tanggal_awal = date("Y-m-1");
        $tanggal_akhir = date("Y-m-d");
        $tgl1 = str_replace('-', '/', $tanggal_akhir);
        $tanggal_akhir = date('Y-m-d',strtotime($tgl1 . "+1 days"));
        $sqlEmployee = "SELECT * FROM employees";
        $resultEmployee = mysqli_query($link, $sqlEmployee);
        while($rowEmployee=mysqli_fetch_array($resultEmployee)){
            $sqlHubClosing = "SELECT * FROM hub_closing_employee WHERE employee_id=".$rowEmployee['id'];
            $resultHubClosing = mysqli_query($link, $sqlHubClosing);
            $total = 0;
            while($rowHubClosing=mysqli_fetch_array($resultHubClosing)){
                $sqlClosing = "SELECT * FROM closing WHERE tanggal between '".$tanggal_awal."' and '".$tanggal_akhir."'";
                $resultClosing = mysqli_query($link, $sqlClosing);
                while($rowClosing=mysqli_fetch_array($resultClosing)){
                    if($rowHubClosing['closing_id']==$rowClosing['id'])
                        $total+=$rowHubClosing['komisi'];
                        $semua+=$rowHubClosing['komisi'];
                }
            }  
            if($total!=0){
                $nama[] = $rowEmployee['nama'];
                $hasil[] = $total/1000000;
            }  
        }
        echo json_encode(array('nama'=>$nama, 'total'=>$hasil, 'semua'=>$semua));
        break;

    case 'chart_unit':
        $tanggal = array();
        $hasil = array();
        $semua = 0;
        $tanggal_awal = date("Y-m-1");
        $tanggal_akhir = date("Y-m-d");
        $tgl1 = str_replace('-', '/', $tanggal_akhir);
        $tglBesok = date('Y-m-d',strtotime($tgl1 . "+1 days"));
                
        $sqlClosing = "SELECT COUNT(id) as jumlah, tanggal FROM `closing` WHERE tanggal between '".$tanggal_awal."' and '".$tglBesok."' GROUP BY tanggal";
        $resultClosing = mysqli_query($link, $sqlClosing);
        while($rowClosing=mysqli_fetch_array($resultClosing)){
            $total = 0;
            $total+=$rowClosing['jumlah'];
            $semua+=$rowClosing['jumlah'];
            if($total!=0){
                $tanggal[] = $rowClosing['tanggal'];
                $hasil[] = $total;
            }  
        }
        echo json_encode(array('tanggal'=>$tanggal, 'total'=>$hasil, 'semua'=>$semua));
        break;


    case 'cek_user':
        $user = $_POST['user'];
        $status = 0;

        $sql = "SELECT * FROM users WHERE username = '" . $user . "' ";
        $result = mysqli_query($link, $sql);
        if (!$result) {
            die("SQL ERROR.".$sql);
        }
        if(mysqli_num_rows($result)>0){
            $status = 1;
        }
        header("content-type: text/x-json");
        echo json_encode($status);
        exit();
        break;

    case 'cek_userE':
        $user = $_POST['user'];
        $status = 0;

        $sql = "SELECT * FROM users WHERE employee_id = '" . $user . "' ";
        $result = mysqli_query($link, $sql);
        if (!$result) {
            die("SQL ERROR.".$sql);
        }
        if(mysqli_num_rows($result)>0){
            $status = 1;
        }
        header("content-type: text/x-json");
        echo json_encode($status);
        exit();
        break;

    case 'daftar_user':
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $pswd = md5($pass);

        $sqlMaxId = "SELECT MAX(id) as id from employees";
        $resultMaxId = mysqli_query($link, $sqlMaxId);
        if(!$resultMaxId){
            die("SQL ERROR: ".$sqlMaxId);
        }
        $rowMaxId = mysqli_fetch_array($resultMaxId);

        $sql = "INSERT INTO users (username, password, employee_id)" . "VALUE ('" . $user . "', '" . $pswd ."', '" . $rowMaxId['id'] . "')";
        $result = mysqli_query($link, $sql);
        if(!$result){
            die('SQL ERROR: '.$sql);
        }
        break;

    case 'daftar_userE':
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $id = $_POST['id'];
        $pswd = md5($pass);

        $sql = "INSERT INTO users (username, password, employee_id)" . "VALUE ('" . $user . "', '" . $pswd ."', '" . $id . "')";
        $result = mysqli_query($link, $sql);
        if(!$result){
            die('SQL ERROR: '.$sql);
        }
        break;

    case 'hapus_user':
        $id = $_POST['id'];
        $sql = "DELETE FROM users WHERE employee_id = '" . $id . "' ";
        $result = mysqli_query($link, $sql);
        if(!$result){
            die('SQL ERROR: '.$sql);
        }
        break;

	case 'login':
		$id = $_POST['user'];
        $psw = $_POST['pass'];
        $pswd = md5($psw);

        $sqlU = "SELECT * FROM users WHERE username ='" . $id . "' "; // Tabel user
        $resultU = mysqli_query($link, $sqlU);
        $rowU = mysqli_fetch_array($resultU);

        if(mysqli_num_rows($resultU) > 0) {
            if($pswd == $rowU['password']){
                setcookie("idU", $rowU['username'], time() + 6000); 
                setcookie("loginU", TRUE, time() + 6000);
                header("location: home.php"); // Halaman Dashboard
            }
            else {
                header("content-type: text/x-json");
                echo json_encode(0);
                exit();
                //$_SESSION['notifL'] = "<strong>Maaf,</strong> Username dan Password yang Anda masukkan tidak cocok.";
                //header("location: login.php");
            }
        }
        else {
            header("content-type: text/x-json");
            echo json_encode(0);
            exit();
            //$_SESSION['notifL'] = "<strong>Maaf,</strong> Username dan Password yang Anda masukkan tidak cocok.";
            //header("location: login.php");
        }

		break;

	case "logout":
        setcookie("idU", $rowU['employee_id'], time() -1);
        setcookie("loginU", FALSE, time() -1);
        header('location: login.php');
        break;
	
     case 'daftar_cabang':
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $kota = $_POST['kota'];
        $kodepos = $_POST['kodepos'];
        $no_telp = $_POST['no_telp'];
        $sql = "INSERT INTO b_office (nama, alamat, kota, kodepos, no_telp)" . "VALUE ('" . $nama . "', '" . $alamat . "', '" . $kota . "', '".$kodepos."',  '". $no_telp."')";
        $result = mysqli_query($link, $sql);
        if (!$result) {
            die("SQL ERROR.".$sql);
            header("Location: cabang/info.php");
        }
        else {
            $_SESSION['notif'] = "Cabang baru berhasil untuk ditambahkan.";
            header("Location: cabang/info.php");
        }
        break;

    case 'daftar_agent':
        $nama = $_POST['nama'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $tanggal_lahir = $_POST['tanggal_lahir'];
        $no_telp = $_POST['no_telp'];
        $upline_id = $_POST['upline_id'];
        $jabatan_id = $_POST['jabatan_id'];
        $cabang_id = $_POST['cabang_id'];


        $sql = "INSERT INTO employees (nama, jenis_kelamin, no_telp, tgl_lahir,  position_id, b_office_id, upline_id) VALUE ('" . $nama . "', '" . $jenis_kelamin . "', '" . $no_telp . "', '".$tanggal_lahir."', ". $jabatan_id.",  ". $cabang_id.",  ". $upline_id.")";
        $sqlMaxId = "SELECT MAX(id) as id from employees";
        $sqlCekJabatan = "SELECT * FROM employees WHERE aktif = 1 AND position_id=".$jabatan_id." AND b_office_id = ". $cabang_id;
            
        if($jabatan_id==3 || $jabatan_id ==4)
        {
            $resultCekJabatan = mysqli_query($link, $sqlCekJabatan);
            if(mysqli_num_rows($resultCekJabatan)>0)
            {
                header("content-type: text/x-json");
                echo json_encode(0);
                exit();
            }
            else
            {
                $result = mysqli_query($link, $sql);
                $resultMaxId = mysqli_query($link, $sqlMaxId);
                $rowMaxId = mysqli_fetch_array($resultMaxId);
                $sqlPosition = "INSERT INTO hub_positions_employee (position_id, employee_id) VALUE (".$jabatan_id.",".$rowMaxId['id'].")";
                $sqlBranch = "INSERT INTO hub_branch_employee (branch_id, employee_id) VALUE (".$cabang_id.",".$rowMaxId['id'].")";
                if (!$result) {
                    die("SQL ERROR. ".$sql);
                    header("Location: agent/daftar.php");
                }
                else {
                    $resultPosition = mysqli_query($link, $sqlPosition);
                    $resultBranch = mysqli_query($link, $sqlBranch);
                    if (!$resultPosition) {
                        die("SQL ERROR.".$sqlPosition);
                        header("Location: agent/daftar.php");
                    }
                    else {
                        header("content-type: text/x-json");
                        echo json_encode(1);
                        exit();
                    }
                }
            }
        }
        else
        {
            $result = mysqli_query($link, $sql);
            if (!$result) {
                $_SESSION['notif'] = "SQL ERROR. ".$sql;
                header("Location: agent/daftar.php");
            }
            else {
                $resultMaxId = mysqli_query($link, $sqlMaxId);
                $rowMaxId = mysqli_fetch_array($resultMaxId);
                $sqlPosition = "INSERT INTO hub_positions_employee (position_id, employee_id) VALUE (".$jabatan_id.",".$rowMaxId['id'].")";
                $sqlBranch = "INSERT INTO hub_branch_employee (branch_id, employee_id) VALUE (".$cabang_id.",".$rowMaxId['id'].")";
                $resultBranch = mysqli_query($link, $sqlBranch);
                $resultPosition = mysqli_query($link, $sqlPosition);
                if (!$resultPosition) {
                    die("SQL ERROR.".$sqlPosition);
                    header("Location: agent/daftar.php");
                }
                else {
                    header("content-type: text/x-json");
                    echo json_encode(1);
                    exit();
                }
            }
        }
        break;

    case 'edit_agent':
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $no_telp = $_POST['telp'];
        $jabatan_id = $_POST['jabatan'];
        $cabang_id = $_POST['cabang'];

        $sqlEmployee = "SELECT * FROM employees WHERE id = '".$id."'";
        $resultEmployee = mysqli_query($link, $sqlEmployee);
        $rowEmployee = mysqli_fetch_array($resultEmployee);
        if(!$resultEmployee){
            echo "SQL ERROR: ".$sqlEmployee;
        }

        if($rowEmployee['position_id'] == $jabatan_id){
            $sql = "UPDATE employees SET nama = '".$nama."', no_telp = '".$no_telp."', position_id = '".$jabatan_id."', b_office_id = '".$cabang_id."' WHERE id = '".$id."'";
            $result = mysqli_query($link, $sql);
            if($rowEmployee['b_office_id']!=$cabang_id){
                $sqlCabang = "INSERT INTO hub_branch_employee (branch_id, employee_id) VALUE (".$cabang_id.",".$rowEmployee['id'].")";
                $resultCabang = mysqli_query($link, $sqlCabang);                
            }
            if (!$result) {
                die("SQL ERROR.". $sql);
                header("Location: agent/info.php");
            }
            else {
                header("content-type: text/x-json");
                echo json_encode(1);
                exit();
            }
        }else{
            if($jabatan_id==4){
                $sqlCekP = "SELECT *  FROM employees WHERE position_id = 4 AND aktif = 1 AND b_office_id = ".$cabang_id;
                $resultCekP = mysqli_query($link,  $sqlCekP);
                if(mysqli_num_rows($resultCekP)>0){
                    header("content-type: text/x-json");
                    echo json_encode(0);
                    exit();;
                }
                else{
                    $sql = "UPDATE employees SET nama = '".$nama."', no_telp = '".$no_telp."', position_id = '".$jabatan_id."', b_office_id = '".$cabang_id."' WHERE id = '".$id."'";
                    $result = mysqli_query($link, $sql);
                    if (!$result) {
                        die("SQL ERROR. ".$sql);
                        header("Location: agent/info.php");
                    }
                    
                    if($rowEmployee['b_office_id']!=$cabang_id){
                        $sqlCabang = "INSERT INTO hub_branch_employee (branch_id, employee_id) VALUE (".$cabang_id.",".$rowEmployee['id'].")";
                        $resultCabang = mysqli_query($link, $sqlCabang);
                    }
                    $sqlPosition = "INSERT INTO hub_positions_employee (position_id, employee_id) VALUE (".$jabatan_id.",".$id.")";
                    $resultPosition = mysqli_query($link, $sqlPosition);
                    if (!$resultPosition) {
                        die("SQL ERROR. ".$sqlPosition);
                        header("Location: agent/info.php");
                    }
                    else {
                        header("content-type: text/x-json");
                        echo json_encode(1);
                        exit();
                    }
                }
            }
            else if($jabatan_id==3){
                $sqlCekVP = "SELECT *  FROM employees WHERE position_id = 3 AND aktif = 1 AND b_office_id = ".$cabang_id;
                $resultCekVP = mysqli_query($link,  $sqlCekVP);
                if(mysqli_num_rows($resultCekVP)>0){
                    header("content-type: text/x-json");
                    echo json_encode(0);
                    exit();;
                }
                else{
                    $sql = "UPDATE employees SET nama = '".$nama."', no_telp = '".$no_telp."', position_id = '".$jabatan_id."', b_office_id = '".$cabang_id."' WHERE id = '".$id."'";
                    $result = mysqli_query($link, $sql);
                    if (!$result) {
                        die("SQL ERROR. ".$sql);
                        header("Location: agent/info.php");
                    }
                    
                    if($rowEmployee['b_office_id']!=$cabang_id){
                        $sqlCabang = "INSERT INTO hub_branch_employee (branch_id, employee_id) VALUE (".$cabang_id.",".$rowEmployee['id'].")";
                        $resultCabang = mysqli_query($link, $sqlCabang);
                    }
                    $sqlPosition = "INSERT INTO hub_positions_employee (position_id, employee_id) VALUE (".$jabatan_id.",".$id.")";
                    $resultPosition = mysqli_query($link, $sqlPosition);
                    if (!$resultPosition) {
                        die("SQL ERROR. ".$sqlPosition);
                        header("Location: agent/info.php");
                    }
                    else {
                        header("content-type: text/x-json");
                        echo json_encode(1);
                        exit();
                    }
                }
            }
            else{
                $sql = "UPDATE employees SET nama = '".$nama."', no_telp = '".$no_telp."', position_id = '".$jabatan_id."', b_office_id = '".$cabang_id."' WHERE id = '".$id."'";
                $result = mysqli_query($link, $sql);
                if (!$result) {
                    die("SQL ERROR. ".$sql);
                    header("Location: agent/info.php");
                }

                if($rowEmployee['b_office_id']!=$cabang_id){
                    $sqlCabang = "INSERT INTO hub_branch_employee (branch_id, employee_id) VALUE (".$cabang_id.",".$rowEmployee['id'].")";
                    $resultCabang = mysqli_query($link, $sqlCabang);
                }
                $sqlPosition = "INSERT INTO hub_positions_employee (position_id, employee_id) VALUE (".$jabatan_id.",".$id.")";
                $resultPosition = mysqli_query($link, $sqlPosition);
                if (!$resultPosition) {
                    die("SQL ERROR. ".$sqlPosition);
                    header("Location: agent/info.php");
                }
                else {
                    header("content-type: text/x-json");
                    echo json_encode(1);
                    exit();
                }
            }
            
        }
        break;

    case 'non_aktif':
        $id = $_POST['id'];
        
        $sql = "UPDATE employees SET aktif = 0 WHERE id= ".$id;
        $result = mysqli_query($link, $sql);
        if (!$result) {
            die("SQL ERROR.". $sql);
            header("Location: agent/info.php");
        }
        
        $sqlHub = "INSERT INTO hub_positions_employee (position_id, employee_id) VALUE (5, ".$id.")";
        $resultHub = mysqli_query($link, $sqlHub);
        if (!$resultHub) {
            die("SQL ERROR.". $sqlHub);
            header("Location: agent/info.php");
        }

        $sqlEmployee = "SELECT * FROM employees WHERE id = '".$id."'";
        $resultEmployee = mysqli_query($link, $sqlEmployee);
        $rowEmployee = mysqli_fetch_array($resultEmployee);
        header("content-type: text/x-json");
        echo json_encode($rowEmployee);
        break;

    case 'edit_cabang':
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $kota = $_POST['kota'];
        $kodepos = $_POST['kodepos'];
        $no_telp = $_POST['telp'];

        $sql = "UPDATE b_office SET nama = '".$nama."', kodepos = '".$kodepos."', no_telp = '".$no_telp."', alamat = '".$alamat."', kota = '".$kota."' WHERE id = '".$id."'";
        $result = mysqli_query($link, $sql);
        if (!$result) {
            die("SQL ERROR.". $sql);
            header("Location: cabang/info.php");
        }
        else {
            //$_SESSION['notif'] = "Agent berhasil untuk diperbarui.";
            header("Location: cabang/info.php");
        }
        break;

    case 'delete_cabang':
        $id = $_POST['id'];
        $sqlEmployee = "SELECT * FROM employees WHERE b_office_id = '".$id."'";
        $resultEmployee = mysqli_query($link, $sqlEmployee);
        if(mysqli_num_rows($resultEmployee)==0){
            $sql = "UPDATE b_office SET aktif = '0' WHERE id = ".$id ;
            $result = mysqli_query($link, $sql);
            if (!$result) {
                die($_SESSION['notif'] = "SQL ERROR.". $sql);
            }
            else {
                header("Location: cabang/info.php");
            }
            header("content-type: text/x-json");
            echo json_encode(1);
        }else{
            header("content-type: text/x-json");
            echo json_encode(0);
        }
        
        break;

    case 'cekClosing':
        $agentId =0;
        $komisi =0;
        $rows = array();
        $i=0;

        $tgl = $_POST['tanggal_closing'];

        if (count($_POST['closing']) >= 0)
        {
            foreach ($_POST['closing'] as $row)
            {
                $idPrincipal = 0; $idVPrincipal = 0; 
                $principalNama = "NULL";
                $vPrincipalNama = "NULL";
                $upline1 = "NULL";
                $upline2 = "NULL";
                $upline3 = "NULL";
                $agentId = $row['id'];
                $nilai = $row['jumlah_komisi'];
                $komisi = '';
                $split = explode('.', $nilai);
                foreach ($split as $s) {
                    $komisi = $komisi.''.$s;
                }
                $pos = strpos($komisi, ',');
                if($pos != null){
                    $nilai = $komisi;
                    $split = explode(',', $nilai);
                    $komisi = $split[0] . '.' . $split[1];
                }

                $sqlPersen = "SELECT * FROM percents";
                $resultPersen = mysqli_query($link, $sqlPersen);
                if(!$resultPersen){
                    die("SQL ERROR.".$sqlPersen);
                }
                $rowPersen = mysqli_fetch_array($resultPersen);

                $sqlAgent = "SELECT * FROM `employees` WHERE id = '".$agentId."'";
                $resultAgent = mysqli_query($link, $sqlAgent);
                if(!$resultAgent){
                    die("SQL ERROR.".$sqlAgent);
                }
                $rowAgent = mysqli_fetch_array($resultAgent);

                ////////////////////////////////Thoughtful Area/////////////////////////////////////
                $tgl1 = str_replace('-', '/', $tgl);
                $tglBesok = date('Y-m-d',strtotime($tgl1 . "+1 days"));
                $sqlCekCabangAgent = "SELECT h.branch_id FROM (SELECT MAX(tanggal) as tanggal_akhir FROM `hub_branch_employee` WHERE employee_id=".$agentId." AND tanggal<='".$tglBesok."' ) sq , hub_branch_employee h WHERE h.tanggal = sq.tanggal_akhir";
                $resultCekCabangAgent = mysqli_query($link, $sqlCekCabangAgent);//Cek Cabang pada tanggal Closing
                $rowCekCabangAgent = mysqli_fetch_array($resultCekCabangAgent);

                //CEK Principal 
                $sqlPrincipal = "SELECT * FROM hub_positions_employee WHERE position_id=4 AND tanggal<='".$tglBesok."'";
                $resultPrincipal = mysqli_query($link, $sqlPrincipal);
                while($rowPrincipal=mysqli_fetch_array($resultPrincipal)){
                    $sqlCekJabatanTerakhir = "SELECT h.position_id FROM (SELECT MAX(tanggal) as tanggal_akhir FROM `hub_positions_employee` WHERE employee_id=".$rowPrincipal['employee_id']." AND tanggal<='".$tglBesok."' ) sq , hub_positions_employee h WHERE h.tanggal = sq.tanggal_akhir";
                    $resultCekJabatanTerakhir = mysqli_query($link, $sqlCekJabatanTerakhir);
                    $rowCekJabatanTerakhir = mysqli_fetch_array($resultCekJabatanTerakhir);
                    if($rowCekJabatanTerakhir['position_id']==4){
                        $sqlCekCabangPrincipal = "SELECT h.branch_id FROM (SELECT MAX(tanggal) as tanggal_akhir FROM `hub_branch_employee` WHERE employee_id=".$rowPrincipal['employee_id']." AND tanggal<='".$tglBesok."' ) sq , hub_branch_employee h WHERE h.tanggal = sq.tanggal_akhir";
                        $resultCekCabangPrincipal = mysqli_query($link, $sqlCekCabangPrincipal);//Cek Cabang Principal pada tanggal Closing
                        $rowCekCabangPrincipal = mysqli_fetch_array($resultCekCabangPrincipal);
                        if($rowCekCabangPrincipal['branch_id']==$rowCekCabangAgent['branch_id']){
                            $sqlNamaP = "SELECT * FROM employees WHERE id=".$rowPrincipal['employee_id'];
                            $resultNamaP = mysqli_query($link, $sqlNamaP);
                            $rowNamaP = mysqli_fetch_array($resultNamaP);
                            $principalNama = $rowNamaP['id']." - ".$rowNamaP['nama'];
                            $idPrincipal = $rowNamaP['id'];
                            if($agentId==$rowNamaP['id']){
                                $principalNama = "NULL - Self Principal";
                            }
                        }
                    }
                }//END REGION CEK PRINCIPAL

                //CEK Vice Principal 
                $sqlVicePrincipal = "SELECT * FROM hub_positions_employee WHERE position_id=3 AND tanggal<='".$tglBesok."'";
                $resultVicePrincipal = mysqli_query($link, $sqlVicePrincipal);
                while($rowVicePrincipal=mysqli_fetch_array($resultVicePrincipal)){
                    $sqlCekJabatanTerakhirV = "SELECT h.position_id FROM (SELECT MAX(tanggal) as tanggal_akhir FROM `hub_positions_employee` WHERE employee_id=".$rowVicePrincipal['employee_id']." AND tanggal<='".$tglBesok."' ) sq , hub_positions_employee h WHERE h.tanggal = sq.tanggal_akhir";
                    $resultCekJabatanTerakhirV = mysqli_query($link, $sqlCekJabatanTerakhirV);
                    $rowCekJabatanTerakhirV = mysqli_fetch_array($resultCekJabatanTerakhirV);
                    if($rowCekJabatanTerakhirV['position_id']==3){
                        $sqlCekCabangVicePrincipal = "SELECT h.branch_id FROM (SELECT MAX(tanggal) as tanggal_akhir FROM `hub_branch_employee` WHERE employee_id=".$rowVicePrincipal['employee_id']." AND tanggal<='".$tglBesok."' ) sq , hub_branch_employee h WHERE h.tanggal = sq.tanggal_akhir";
                        $resultCekCabangVicePrincipal = mysqli_query($link, $sqlCekCabangVicePrincipal);//Cek Cabang Vice Principal pada tanggal Closing
                        $rowCekCabangVicePrincipal = mysqli_fetch_array($resultCekCabangVicePrincipal);
                        if($rowCekCabangVicePrincipal['branch_id']==$rowCekCabangAgent['branch_id']){
                            $sqlNamaVP = "SELECT * FROM employees WHERE id=".$rowVicePrincipal['employee_id'];
                            $resultNamaVP = mysqli_query($link, $sqlNamaVP);
                            $rowNamaVP = mysqli_fetch_array($resultNamaVP);
                            $vPrincipalNama = $rowNamaVP['id']." - ".$rowNamaVP['nama'];
                            $idVPrincipal = $rowNamaVP['id'];
                            if($agentId==$rowNamaVP['id']){
                                $vPrincipalNama = "NULL - Self Vice Principal";
                            }
                        }
                    }
                }//END REGION CEK VICE PRINCIPAL


                if($rowAgent['upline_id'] != null){
                    $sqlCekUpline2 = "SELECT e.upline_id as upline2 FROM 
                                            (SELECT * FROM employees 
                                             WHERE id = ".$agentId.") sq, employees e
                                       WHERE e.id=sq.upline_id";
                    $resultCekUpline2 = mysqli_query($link, $sqlCekUpline2);
                    $rowCekUpline2 = mysqli_fetch_array($resultCekUpline2);
                    if($rowCekUpline2['upline2'] != null){
                        $sqlCekUpline3 = "SELECT e.upline_id as upline3 FROM
                                             (SELECT e.upline_id as upline2 FROM 
                                                (SELECT * FROM employees 
                                                 WHERE id = ".$agentId.") sq, employees e
                                              WHERE e.id=sq.upline_id) sq, employees e
                                          WHERE e.id = sq.upline2";
                        $resultCekUpline3 = mysqli_query($link, $sqlCekUpline3);
                        $rowCekUpline3 = mysqli_fetch_array($resultCekUpline3);
                        if($rowCekUpline3['upline3'] != null){
                            $sqlUpline = "SELECT sq.id, sq.nama, sq.upline1, sq.nama_upline1, sq.jabatan_upline1, sq.cabang_upline1, sq.aktif_upline1, sq.upline2, sq.nama_upline2, sq.jabatan_upline2, sq.cabang_upline2, sq.aktif_upline2, sq.upline3, e.nama as nama_upline3, e.position_id as jabatan_upline3, e.b_office_id as cabang_upline3, e.aktif as aktif_upline3 FROM
                                                (SELECT sq.id, sq.nama, sq.upline1, sq.nama_upline1, sq.jabatan_upline1, sq.cabang_upline1, sq.aktif_upline1, sq.upline2, e.nama as nama_upline2, e.position_id as jabatan_upline2, e.b_office_id as cabang_upline2, e.aktif as aktif_upline2,  e.upline_id as upline3 FROM
                                                      (SELECT sq.id, sq.nama, sq.upline1, e.nama as nama_upline1, e.position_id as jabatan_upline1, e.b_office_id as cabang_upline1, e.aktif as aktif_upline1, e.upline_id as upline2 FROM 
                                                            (SELECT id, nama, upline_id as upline1 FROM employees 
                                                             WHERE id = ".$agentId.") sq, employees e
                                                       WHERE e.id=sq.upline1) sq, employees e
                                                WHERE e.id = sq.upline2) sq, employees e
                                            WHERE e.id = sq.upline3";
                            $resultUpline = mysqli_query($link, $sqlUpline);
                            if (!$resultUpline) {
                                die("SQL ERROR.". $sqlUpline);
                            }
                            $rowUpline = mysqli_fetch_array($resultUpline);

                            $KUP1 = $komisi * ($rowPersen['upline1']/100);
                            $KUP2 = $komisi * ($rowPersen['upline2']/100);
                            $KUP3 = $komisi * ($rowPersen['upline3']/100);
                            $KP = $komisi * ($rowPersen['principal']/100);
                            $KVP = $komisi * ($rowPersen['vice_principal']/100);

                            if($rowUpline['aktif_upline1']==1){
                                $upline1 = $rowUpline['upline1']." - ".$rowUpline['nama_upline1'];
                                if($rowUpline['upline1']==$idVPrincipal){
                                    $upline1 = "NULL - Vice Principal";
                                }
                                if($rowUpline['upline1']==$idPrincipal){
                                    $upline1 = "NULL - Principal";
                                }
                            }
                            else{
                                $upline1 = "NULL - Resign";
                            }
                            if($rowUpline['aktif_upline2']==1){
                                $upline2 = $rowUpline['upline2']." - ".$rowUpline['nama_upline2'];
                                if($rowUpline['upline2']==$idVPrincipal){
                                    $upline2 = "NULL - Vice Principal";
                                }
                                if($rowUpline['upline2']==$idPrincipal){
                                    $upline2 = "NULL - Principal";
                                }
                            }
                            else{
                                $upline2 = "NULL - Resign";
                            }
                            if($rowUpline['aktif_upline3']==1){
                                $upline3 = $rowUpline['upline3']." - ".$rowUpline['nama_upline3'];
                                if($rowUpline['upline3']==$idVPrincipal){
                                    $upline3 = "NULL - Vice Principal";
                                }
                                if($rowUpline['upline3']==$idPrincipal){
                                    $upline3 = "NULL - Principal";
                                }
                            }
                            else{
                                $upline3 = "NULL - Resign";
                            }
                            $rows[] = array(
                                'idA'=>$rowUpline['id']." - ".$rowUpline['nama'], 'komisiA'=>$komisi, 
                                'idUP1'=>$upline1, 'kUP1'=>$KUP1,
                                'idUP2'=>$upline2, 'kUP2'=>$KUP2,
                                'idUP3'=>$upline3, 'kUP3'=>$KUP3,
                                'idP'=>$principalNama, 'kP'=>$KP,
                                'idVP'=>$vPrincipalNama, 'kVP'=>$KVP
                                );
                            $i+=1;
                        }
                        else{
                            $sqlUpline = "SELECT sq.id, sq.nama, sq.upline1, sq.nama_upline1, sq.jabatan_upline1, sq.cabang_upline1, sq.aktif_upline1, sq.upline2, e.nama as nama_upline2, e.position_id as jabatan_upline2, e.b_office_id as cabang_upline2, e.aktif as aktif_upline2,  e.upline_id as upline3 FROM
                                              (SELECT sq.id, sq.nama, sq.upline1, e.nama as nama_upline1, e.position_id as jabatan_upline1, e.b_office_id as cabang_upline1, e.aktif as aktif_upline1, e.upline_id as upline2 FROM 
                                                    (SELECT id, nama, upline_id as upline1 FROM employees 
                                                     WHERE id = ".$agentId.") sq, employees e
                                               WHERE e.id=sq.upline1) sq, employees e
                                        WHERE e.id = sq.upline2";
                            $resultUpline = mysqli_query($link, $sqlUpline);
                            if (!$resultUpline) {
                                die("SQL ERROR.". $sqlUpline);
                            }
                            $rowUpline = mysqli_fetch_array($resultUpline);

                            if($rowUpline['aktif_upline1']==1){
                                $upline1 = $rowUpline['upline1']." - ".$rowUpline['nama_upline1'];
                                if($rowUpline['upline1']==$idVPrincipal){
                                    $upline1 = "NULL - Vice Principal";
                                }
                                if($rowUpline['upline1']==$idPrincipal){
                                    $upline1 = "NULL - Principal";
                                }
                            }
                            else{
                                $upline1 = "NULL - Resign";
                            }
                            if($rowUpline['aktif_upline2']==1){
                                $upline2 = $rowUpline['upline2']." - ".$rowUpline['nama_upline2'];
                                if($rowUpline['upline2']==$idVPrincipal){
                                    $upline2 = "NULL - Vice Principal";
                                }
                                if($rowUpline['upline2']==$idPrincipal){
                                    $upline2 = "NULL - Principal";
                                }
                            }
                            else{
                                $upline2 = "NULL - Resign";
                            }
                            $upline3 = "NULL";

                            $KUP1 = $komisi * ($rowPersen['upline1']/100);
                            $KUP2 = $komisi * ($rowPersen['upline2']/100);
                            $KUP3 = $komisi * ($rowPersen['upline3']/100);
                            $KP = $komisi * ($rowPersen['principal']/100);
                            $KVP = $komisi * ($rowPersen['vice_principal']/100);

                            $rows[] = array(
                                'idA'=>$rowUpline['id']." - ".$rowUpline['nama'], 'komisiA'=>$komisi, 
                                'idUP1'=>$upline1, 'kUP1'=>$KUP1,
                                'idUP2'=>$upline2, 'kUP2'=>$KUP2,
                                'idUP3'=>$upline3, 'kUP3'=>$KUP3,
                                'idP'=>$principalNama, 'kP'=>$KP,
                                'idVP'=>$vPrincipalNama, 'kVP'=>$KVP
                                );
                            $i+=1;
                        }
                    }
                    else{
                        $sqlUpline = "SELECT sq.id, sq.nama, sq.upline1, e.nama as nama_upline1, e.position_id as jabatan_upline1, e.b_office_id as cabang_upline1, e.aktif as aktif_upline1, e.upline_id as upline2 FROM 
                                        (SELECT id, nama, upline_id as upline1 FROM employees 
                                         WHERE id = ".$agentId.") sq, employees e
                                   WHERE e.id=sq.upline1";
                        $resultUpline = mysqli_query($link, $sqlUpline);
                        if (!$resultUpline) {
                            die("SQL ERROR.". $sqlUpline);
                        }
                        $rowUpline = mysqli_fetch_array($resultUpline);

                        if($rowUpline['aktif_upline1']==1){
                                $upline1 = $rowUpline['upline1']." - ".$rowUpline['nama_upline1'];
                                if($rowUpline['upline1']==$idVPrincipal){
                                    $upline1 = "NULL - Vice Principal";
                                }
                                if($rowUpline['upline1']==$idPrincipal){
                                    $upline1 = "NULL - Principal";
                                }
                            }
                        else{
                            $upline1 = "NULL - Resign";
                        }
                        $upline2 = "NULL";
                        $upline3 = "NULL";

                        $KUP1 = $komisi * ($rowPersen['upline1']/100);
                        $KUP2 = $komisi * ($rowPersen['upline2']/100);
                        $KUP3 = $komisi * ($rowPersen['upline3']/100);
                        $KP = $komisi * ($rowPersen['principal']/100);
                        $KVP = $komisi * ($rowPersen['vice_principal']/100);

                        $rows[] = array(
                            'idA'=>$rowUpline['id']." - ".$rowUpline['nama'], 'komisiA'=>$komisi, 
                            'idUP1'=>$upline1, 'kUP1'=>$KUP1,
                            'idUP2'=>$upline2, 'kUP2'=>$KUP2,
                            'idUP3'=>$upline3, 'kUP3'=>$KUP3,
                            'idP'=>$principalNama, 'kP'=>$KP,
                            'idVP'=>$vPrincipalNama, 'kVP'=>$KVP
                            );
                        $i+=1;
                    }
                }
                else{
                    $KUP1 = $komisi * ($rowPersen['upline1']/100);
                    $KUP2 = $komisi * ($rowPersen['upline2']/100);
                    $KUP3 = $komisi * ($rowPersen['upline3']/100);
                    $KP = $komisi * ($rowPersen['principal']/100);
                    $KVP = $komisi * ($rowPersen['vice_principal']/100);

                    $rows[] = array(
                        'idA'=>$rowAgent['id']." - ".$rowAgent['nama'], 'komisiA'=>$komisi, 
                        'idUP1'=>$upline1, 'kUP1'=>$KUP1,
                        'idUP2'=>$upline2, 'kUP2'=>$KUP2,
                        'idUP3'=>$upline3, 'kUP3'=>$KUP3,
                        'idP'=>$principalNama, 'kP'=>$KP,
                        'idVP'=>$vPrincipalNama, 'kVP'=>$KVP
                        );
                    $i+=1;
                }
            }
        echo json_encode($rows);
        }
        break;

    case 'closing':
        $kerja_sama = 0;
        $agentId =0;
        $komisi ='';
        $Tkomisi ='';
        $unit =0;
        $nPisah = $_POST['total_komisi'];
        $pisah = explode('.', $nPisah);
        foreach ($pisah as $p) {
            $Tkomisi = $Tkomisi.''.$p;
        }
        $pos = strpos($Tkomisi, ',');
        if($pos != null){
            $nilai = $Tkomisi;
            $split = explode(',', $nilai);
            $Tkomisi = $split[0] . '.' . $split[1];
        }
        $tgl = $_POST['tanggal_closing'];
        $tgl1 = str_replace('-', '/', $tgl);
        $tglBesok = date('Y-m-d',strtotime($tgl1 . "+1 days"));
        $tipe = $_POST['tipe'];

        foreach ($_POST['closing'] as $row)
        {
            $agentId = $row['id'];
            $sqlTanggalJoin = "SELECT MIN(tanggal) as tanggal FROM hub_positions_employee WHERE employee_id=".$agentId;
            $resultTanggalJoin = mysqli_query($link, $sqlTanggalJoin);
            $rowTanggalJoin = mysqli_fetch_array($resultTanggalJoin);
            $tglAja = explode(' ',$rowTanggalJoin['tanggal']);
            if(strtotime($tglAja[0]) > strtotime($tgl)){
                echo json_encode(1);
                //NOTIFIKASIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIII
                break;
            }
        }

        $sql = "INSERT INTO closing (komisi, tanggal, tipe) VALUE ('" . $Tkomisi . "', '" . $tgl . "', '" . $tipe . "')";
        $result = mysqli_query($link, $sql);
        if (!$result) {
            die("SQL ERROR.". $sql);
        }

        $sqlPajak = "SELECT * FROM percents";
        $resultPajak = mysqli_query($link, $sqlPajak);
        $rowPajak = mysqli_fetch_array($resultPajak);

        $sqlIdClosing = "SELECT max(id) as id FROM closing";
        $resultIdClosing = mysqli_query($link, $sqlIdClosing);
        $rowIdClosing = mysqli_fetch_array($resultIdClosing);

        foreach ($_POST['closing'] as $row)
        {
            $idPrincipal = 0; $idVPrincipal = 0; 
            $kerja_sama += 1;
            $agentId = $row['id'];
            $komisi = '';
            $nilai = $row['jumlah_komisi'];
            $split = explode('.', $nilai);
            foreach ($split as $s) {
                $komisi = $komisi.''.$s;
            }
            $pos = strpos($komisi, ',');
            if($pos != null){
                $nilai = $komisi;
                $split = explode(',', $nilai);
                $komisi = $split[0] . '.' . $split[1];
            }
            $unit = $row['unit'];
            $sqlAgent = "SELECT * FROM employees WHERE id = ".$agentId;
            $resultAgent = mysqli_query($link, $sqlAgent);
            $rowAgent = mysqli_fetch_array($resultAgent);

            $pajak = $komisi*$rowPajak['pajak']/100;
            $upline1 = ($komisi-$pajak)*$rowPajak['upline1']/100;
            $upline2 = ($komisi-$pajak)*$rowPajak['upline2']/100;
            $upline3 = ($komisi-$pajak)*$rowPajak['upline3']/100;
            $vice_principal = ($komisi-$pajak)*$rowPajak['vice_principal']/100;
            $principal = ($komisi-$pajak)*$rowPajak['principal']/100; 

            $sqlInsert = "INSERT INTO hub_closing_employee (komisi, jml_unit, kerja_sama, employee_id, closing_id) VALUE (".$komisi.", ".$unit.", ".$kerja_sama.", " .$agentId.", ".$rowIdClosing['id'].")";
            $resultInsert = mysqli_query($link, $sqlInsert);

            $sqlCekCabangAgent = "SELECT h.branch_id FROM (SELECT MAX(tanggal) as tanggal_akhir FROM `hub_branch_employee` WHERE employee_id=".$agentId." AND tanggal<='".$tglBesok."' ) sq , hub_branch_employee h WHERE h.tanggal = sq.tanggal_akhir";
            $resultCekCabangAgent = mysqli_query($link, $sqlCekCabangAgent);//Cek Cabang Agent pada tanggal Closing
            $rowCekCabangAgent = mysqli_fetch_array($resultCekCabangAgent);
            //CEK Principal 
            $sqlPrincipal = "SELECT * FROM hub_positions_employee WHERE position_id=4 AND tanggal<='".$tglBesok."'";
            $resultPrincipal = mysqli_query($link, $sqlPrincipal);
            while($rowPrincipal=mysqli_fetch_array($resultPrincipal)){
                $sqlCekJabatanTerakhir = "SELECT h.position_id FROM (SELECT MAX(tanggal) as tanggal_akhir FROM `hub_positions_employee` WHERE employee_id=".$rowPrincipal['employee_id']." AND tanggal<='".$tglBesok."' ) sq , hub_positions_employee h WHERE h.tanggal = sq.tanggal_akhir";
                $resultCekJabatanTerakhir = mysqli_query($link, $sqlCekJabatanTerakhir);
                $rowCekJabatanTerakhir = mysqli_fetch_array($resultCekJabatanTerakhir);
                if($rowCekJabatanTerakhir['position_id']==4){
                    $sqlCekCabangPrincipal = "SELECT h.branch_id FROM (SELECT MAX(tanggal) as tanggal_akhir FROM `hub_branch_employee` WHERE employee_id=".$rowPrincipal['employee_id']." AND tanggal<='".$tglBesok."' ) sq , hub_branch_employee h WHERE h.tanggal = sq.tanggal_akhir";
                    $resultCekCabangPrincipal = mysqli_query($link, $sqlCekCabangPrincipal);//Cek Cabang Principal pada tanggal Closing
                    $rowCekCabangPrincipal = mysqli_fetch_array($resultCekCabangPrincipal);
                    if($rowCekCabangPrincipal['branch_id']==$rowCekCabangAgent['branch_id']){
                        $sqlNamaP = "SELECT * FROM employees WHERE id=".$rowPrincipal['employee_id'];
                        $resultNamaP = mysqli_query($link, $sqlNamaP);
                        $rowNamaP = mysqli_fetch_array($resultNamaP);
                        $idPrincipal = $rowNamaP['id'];
                        $sqlInsertKP = "INSERT INTO hub_komisi (pajak, nominal, jenis, kerja_sama, employee_id, closing_id) VALUE (".$pajak.", ".$principal.", 'pasif - principal', ".$kerja_sama.", ".$rowNamaP['id'].", ".$rowIdClosing['id'].")";
                        if($agentId==$rowNamaP['id']){
                            $sqlInsertKP = "SELECT * FROM hub_komisi";
                        }
                        $resultInsertKP = mysqli_query($link, $sqlInsertKP);
                    }
                }
            }//END REGION CEK PRINCIPAL

            //CEK Vice Principal 
            $sqlVicePrincipal = "SELECT * FROM hub_positions_employee WHERE position_id=3 AND tanggal<='".$tglBesok."'";
            $resultVicePrincipal = mysqli_query($link, $sqlVicePrincipal);
            while($rowVicePrincipal=mysqli_fetch_array($resultVicePrincipal)){
                $sqlCekJabatanTerakhirV = "SELECT h.position_id FROM (SELECT MAX(tanggal) as tanggal_akhir FROM `hub_positions_employee` WHERE employee_id=".$rowVicePrincipal['employee_id']." AND tanggal<='".$tglBesok."' ) sq , hub_positions_employee h WHERE h.tanggal = sq.tanggal_akhir";
                $resultCekJabatanTerakhirV = mysqli_query($link, $sqlCekJabatanTerakhirV);
                $rowCekJabatanTerakhirV = mysqli_fetch_array($resultCekJabatanTerakhirV);
                if($rowCekJabatanTerakhirV['position_id']==3){
                    $sqlCekCabangVicePrincipal = "SELECT h.branch_id FROM (SELECT MAX(tanggal) as tanggal_akhir FROM `hub_branch_employee` WHERE employee_id=".$rowVicePrincipal['employee_id']." AND tanggal<='".$tglBesok."' ) sq , hub_branch_employee h WHERE h.tanggal = sq.tanggal_akhir";
                    $resultCekCabangVicePrincipal = mysqli_query($link, $sqlCekCabangVicePrincipal);//Cek Cabang Vice Principal pada tanggal Closing
                    $rowCekCabangVicePrincipal = mysqli_fetch_array($resultCekCabangVicePrincipal);
                    if($rowCekCabangVicePrincipal['branch_id']==$rowCekCabangAgent['branch_id']){
                        $sqlNamaVP = "SELECT * FROM employees WHERE id=".$rowVicePrincipal['employee_id'];
                        $resultNamaVP = mysqli_query($link, $sqlNamaVP);
                        $rowNamaVP = mysqli_fetch_array($resultNamaVP);
                        $idvPrincipal = $rowNamaVP['id'];
                        $sqlInsertKVP = "INSERT INTO hub_komisi (pajak, nominal, jenis, kerja_sama, employee_id, closing_id) VALUE (".$pajak.", ".$vice_principal.", 'pasif - vice principal', ".$kerja_sama.", ".$rowNamaVP['id'].", ".$rowIdClosing['id'].")";
                        if($agentId==$rowNamaVP['id']){
                            $sqlInsertKVP = "SELECT * FROM hub_komisi";
                        }
                        $resultInsertKVP = mysqli_query($link, $sqlInsertKVP);
                    }
                }
            }//END REGION CEK VICE PRINCIPAL

            if($rowAgent['upline_id'] != null){
                $sqlCekUpline2 = "SELECT e.upline_id as upline2 FROM 
                                        (SELECT * FROM employees 
                                         WHERE id = ".$agentId.") sq, employees e
                                   WHERE e.id=sq.upline_id";
                $resultCekUpline2 = mysqli_query($link, $sqlCekUpline2);
                $rowCekUpline2 = mysqli_fetch_array($resultCekUpline2);
                if($rowCekUpline2['upline2'] != null){
                    $sqlCekUpline3 = "SELECT e.upline_id as upline3 FROM
                                         (SELECT e.upline_id as upline2 FROM 
                                            (SELECT * FROM employees 
                                             WHERE id = ".$agentId.") sq, employees e
                                          WHERE e.id=sq.upline_id) sq, employees e
                                      WHERE e.id = sq.upline2";
                    $resultCekUpline3 = mysqli_query($link, $sqlCekUpline3);
                    $rowCekUpline3 = mysqli_fetch_array($resultCekUpline3);
                    if($rowCekUpline3['upline3'] != null){
                        $sqlUpline = "SELECT sq.id, sq.upline1, sq.jabatan_upline1, sq.cabang_upline1, sq.aktif_upline1, sq.upline2, sq.jabatan_upline2, sq.cabang_upline2, sq.aktif_upline2, sq.upline3, e.position_id as jabatan_upline3, e.b_office_id as cabang_upline3, e.aktif as aktif_upline3 FROM
                                            (SELECT sq.id, sq.upline1, sq.jabatan_upline1, sq.cabang_upline1, sq.aktif_upline1, sq.upline2, e.position_id as jabatan_upline2, e.b_office_id as cabang_upline2, e.aktif as aktif_upline2,  e.upline_id as upline3 FROM
                                                  (SELECT sq.id, sq.upline1, e.position_id as jabatan_upline1, e.b_office_id as cabang_upline1, e.aktif as aktif_upline1, e.upline_id as upline2 FROM 
                                                        (SELECT id, upline_id as upline1 FROM employees 
                                                         WHERE id = ".$agentId.") sq, employees e
                                                   WHERE e.id=sq.upline1) sq, employees e
                                            WHERE e.id = sq.upline2) sq, employees e
                                        WHERE e.id = sq.upline3";
                        $resultUpline = mysqli_query($link, $sqlUpline);
                        if (!$resultUpline) {
                            die("SQL ERROR.". $sqlUpline);
                        }
                        $rowUpline = mysqli_fetch_array($resultUpline);

                        $sqlInsertKUP1 = "INSERT INTO hub_komisi (pajak, nominal, jenis, kerja_sama, employee_id, closing_id) VALUE (".$pajak.", ".$upline1.", 'pasif - upline1', ".$kerja_sama.", ".$rowUpline['upline1'].", ".$rowIdClosing['id'].")";
                        $sqlInsertKUP2 = "INSERT INTO hub_komisi (pajak, nominal, jenis, kerja_sama, employee_id, closing_id) VALUE (".$pajak.", ".$upline2.", 'pasif - upline2', ".$kerja_sama.", ".$rowUpline['upline2'].", ".$rowIdClosing['id'].")";
                        $sqlInsertKUP3 = "INSERT INTO hub_komisi (pajak, nominal, jenis, kerja_sama, employee_id, closing_id) VALUE (".$pajak.", ".$upline3.", 'pasif - upline3', ".$kerja_sama.", ".$rowUpline['upline3'].", ".$rowIdClosing['id'].")";
                        
                        //MASUK ke hub_komisi
                        if($rowUpline['aktif_upline1']==1){
                            if($rowUpline['upline1']!=$idVPrincipal && $rowUpline['upline1']!=$idPrincipal){
                                $resultInsertKUP1 = mysqli_query($link, $sqlInsertKUP1);
                            }
                        }
                        if($rowUpline['aktif_upline2']==1){
                            if($rowUpline['upline2']!=$idVPrincipal && $rowUpline['upline2']!=$idPrincipal){
                                $resultInsertKUP2 = mysqli_query($link, $sqlInsertKUP2);
                            }
                        }
                        if($rowUpline['aktif_upline3']==1){
                            if($rowUpline['upline3']!=$idVPrincipal && $rowUpline['upline3']!=$idPrincipal){
                                $resultInsertKUP3 = mysqli_query($link, $sqlInsertKUP3);
                            }
                        }
                    }
                    else{
                        $sqlUpline = "SELECT sq.id, sq.upline1, sq.jabatan_upline1, sq.cabang_upline1, sq.aktif_upline1, sq.upline2, e.position_id as jabatan_upline2, e.b_office_id as cabang_upline2, e.aktif as aktif_upline2,  e.upline_id as upline3 FROM
                                          (SELECT sq.id, sq.upline1, e.position_id as jabatan_upline1, e.b_office_id as cabang_upline1, e.aktif as aktif_upline1, e.upline_id as upline2 FROM 
                                                (SELECT id, upline_id as upline1 FROM employees 
                                                 WHERE id = ".$agentId.") sq, employees e
                                           WHERE e.id=sq.upline1) sq, employees e
                                    WHERE e.id = sq.upline2";
                        $resultUpline = mysqli_query($link, $sqlUpline);
                        if (!$resultUpline) {
                            die("SQL ERROR.". $sqlUpline);
                        }
                        $rowUpline = mysqli_fetch_array($resultUpline);

                        $sqlInsertKUP1 = "INSERT INTO hub_komisi (pajak, nominal, jenis, kerja_sama, employee_id, closing_id) VALUE (".$pajak.", ".$upline1.", 'pasif - upline1', ".$kerja_sama.", ".$rowUpline['upline1'].", ".$rowIdClosing['id'].")";
                        $sqlInsertKUP2 = "INSERT INTO hub_komisi (pajak, nominal, jenis, kerja_sama, employee_id, closing_id) VALUE (".$pajak.", ".$upline2.", 'pasif - upline2', ".$kerja_sama.", ".$rowUpline['upline2'].", ".$rowIdClosing['id'].")";
                        
                        //MASUK ke hub_komisi
                        if($rowUpline['aktif_upline1']==1){
                            if($rowUpline['upline1']!=$idVPrincipal && $rowUpline['upline1']!=$idPrincipal){
                                $resultInsertKUP1 = mysqli_query($link, $sqlInsertKUP1);
                            }
                        }
                        if($rowUpline['aktif_upline2']==1){
                            if($rowUpline['upline2']!=$idVPrincipal && $rowUpline['upline2']!=$idPrincipal){
                                $resultInsertKUP2 = mysqli_query($link, $sqlInsertKUP2);
                            }
                        }
                    }
                }
                else{
                    $sqlUpline = "SELECT sq.id, sq.upline1, e.position_id as jabatan_upline1, e.b_office_id as cabang_upline1, e.aktif as aktif_upline1, e.upline_id as upline2 FROM 
                                        (SELECT id, upline_id as upline1 FROM employees 
                                         WHERE id = ".$agentId.") sq, employees e
                                   WHERE e.id=sq.upline1";
                    $resultUpline = mysqli_query($link, $sqlUpline);
                    if (!$resultUpline) {
                        die("SQL ERROR.". $sqlUpline);
                    }
                    $rowUpline = mysqli_fetch_array($resultUpline);

                    $sqlInsertKUP1 = "INSERT INTO hub_komisi (pajak, nominal, jenis, kerja_sama, employee_id, closing_id) VALUE (".$pajak.", ".$upline1.", 'pasif - upline1', ".$kerja_sama.", ".$rowUpline['upline1'].", ".$rowIdClosing['id'].")";
                    
                    //MASUK ke hub_komisi
                    if($rowUpline['aktif_upline1']==1){
                        if($rowUpline['upline1']!=$idVPrincipal && $rowUpline['upline1']!=$idPrincipal){
                            $resultInsertKUP1 = mysqli_query($link, $sqlInsertKUP1);
                        }
                    }
                }
            }
        }
        break;

    case 'atur_persenan':
        $pajak = $_POST['pajak'];
        $upline1 = $_POST['upline1'];
        $upline2 = $_POST['upline2'];
        $upline3 = $_POST['upline3'];
        $principal = $_POST['principal'];
        $vice_principal = $_POST['vicePrincipal'];
        $tgl = date("Y-m-d");
        $sql = "INSERT INTO percents (pajak, upline1, upline2, upline3, vice_principal, principal, tanggal) VALUE(".$pajak.",".$upline1.",".$upline2.",".$upline3.",".$vice_principal.",".$principal.", '".date("Y-m-d")."')";
        $result = mysqli_query($link, $sql);
        if (!$result) {
            die("SQL ERROR.". $sql);
            header("Location: pengaturan.php");
        }
        else {
            header("Location: pengaturan.php");
        }
        break;

    case 'laporan_rekapitulasi':
        $rows = array();
        $tanggal_awal = $_POST['tanggal_awal'];
        $tanggal_akhir = $_POST['tanggal_akhir'];    
        $cabang = $_POST['cabang'];  

        if($cabang==0){
            $sqlEmployee = "SELECT * FROM employees";
        }
        else{
            $sqlEmployee = "SELECT * FROM employees WHERE b_office_id=".$cabang;
        }
        $resultEmployee = mysqli_query($link, $sqlEmployee);
        while($rowEmployee = mysqli_fetch_array($resultEmployee)){
            $sqlClosing = "SELECT * FROM closing WHERE tanggal between '".$tanggal_awal."' and '".$tanggal_akhir."'";
            $resultClosing = mysqli_query($link, $sqlClosing);
            while($rowClosing=mysqli_fetch_array($resultClosing)){
                $sqlHubClosing = "SELECT * FROM hub_closing_employee WHERE closing_id=".$rowClosing['id'];
                $resultHubClosing = mysqli_query($link, $sqlHubClosing);
                while($rowHubClosing=mysqli_fetch_array($resultHubClosing)){
                    $komisi1=0;$upline11=0;$upline21=0;$upline31=0;$vice_principal1=0;$principal1=0;$total_komisi1=0;
                    $komisi2=0;$upline12=0;$upline22=0;$upline32=0;$vice_principal2=0;$principal2=0;$total_komisi2=0;
                    $komisi3=0;$upline13=0;$upline23=0;$upline33=0;$vice_principal3=0;$principal3=0;$total_komisi3=0;
                    $komisi4=0;$upline14=0;$upline24=0;$upline34=0;$vice_principal4=0;$principal4=0;$total_komisi4=0;
                    if($rowEmployee['id']==$rowHubClosing['employee_id']){
                        $sqlHubKomisi = "SELECT * FROM hub_komisi WHERE closing_id = ".$rowHubClosing['closing_id'];
                        $resultHubKomisi = mysqli_query($link, $sqlHubKomisi);
                        while($rowHubKomisi = mysqli_fetch_array($resultHubKomisi)){
                            if($rowHubClosing['kerja_sama']==1){
                                $komisi1 = $rowHubClosing['komisi'];
                                if($rowHubKomisi['kerja_sama']==1){
                                    if($rowHubKomisi['jenis']=="pasif - upline1"){
                                        $upline11 += $rowHubKomisi['nominal'];
                                    }
                                    else if($rowHubKomisi['jenis']=="pasif - upline2"){
                                        $upline21 += $rowHubKomisi['nominal'];
                                    }
                                    else if($rowHubKomisi['jenis']=="pasif - upline3"){
                                        $upline31 += $rowHubKomisi['nominal'];
                                    }
                                    else if($rowHubKomisi['jenis']=="pasif - vice principal"){
                                        $vice_principal1 += $rowHubKomisi['nominal'];
                                    }
                                    else if($rowHubKomisi['jenis']=="pasif - principal"){
                                        $principal1 += $rowHubKomisi['nominal'];
                                    }
                                }
                            }
                            if($rowHubClosing['kerja_sama']==2){
                                $komisi2 = $rowHubClosing['komisi'];
                                if($rowHubKomisi['kerja_sama']==2){
                                    if($rowHubKomisi['jenis']=="pasif - upline1"){
                                        $upline12 += $rowHubKomisi['nominal'];
                                    }
                                    else if($rowHubKomisi['jenis']=="pasif - upline2"){
                                        $upline22 += $rowHubKomisi['nominal'];
                                    }
                                    else if($rowHubKomisi['jenis']=="pasif - upline3"){
                                        $upline32 += $rowHubKomisi['nominal'];
                                    }
                                    else if($rowHubKomisi['jenis']=="pasif - vice principal"){
                                        $vice_principal2 += $rowHubKomisi['nominal'];
                                    }
                                    else if($rowHubKomisi['jenis']=="pasif - principal"){
                                        $principal2 += $rowHubKomisi['nominal'];
                                    }
                                }
                            }
                            if($rowHubClosing['kerja_sama']==3){
                                $komisi3 = $rowHubClosing['komisi'];
                                if($rowHubKomisi['kerja_sama']==3){
                                    if($rowHubKomisi['jenis']=="pasif - upline1"){
                                        $upline13 += $rowHubKomisi['nominal'];
                                    }
                                    else if($rowHubKomisi['jenis']=="pasif - upline2"){
                                        $upline23+= $rowHubKomisi['nominal'];
                                    }
                                    else if($rowHubKomisi['jenis']=="pasif - upline3"){
                                        $upline33 += $rowHubKomisi['nominal'];
                                    }
                                    else if($rowHubKomisi['jenis']=="pasif - vice principal"){
                                        $vice_principal3 += $rowHubKomisi['nominal'];
                                    }
                                    else if($rowHubKomisi['jenis']=="pasif - principal"){
                                        $principal3 += $rowHubKomisi['nominal'];
                                    }
                                }
                            }
                            if($rowHubClosing['kerja_sama']==4){
                                $komisi4 = $rowHubClosing['komisi'];
                                if($rowHubKomisi['kerja_sama']==4){
                                    if($rowHubKomisi['jenis']=="pasif - upline1"){
                                        $upline14 += $rowHubKomisi['nominal'];
                                    }
                                    else if($rowHubKomisi['jenis']=="pasif - upline2"){
                                        $upline24 += $rowHubKomisi['nominal'];
                                    }
                                    else if($rowHubKomisi['jenis']=="pasif - upline3"){
                                        $upline34 += $rowHubKomisi['nominal'];
                                    }
                                    else if($rowHubKomisi['jenis']=="pasif - vice principal"){
                                        $vice_principal4 += $rowHubKomisi['nominal'];
                                    }
                                    else if($rowHubKomisi['jenis']=="pasif - principal"){
                                        $principal4 += $rowHubKomisi['nominal'];
                                    }
                                }
                            }
                            $total_komisi1 = $komisi1+$upline11+$upline21+$upline31+$vice_principal1+$principal1;
                            $total_komisi2 = $komisi2+$upline12+$upline22+$upline32+$vice_principal2+$principal2;
                            $total_komisi3 = $komisi3+$upline13+$upline23+$upline33+$vice_principal3+$principal3;
                            $total_komisi4 = $komisi4+$upline14+$upline24+$upline34+$vice_principal4+$principal4;
                        }
                    }
                    if($total_komisi1!=0)
                        $rows[] = array('id_closer'=>$rowEmployee['nama']."(".$rowEmployee['id'].")", 'tanggal'=>$rowClosing['tanggal'], 'komisi'=>$komisi1, 'principal'=>$principal1, 'vice_principal'=>$vice_principal1, 'upline1'=>$upline11, 'upline2'=>$upline21, 'upline3'=>$upline31, 'total'=>$total_komisi1);
                    else if($total_komisi2!=0)
                        $rows[] = array('id_closer'=>$rowEmployee['nama']."(".$rowEmployee['id'].")", 'tanggal'=>$rowClosing['tanggal'], 'komisi'=>$komisi2, 'principal'=>$principal2, 'vice_principal'=>$vice_principal2, 'upline1'=>$upline12, 'upline2'=>$upline22, 'upline3'=>$upline32, 'total'=>$total_komisi2);
                    else if($total_komisi3!=0)
                        $rows[] = array('id_closer'=>$rowEmployee['nama']."(".$rowEmployee['id'].")", 'tanggal'=>$rowClosing['tanggal'], 'komisi'=>$komisi3, 'principal'=>$principal3, 'vice_principal'=>$vice_principal3, 'upline1'=>$upline13, 'upline2'=>$upline23, 'upline3'=>$upline33, 'total'=>$total_komisi3);
                    else if($total_komisi4!=0)
                        $rows[] = array('id_closer'=>$rowEmployee['nama']."(".$rowEmployee['id'].")", 'tanggal'=>$rowClosing['tanggal'], 'komisi'=>$komisi4, 'principal'=>$principal4, 'vice_principal'=>$vice_principal4, 'upline1'=>$upline14, 'upline2'=>$upline24, 'upline3'=>$upline34, 'total'=>$total_komisi4);
                }    
            }
        }
                    


        echo json_encode($rows);
        break;

    case 'laporan_pasif':
        $rows = array();
        $tanggal_awal = $_POST['tanggal_awal'];
        $tanggal_akhir = $_POST['tanggal_akhir'];    
        $cabang = $_POST['cabang'];        
        if($cabang == 0){
            $sqlEmployee = "SELECT * FROM employees";
        }
        else{
            $sqlEmployee = "SELECT * FROM employees WHERE b_office_id=".$cabang;   
        }
        $resultEmployee = mysqli_query($link, $sqlEmployee);
        while($rowEmployee=mysqli_fetch_array($resultEmployee)){
            $sqlHubKomisi = "SELECT * FROM hub_komisi WHERE employee_id =".$rowEmployee['id'];
            $resultHubKomisi = mysqli_query($link, $sqlHubKomisi);
            $upline1=0;$upline2=0;$upline3=0;$vice_principal=0;$principal=0;$total_komisi=0;
            if(mysqli_num_rows($resultHubKomisi)>0){
                while($rowHubKomisi=mysqli_fetch_array($resultHubKomisi)){
                    $sqlClosing = "SELECT * FROM closing WHERE tanggal between '".$tanggal_awal."' and '".$tanggal_akhir."'";
                    $resultClosing = mysqli_query($link, $sqlClosing);
                    if(mysqli_num_rows($resultClosing)>0){
                        while($rowClosing=mysqli_fetch_array($resultClosing)){
                            if($rowHubKomisi['closing_id']==$rowClosing['id']){
                                if($rowHubKomisi['jenis']=="pasif - upline1"){
                                    $upline1 += $rowHubKomisi['nominal'];
                                }
                                else if($rowHubKomisi['jenis']=="pasif - upline2"){
                                    $upline2 += $rowHubKomisi['nominal'];
                                }
                                else if($rowHubKomisi['jenis']=="pasif - upline3"){
                                    $upline3 += $rowHubKomisi['nominal'];
                                }
                                else if($rowHubKomisi['jenis']=="pasif - vice principal"){
                                    $vice_principal += $rowHubKomisi['nominal'];
                                }
                                else if($rowHubKomisi['jenis']=="pasif - principal"){
                                    $principal += $rowHubKomisi['nominal'];
                                }
                            }
                        $total_komisi = $upline1+$upline2+$upline3+$vice_principal+$principal;
                        }
                    }
                }
                if($upline1!=0 || $upline2!=0 || $upline3!=0 || $vice_principal!=0 || $principal!=0){
                    $rows[] = array('id'=>$rowEmployee['id'], 'nama'=>$rowEmployee['nama'], 'principal'=>$principal, 'vice_principal'=>$vice_principal, 'upline1'=>$upline1, 'upline2'=>$upline2, 'upline3'=>$upline3, 'total'=>$total_komisi);      
                }
            }
        }
        echo json_encode($rows);
        break;

    case 'laporan_unit':
        $rows = array();
        $tanggal_awal = $_POST['tanggal_awal'];
        $tanggal_akhir = $_POST['tanggal_akhir'];
        $cabang = $_POST['cabang'];
        if($cabang == 0)   
            $sqlEmployee = "SELECT * FROM employees";
        else
            $sqlEmployee = "SELECT * FROM employees WHERE b_office_id=".$cabang;

        $resultEmployee = mysqli_query($link, $sqlEmployee);
        while($rowEmployee=mysqli_fetch_array($resultEmployee)){
            $sqlHubClosing = "SELECT * FROM hub_closing_employee WHERE employee_id=".$rowEmployee['id'];
            $resultHubClosing = mysqli_query($link, $sqlHubClosing);
            $total = 0;
            while($rowHubClosing=mysqli_fetch_array($resultHubClosing)){
                $sqlClosing = "SELECT * FROM closing WHERE tanggal between '".$tanggal_awal."' and '".$tanggal_akhir."'";
                $resultClosing = mysqli_query($link, $sqlClosing);
                while($rowClosing=mysqli_fetch_array($resultClosing)){
                    if($rowHubClosing['closing_id']==$rowClosing['id'])
                        $total+=$rowHubClosing['jml_unit'];
                }
            }  
            if($total!=0)
                $rows[] = array('id'=>$rowEmployee['id'], 'nama'=>$rowEmployee['nama'], 'total'=>$total);          
        }
        echo json_encode($rows);
        break;

    case 'laporan_aktif':
        $rows = array();
        $tanggal_awal = $_POST['tanggal_awal'];
        $tanggal_akhir = $_POST['tanggal_akhir'];
        $cabang = $_POST['cabang'];
        if($cabang == 0)   
            $sqlEmployee = "SELECT * FROM employees";
        else
            $sqlEmployee = "SELECT * FROM employees WHERE b_office_id=".$cabang;

        $resultEmployee = mysqli_query($link, $sqlEmployee);
        while($rowEmployee=mysqli_fetch_array($resultEmployee)){
            $sqlHubPosition = "SELECT * FROM hub_positions_employee WHERE employee_id='".$rowEmployee['upline_id']."'";
            $resultHubPosition = mysqli_query($link, $sqlHubPosition);
            $total = 0;
            while($rowHubPosition=mysqli_fetch_array($resultHubPosition)){
                $sqlTanggalJoin = "SELECT * FROM hub_positions_employee WHERE tanggal between '".$tanggal_awal."' and '".$tanggal_akhir."'";
                $resultTanggalJoin = mysqli_query($link, $sqlTanggalJoin);
                while($rowTanggalJoin=mysqli_fetch_array($resultTanggalJoin)){
                    if($rowHubPosition['tanggal']==$rowTanggalJoin['tanggal'])
                        $total+=1;
                }
            }  
            if($total!=0)
                $rows[] = array('id'=>$rowEmployee['id'], 'nama'=>$rowEmployee['nama'], 'total'=>$total);          
        }
        echo json_encode($rows);
        break;

    case 'laporan_komisi':
        $rows = array();
        $tanggal_awal = $_POST['tanggal_awal'];
        $tanggal_akhir = $_POST['tanggal_akhir'];
        $cabang = $_POST['cabang'];
        if($cabang == 0)   
            $sqlEmployee = "SELECT * FROM employees";
        else
            $sqlEmployee = "SELECT * FROM employees WHERE b_office_id=".$cabang;

        $resultEmployee = mysqli_query($link, $sqlEmployee);
        while($rowEmployee=mysqli_fetch_array($resultEmployee)){
            $sqlHubClosing = "SELECT * FROM hub_closing_employee WHERE employee_id=".$rowEmployee['id'];
            $resultHubClosing = mysqli_query($link, $sqlHubClosing);
            $total = 0;
            while($rowHubClosing=mysqli_fetch_array($resultHubClosing)){
                $sqlClosing = "SELECT * FROM closing WHERE tanggal between '".$tanggal_awal."' and '".$tanggal_akhir."'";
                $resultClosing = mysqli_query($link, $sqlClosing);
                while($rowClosing=mysqli_fetch_array($resultClosing)){
                    if($rowHubClosing['closing_id']==$rowClosing['id'])
                        $total+=$rowHubClosing['komisi'];
                }
            }  
            if($total!=0)
                $rows[] = array('id'=>$rowEmployee['id'], 'nama'=>$rowEmployee['nama'], 'total'=>$total);          
        }
        echo json_encode($rows);
        break;

    default:
        die("UNKNOWN");
        break;
}
?>