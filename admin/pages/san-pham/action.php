<?php
require_once '../../../model/SanPhamModel.php';
require_once '../../../model/AnhSpModel.php';
require_once '../../../model/CommonModel.php';
require_once '../../../model/DongiaModel.php';
require_once '../../../model/ThuocTinhModel.php';
require_once '../../../model/ChitietsanphamModel.php';
$sp = new SanPhamModel();
$anhSp = new AnhSpModel();
$cm = new CommonModel();
$dg = new DongiaModel();
$thuoctinh = new ThuocTinhModel();
$chitietthuoctinh = new chitietspModel();
$defaultImagePath = "uploads/cover.png";

if (isset($_GET['req'])) {
    switch ($_GET['req']) {
        case "add":
            $tensp = $_POST["tensp"];
            $mota = $_POST["mota"];
            $ngaythem = date("Y-m-d H:i:s");
            $trangthai = $_POST["trangthai"];
            $luotmua = 0;
            $id_th = $_POST["id_th"];
            $id_loai = $_POST["id_loai"];

            $id_sp = $sp->SanPham__Add($tensp, $mota, $ngaythem, $trangthai, $luotmua, $id_th, $id_loai);


            $apdung = 1;
            $ghichu = $_POST["ghichu"];
            $giatri = $_POST["giatri"];
            $ngaythang = date('Y-m-d H:i:s');

            $dg->Dongia__Add($ngaythang, $giatri, $id_sp, $apdung, $ghichu);

            $id_thuoctinh = $_POST['id_thuoctinh'];
            $noidung = $_POST['noidung'];
            for ($i = 0; $i < count($id_thuoctinh); $i++) {
                $chitietthuoctinh__Add = $chitietthuoctinh->chitietsp__Add($id_thuoctinh[$i], $id_sp, $noidung[$i]);
            }
            $totalRes = 0;
            // Kiểm tra xem có tệp ảnh đã tải lên không
            if (!empty($_FILES["anhsp"]["name"])) {

                // Tạo một mảng để lưu trữ đường dẫn ảnh cho mỗi sp
                $anhsp = [];

                foreach ($_FILES["anhsp"]["name"] as $key => $filename) {
                    // Xử lý và kiểm tra tệp ảnh
                    $processedImageFilePath = $cm->processAndValidateUploadedFile($_FILES["anhsp"], $id_sp, $key);

                    // Kiểm tra xem xử lý tệp ảnh thành công hay không
                    if ($processedImageFilePath) {
                        // Lưu đường dẫn ảnh vào mảng và thêm vào cơ sở dữ liệu
                        $anhsp[$key] = $processedImageFilePath;
                        $totalRes += $anhSp->AnhSp__Add($processedImageFilePath, $id_sp);
                    } else {
                        // Sử dụng hình ảnh mặc định nếu xử lý thất bại và thêm vào cơ sở dữ liệu
                        $anhsp[$key] = $defaultImagePath;
                        $totalRes += $anhSp->AnhSp__Add($defaultImagePath, $id_sp);
                    }
                }
            } else {
                // Sử dụng hình ảnh mặc định nếu không có tệp ảnh được tải lên và thêm vào cơ sở dữ liệu
                $totalRes += $anhSp->AnhSp__Add($defaultImagePath, $id_sp);
            }

            if ($totalRes > 0 && $id_sp > 0) {
                header("location: ../../index.php?pages=san-pham&msg=success");
                exit();
            } else {
                header("location: ../../index.php?pages=san-pham&msg=error");
                exit();
            }

        case "update":
            $res = 0;
            $id_sp = $_POST['id_sp'];
            $tensp = $_POST["tensp"];
            $mota = $_POST["mota"];
            $ngaythem = date("Y-m-d H:i:s");
            $trangthai = $_POST["trangthai"];
            $luotmua = $_POST["luotmua"];
            $id_th = $_POST["id_th"];
            $id_loai = $_POST["id_loai"];


            $id_chitietsp = $_POST['id_chitietsp'];
            $tenchitietsp = $_POST['tenchitietsp'];
            for ($i = 0; $i < count($id_chitietsp); $i++) {
                $chitietthuoctinh__Update = $chitietthuoctinh->chitietsp__Update($id_chitietsp[$i], $tenchitietsp[$i]);
            }

            $res += $sp->SanPham__Update($id_sp, $tensp, $mota, $ngaythem, $trangthai,  $luotmua,  $id_th, $id_loai);
           
            $apdung = 1;
            $ghichu = $_POST["ghichu"];
            $giatri = $_POST["giatri"];
            $ngaythang = date('Y-m-d H:i:s');

            $dg->Dongia__Update_Apdung($id_sp); // chuyển các dongia cũ thành 0
            $dg->Dongia__Add($ngaythang, $giatri, $id_sp, $apdung, $ghichu);


            if ($res != 0) {
                header('location: ../../index.php?pages=san-pham&msg=success');
            } else {
                header('location: ../../index.php?pages=san-pham&msg=error');
            }
            break;

        case "delete":
            $res = 0;
            $id_sp = $_GET['id_sp'];
            foreach ($anhSp->AnhSp__Get_By_Id_Sp($id_sp) as $item) {
                unlink("../../../assets/" . $item->hinhanh);
                rmdir("../../../assets/uploads/$id_sp");
            }
            $res += $anhSp->AnhSp__Delete_By_Id_Sp($id_sp);
            $res += $sp->SanPham__Delete($id_sp);

            if ($res != 0) {
                header('location: ../../index.php?pages=san-pham&msg=success');
            } else {
                header('location: ../../index.php?pages=san-pham&msg=error');
            }
            break;

            
        case "c_add":
            $id_sp = $_POST["id_sp"];
            $totalRes = 0;
            // Kiểm tra xem có tệp ảnh đã tải lên không
            if (!empty($_FILES["anhsp"]["name"])) {

                // Tạo một mảng để lưu trữ đường dẫn ảnh cho mỗi chapter
                $chapter_noi_dung_images = [];

                foreach ($_FILES["anhsp"]["name"] as $key => $filename) {
                    // Xử lý và kiểm tra tệp ảnh
                    $processedImageFilePath = $cm->processAndValidateUploadedFile($_FILES["anhsp"], $id_sp, $key);

                    // Kiểm tra xem xử lý tệp ảnh thành công hay không
                    if ($processedImageFilePath) {
                        // Lưu đường dẫn ảnh vào mảng và thêm vào cơ sở dữ liệu
                        $chapter_noi_dung_images[$key] = $processedImageFilePath;
                        $totalRes += $anhSp->AnhSp__Add($processedImageFilePath, $id_sp);
                    } else {
                        // Sử dụng hình ảnh mặc định nếu xử lý thất bại và thêm vào cơ sở dữ liệu
                        $chapter_noi_dung_images[$key] = $defaultImagePath;
                        $totalRes += $anhSp->AnhSp__Add($defaultImagePath, $id_sp);
                    }
                }
            } else {
                // Sử dụng hình ảnh mặc định nếu không có tệp ảnh được tải lên và thêm vào cơ sở dữ liệu
                $totalRes += $anhSp->AnhSp__Add($defaultImagePath, $id_sp);
            }


            if ($totalRes > 0) {
                header("Location: ../../index.php?pages=anh-san-pham&id_sp=$id_sp&msg=success");
                exit();
            } else {
                header("Location: ../../index.php?pages=anh-san-pham&id_sp=$id_sp&msg=error");
                exit();
            }


        case "c_update":
            $res = 0;
            $id_anh = $_POST["id_anh"];
            $id_sp = $_POST["id_sp"];
            $anhsp_cu = $_POST['anhsp_cu'];
            // Kiểm tra xem có tệp ảnh đã tải lên không
            if (!empty($_FILES["anhsp"]["name"])) {
                // Kiểm tra và xử lý tệp
                $processedImageFilePath = $cm->processAndValidateUploadedFile($_FILES["anhsp"], $id_sp);

                if ($processedImageFilePath) {
                    // Sử dụng đường dẫn tệp để hiển thị hoặc lưu vào cơ sở dữ liệu
                    $anhsp = $processedImageFilePath;
                } else {
                    // Sử dụng hình ảnh cũ nếu không có tệp ảnh được tải lên
                    $anhsp = $_POST['anhsp_cu'];
                }
            } else {
                // Sử dụng hình ảnh cũ nếu không có tệp ảnh được tải lên
                $anhsp = $_POST['anhsp_cu'];
            }
            // Xóa ảnh nếu đường dẫn tồn tại
            if (file_exists("../../../assets/$anhsp_cu")) {
                unlink("../../../assets/$anhsp_cu");
            }
            $res += $anhSp->AnhSp__Update($id_anh, $anhsp, $id_sp);

            if ($res != 0) {
                header("location: ../../index.php?pages=anh-san-pham&id_sp=$id_sp&msg=success");
            } else {
                header("location: ../../index.php?pages=anh-san-pham&id_sp=$id_sp&msg=error");
            }
            break;

        case "c_delete":
            $res = 0;
            $id_anh = $_GET["id_anh"];
            $id_sp = $anhSp->AnhSp__Get_By_Id($id_anh)->id_sp;
            $anhsp = $anhSp->AnhSp__Get_By_Id($id_anh)->anhsp;
            // Xóa ảnh nếu đường dẫn tồn tại
            if (file_exists("../../../assets/$anhsp")) {
                unlink("../../../assets/$anhsp");
            }
            $res += $anhSp->AnhSp__Delete($id_anh);
            if ($res != 0) {
                header("location: ../../index.php?pages=anh-san-pham&id_sp=$id_sp&msg=success");
            } else {
                header("location: ../../index.php?pages=anh-san-pham&id_sp=$id_sp&msg=error");
            }
            break;

        default:
            break;
    }
}