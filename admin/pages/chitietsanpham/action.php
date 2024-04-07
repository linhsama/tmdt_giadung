<?php
require_once '../../../model/ThuoctinhModel.php';
require_once '../../../model/LoaiSpModel.php';
$thuoctinh = new ThuoctinhModel();
$loaisp = new LoaiSpModel();

if (isset($_GET['req'])) {
    switch ($_GET['req']) {
        case "add":
            $res = 0;
            $tenthuoctinh = $_POST['tenthuoctinh'];
            $trangthai = $_POST['trangthai'];
            $id_loai = $_POST['id_loai'];
            // $is_num = $_POST['is_num'];
            $res += $thuoctinh->ThuocTinh__Add($tenthuoctinh, $trangthai, $id_loai);
            if ($res != 0) {
                header('location: ../../index.php?pages=chitietsanpham&msg=success');
            } else {
                header('location: ../../index.php?pages=chitietsanpham&msg=error');
            }
            break;

        case "update":
            $res = 0;
            $id_thuoctinh = $_POST['id_thuoctinh'];
            $tenthuoctinh = $_POST['tenthuoctinh'];
            $trangthai = $_POST['trangthai'];
            $id_loai = $_POST['id_loai'];
            // $is_num = $_POST['is_num'];
            $res += $thuoctinh->ThuocTinh__Update($id_thuoctinh, $tenthuoctinh, $trangthai, $id_loai);
            if ($res != 0) {
                header('location: ../../index.php?pages=chitietsanpham&msg=success');
            } else {
                header('location: ../../index.php?pages=chitietsanpham&msg=error');
            }
            break;

        case "delete":
            $res = 0;
            $id_thuoctinh = $_GET['id_thuoctinh'];
            $res += $thuoctinh->ThuocTinh__Delete($id_thuoctinh);
            if ($res != 0) {
                header('location: ../../index.php?pages=chitietsanpham&msg=success');
            } else {
                header('location: ../../index.php?pages=chitietsanpham&msg=error');
            }
            break;
        default:
            break;
    }
}
