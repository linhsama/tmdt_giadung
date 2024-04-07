<?php
require_once '../../../model/ThuongHieuModel.php';
$th = new ThuongHieuModel();

if (isset($_GET['req'])) {
    switch ($_GET['req']) {
        case "add":
            $res = 0;
            $tenth = $_POST['tenth'];
            $trangthai = $_POST['trangthai'];
            $mota = $_POST['mota'] != "" ? $_POST['mota'] : 'Đang cập nhật';
            $res += $th->ThuongHieu__Add($tenth, $mota, $trangthai);
            if ($res != 0) {
                header('location: ../../index.php?pages=thuong-hieu&msg=success');
            } else {
                header('location: ../../index.php?pages=thuong-hieu&msg=error');
            }
            break;

        case "update":
            $res = 0;
            $id_th = $_POST['id_th'];
            $tenth = $_POST['tenth'];
            $trangthai = $_POST['trangthai'];
            $mota = $_POST['mota'];
            $res += $th->ThuongHieu__Update($id_th, $tenth, $mota, $trangthai);
            if ($res != 0) {
                header('location: ../../index.php?pages=thuong-hieu&msg=success');
            } else {
                header('location: ../../index.php?pages=thuong-hieu&msg=error');
            }
            break;

        case "delete":
            $res = 0;
            $id_th = $_GET['id_th'];
            $res += $th->ThuongHieu__Delete($id_th);
            if ($res != 0) {
                header('location: ../../index.php?pages=thuong-hieu&msg=success');
            } else {
                header('location: ../../index.php?pages=thuong-hieu&msg=error');
            }
            break;
        default:
            break;
    }
}
