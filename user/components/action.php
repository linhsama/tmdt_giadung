<?php
session_start();
require_once "../../model/GioHangModel.php";
require_once "../../model/ChiTietGioHangModel.php";
require_once "../../model/DonHangModel.php";
require_once "../../model/ChiTietDonHangModel.php";
require_once "../../model/KhachHangModel.php";
require_once "../../model/SanPhamModel.php";
$kh = new KhachHangModel();
$gh = new GioHangModel();
$ctgh = new ChiTietGioHangModel();
$dh = new DonHangModel();
$ctdh = new ChiTietDonHangModel();
$sp = new SanPhamModel();
if (isset($_POST['action'])) {
    // Xử lý dựa trên action
    switch ($_POST['action']) {
        case 'delete':

            $id_don = $_POST['id_don'];
            $res = $dh->DonHang__Delete($id_don);

            echo $res;
            break;
            
        case 'checkout':
            $id_kh = $_POST['id_kh'];
            $tenkh = $_POST['tenkh'];
            $diachi = $_POST['diachi'];
            $sodienthoai = $_POST['sodienthoai'];
            $email = $_POST['email'];
            $id_gh = $_POST['id_gh'];

            // cập nhật thông tin khách hàng (vì giữ cái liên kết khóa ngoại ở đơn hàng)
            $khRes = $kh->KhachHang__Update_Info($id_kh, $tenkh, $sodienthoai, $diachi, $email);
            $resKh = $kh->KhachHang__Get_By_Id($id_kh);
            $_SESSION['user'] = $resKh;
            // Thêm đơn hàng
            $ngaythem = Date('Y-m-d H:i:s');
            $tongdh = $ctgh->ChiTietGioHang__Sum_Tien_GH($id_gh)->sum_tien;
            $id_dh = $dh->DonHang__Add($ngaythem, $id_kh, $tongdh);

            // Lấy thông tin giỏ hàng
            $ctghRes = $ctgh->ChiTietGioHang__Get_By_Id_GH($id_gh);
            foreach ($ctghRes as $item) {
                $id_sp = $item->id_sp;
                $soluong = $item->soluong;
                $dongia = $item->dongia;
                $luotmua = $sp->SanPham__Get_By_Id($id_sp)->luotmua + 1;
                // Thêm chi tiết đơn hàng
                $resDh = $ctdh->ChiTietDonHang__Add($id_dh, $id_sp, $soluong, $dongia);
                $resSp = $sp->SanPham__Update_Luot_Mua($id_sp, $luotmua);
            }
            $res = $gh->GioHang__Update_Trang_Thai($id_gh, 0);
            if ($res > 0) {
                echo true;
            } else {
                echo false;
            }
            break;
        case 'add':

            $id_sp = $_POST['id_sp'];
            $soluong =  1;
            $dongia = $sp->SanPham__Get_By_Id($id_sp)->dongia;
            $ngaythem = date('Y-m-d H:i:s');
            $id_kh = $_SESSION['user']->id_kh;
            $trangthai = 1; //giỏ hàng đang được tạo, chưa thêm vào đơn hàng
            $resGH = $gh->GioHang__Get_By_Id_Kh($id_kh);
            if (isset($resGH->id_gh)) {
                $check = $ctgh->ChiTietGioHang__Check($resGH->id_gh, $id_sp, $id_kh);
                if ($check != false) {
                    $resCtgh = $ctgh->ChiTietGioHang__Update($check->id_ctgh, $check->id_gh, $id_sp, $check->soluong + 1, $dongia);
                } else {
                    $resCtgh = $ctgh->ChiTietGioHang__Add($resGH->id_gh, $id_sp, $soluong, $dongia);
                }
            } else {
                $id_gh = $gh->GioHang__Add($ngaythem, $id_kh, $trangthai);
                $resCtgh = $ctgh->ChiTietGioHang__Add($id_gh, $id_sp, $soluong, $dongia);
            }

            $id_ghNew = $gh->GioHang__Get_By_Id_Kh($id_kh);
            $res = $ctgh->ChiTietGioHang__Get_By_Id_GH($id_ghNew->id_gh);
            echo count($res);
            break;

        case 'remove':

            $id_ctgh = $_POST['id_ctgh'];
            $res = $ctgh->ChiTietGioHang__Delete($id_ctgh);
            if (isset($ctgh->ChiTietGioHang__Get_By_Id($id_ctgh)->id_gh)) {
                $id_gh = $ctgh->ChiTietGioHang__Get_By_Id($id_ctgh)->id_gh;
                $resid_gh = $gh->GioHang__Get_By_Id($id_gh);
                if (count($resid_gh) > 0) {
                    $resGH = $gh->GioHang__Delete($id_gh);
                }
            }
            echo $res;
            break;
        case 'update':

            $ctgh = $_POST['id_ctgh'];
            $id_gh = $_POST['id_gh'];
            $id_sp = $_POST['id_sp'];
            $soluong = $_POST['soluong'];
            $dongia = $_POST['dongia'];

            $res = $ctgh->ChiTietGioHang__Update($id_ctgh, $id_gh, $id_sp, $soluong, $dongia);
            $sum = $ctgh->ChiTietGioHang__Sum_Tien_GH($id_gh)->sum_tien;
            if ($res > 0) {
                $soluongmoi = $ctgh->ChiTietGioHang__Get_By_Id($id_ctgh)->soluong;
                echo json_encode([
                    "soluong" => $soluongmoi,
                    "tongcong" => number_forid_t($soluongmoi * $dongia),
                    "sum" => number_format($sum),
                ]);
            } else {
                echo json_encode([
                    "soluong" => $soluong,
                    "tongcong" => number_format($soluong * $dongia),
                    "sum" => number_format($sum),
                ]);
            }
            break;
    }
}
