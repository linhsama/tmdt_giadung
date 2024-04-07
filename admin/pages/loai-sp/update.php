<?php
require_once '../../../model/LoaiSpModel.php';
$loaisp = new LoaiSpModel();
$id_loai = $_POST['id_loai'];
$loaisp__Get_By_Id = $loaisp->LoaiSp__Get_By_Id($id_loai);
?>

<div class="main-update">
    <h3 class="section-title">Cập nhật loại sản phẩm</h3>
    <form class="form-group" action="pages/loai-sp/action.php?req=update" method="post">
        <input type="hidden" class="form-control" id="id_loai" name="id_loai" required value="<?= $loaisp__Get_By_Id->id_loai ?>" readonly>
        <div class="col">
            <label for="tenloai" class="form-label">Tên loại</label>
            <input type="text" class="form-control" id="tenloai" name="tenloai" required value="<?= $loaisp__Get_By_Id->tenloai ?>">
        </div>
        <div class="col">
            <label for="mota" class="form-label">Mô tả</label>
            <textarea class="form-control" id="mota" name="mota" required ><?= $loaisp__Get_By_Id->mota ?></textarea>
        </div>
        <div class="col">
                <label for="trangthai" class="form-label">Trạng thái</label>
                <select class="form-select " aria-label=".trangthai" id="trangthai" name="trangthai">
                    <option value="1" <?= $loaisp__Get_By_Id->trangthai == 1 ? "selected" : "" ?>>Hiển thị</option>
                    <option value="0" <?= $loaisp__Get_By_Id->trangthai == 0 ? "selected" : "" ?>>Tạm ẩn</option>
                </select>
            </div>
        <br />
        <div class="col text-center">
            <button type="submit" class="btn btn-danger">Cập nhật</button>
            <button type="button" onclick="return location.reload()" class="btn btn-secondary">Hủy</button>
        </div>
    </form>
</div>