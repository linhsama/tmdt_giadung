<?php
require_once '../../../model/ThuoctinhModel.php';
require_once '../../../model/LoaiSpModel.php';
$thuoctinh = new ThuoctinhModel();
$loaisp = new LoaiSpModel();
$id_thuoctinh = $_POST['id_thuoctinh'];
$Thuoctinh__Get_By_Id = $thuoctinh->Thuoctinh__Get_By_Id($id_thuoctinh);
$id_loai = $Thuoctinh__Get_By_Id->id_loai;
$loaisp__Get_By_Id = $loaisp->Loaisp__Get_By_Id($id_loai);
$loaisp__Get_All = $loaisp->LoaiSp__Get_All($id_loai);
?>

<div class="main-update">
    <h3 class="section-title">Cập nhật thuộc tính</h3>
    <form class="form-group" action="pages/chitietsanpham/action.php?req=update" method="post">
        <input type="hidden" class="form-control" id="id_thuoctinh" name="id_thuoctinh" required value="<?= $Thuoctinh__Get_By_Id->id_thuoctinh ?>" readonly>
        <div class="col">
            <label for="tenthuoctinh" class="form-label">Tên thuộc tính</label>
            <input type="text" class="form-control" id="tenthuoctinh" name="tenthuoctinh" required value="<?= $Thuoctinh__Get_By_Id->tenthuoctinh ?>">
        </div>
        <div class="col">
            <label>Chọn loại sản phẩm:</label>
            <?php foreach ($loaisp__Get_All as $item) : ?>
            <div class="form-check form-check-inline">
                <input class="form-check-input checkbox" type="radio" id="id_loai<?= $item->id_loai ?>"
                    value="<?= $item->id_loai ?>" name="id_loai"
                    <?= $item->id_loai == $Thuoctinh__Get_By_Id ->id_loai ? 'checked' : '' ?>>
                <label class="form-check-label" for="id_loai<?= $item->id_loai ?>"><?= $item->tenloai ?></label>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="col">
                <label for="trangthai" class="form-label">Trạng thái</label>
                <select class="form-select " aria-label=".trangthai" id="trangthai" name="trangthai">
                    <option value="1" <?= $Thuoctinh__Get_By_Id->trangthai == 1 ? "selected" : "" ?>>Hiển thị</option>
                    <option value="0" <?= $Thuoctinh__Get_By_Id->trangthai == 0 ? "selected" : "" ?>>Tạm ẩn</option>
                </select>
            </div>
        <!-- <div class="col mt-2">
            <div class="form-check form-check-inline">
                <input class="form-check-input checkbox" type="radio" id="is_num_0" value="0" name="is_num" required
                    <?= $ThuocTinh__Get_By_Id->is_num == 0 ? 'checked' : '' ?>>
                <label class="form-check-label" for="is_num_0">Kiểu chữ</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input checkbox" type="radio" id="is_num_1" value="1" name="is_num" required
                    <?= $ThuocTinh__Get_By_Id->is_num == 1 ? 'checked' : '' ?>>
                <label class="form-check-label" for="is_num_1">Kiểu số</label>
            </div>
        </div> -->
        <br />
        <div class="col text-center">
            <button type="submit" class="btn btn-danger">Cập nhật</button>
            <button type="button" onclick="return location.reload()" class="btn btn-secondary">Hủy</button>
        </div>
    </form>
</div>