<?php
require_once '../model/LoaiSpModel.php';
$loaiSp = new LoaiSpModel();
$loaiSp__Get_All = $loaiSp->loaiSp__Get_All();

?>
<div class="main-add">
    <h3 class="section-title">Thêm thuộc tính</h3>
    <form class="form-group" action="pages/chitietsanpham/action.php?req=add" method="post">
        <div class="col">
            <label for="tenthuoctinh" class="form-label">Tên thuộc tính</label>
            <input type="text" class="form-control" id="tenthuoctinh" name="tenthuoctinh" required>
        </div>
        <div class="col">
            <label>Chọn loại sản phẩm:</label>
            <?php foreach ($loaiSp__Get_All as $item) : ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input checkbox" type="radio" id="id_loai<?= $item->id_loai ?>" value="<?= $item->id_loai ?>" name="id_loai" required>
                    <label class="form-check-label" for="id_loai<?= $item->id_loai ?>"><?= $item->tenloai ?></label>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="col">
                <label for="trangthai" class="form-label">Trạng thái</label>
                <select class="form-select " aria-label=".trangthai" id="trangthai" name="trangthai">
                    <option value="1" selected>Hiển thị</option>
                    <option value="0">Tạm ẩn</option>
                </select>
            </div>
            <!-- <div class="col mt-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input checkbox" type="radio" id="is_num_0" value="0" name="is_num" required
                        checked>
                <label class="form-check-label" for="is_num_0">Kiểu chữ</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input checkbox" type="radio" id="is_num_1" value="1" name="is_num"
                    required>
                <label class="form-check-label" for="is_num_1">Kiểu số</label>
            </div>
        </div> -->
        <br />
        <div class="col text-center">
        <button type="submit" class="btn btn-primary">Lưu thông tin</button>
        </div>
    </form>
</div>