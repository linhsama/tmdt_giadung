<?php
session_start();
require_once '../../../model/ChiTietTrangThaiModel.php';
$cttt = new ChiTietTrangThaiModel();

if (isset($_GET['req'])) {
    switch ($_GET['req']) {

        case "update":
            $res = 0;
            $id_don = $_POST['id_don'];
            $id_tt = $_POST['id_tt'];
            $id_nv = isset($_SESSION['admin']->id_nv) ? $_SESSION['admin']->id_nv : (isset($_SESSION['nhanvien']->id_nv) ? $_SESSION['nhanvien']->id_nv : $_SESSION['manager']->id_nv);
            $ngaytao = date('Y-m-d H:i:s');
            $res += $cttt->ChiTietTrangThai__Add($id_don, $id_tt, $id_nv, $ngaytao);
            if ($res != 0) {
                header('location: ../../index.php?pages=don-hang&msg=success');
            } else {
                header('location: ../../index.php?pages=don-hang&msg=error');
            }
            break;
        default:
            break;
    }
}
