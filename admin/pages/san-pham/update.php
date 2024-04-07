<?php
require_once '../../../model/SanPhamModel.php';
require_once '../../../model/ThuongHieuModel.php';
require_once '../../../model/LoaiSpModel.php';
require_once '../../../model/DongiaModel.php';
$loaiSp = new LoaiSpModel();
$sp = new SanPhamModel();
$th = new ThuongHieuModel();
$id_sp = $_POST['id_sp'];
$dg =new DongiaModel();
$sanPham__Get_By_Id = $sp->SanPham__Get_By_Id($id_sp);
$thuongHieu__Get_All = $th->ThuongHieu__Get_All();
$loaiSp__Get_All = $loaiSp->loaiSp__Get_All();
?>

<div class="main-update">
    <h3 class="section-title">Cập nhật sản phẩm</h3>
    <form class="form-group" action="pages/san-pham/action.php?req=update" method="post">
        <input type="hidden" class="form-control" id="id_sp" name="id_sp" required
            value="<?= $sanPham__Get_By_Id->id_sp ?>">
        <div class="col">
            <label for="tensp" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" id="tensp" name="tensp" required
                value="<?= $sanPham__Get_By_Id->tensp ?>">
        </div>

        <div class="row">

            <div class="col">
                <label for="trangthai" class="form-label">Trạng thái</label>
                <select class="form-select " aria-label=".trangthai" id="trangthai" name="trangthai">
                    <option value="1" <?= $sanPham__Get_By_Id->trangthai == 1 ? "selected" : "" ?>>Hiển thị</option>
                    <option value="0" <?= $sanPham__Get_By_Id->trangthai == 0 ? "selected" : "" ?>>Tạm ẩn</option>
                </select>
            </div>
        </div>

        <div class="col">
            <label for="mota" class="form-label">Mô tả</label>
            <textarea class="form-control" id="mota_u" name="mota"><?= $sanPham__Get_By_Id->mota ?></textarea>
        </div>

        <div class="col">
            <label>Chọn thương hiệu:</label>
            <?php foreach ($thuongHieu__Get_All as $item) : ?>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="id_th<?= $item->id_th ?>" value="<?= $item->id_th ?>"
                    name="id_th" <?= $item->id_th == $sanPham__Get_By_Id->id_th ? 'checked' : '' ?>>
                <label class="form-check-label" for="id_th<?= $item->id_th ?>"><?= $item->tenth ?></label>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="col">
            <label>Chọn loại sản phẩm:</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input checkbox" type="radio" id="id_loai<?= $sanPham__Get_By_Id->id_loai ?>"
                    value="<?= $sanPham__Get_By_Id->id_loai ?>" name="id_loai" checked
                    >
                <label class="form-check-label" for="id_loai<?= $sanPham__Get_By_Id->id_loai ?>"><?= $loaiSp->LoaiSp__Get_By_Id($sanPham__Get_By_Id->id_loai)->tenloai ?></label>
            </div>
        </div>
        <div class="col">
            <div class="form-thuoctinh_2"></div>
        </div>
        <div class="col">
            <label for="luotmua" class="form-label">Lượt mua</label>
            <input type="number" min="0" max="1000000000" class="form-control" id="luotmua" name="luotmua" required
                value="<?= $sanPham__Get_By_Id->luotmua ?>" readonly>
        </div>
        <div class="col">
            <label for="giatri" class="form-label">Đơn giá</label>
            <input type="number" min="0" max="1000000000" class="form-control" id="giatri" name="giatri" required
                value="<?= $dg->Dongia__Get_By_Id_Sp_First($sanPham__Get_By_Id->id_sp)->giatri ?>">
        </div>

        <div class="col">
            <label for="ghichu" class="form-label">Ghi chú</label>
            <input type="text" class="form-control" id="ghichu" name="ghichu" required
                value="<?= $dg->Dongia__Get_By_Id_Sp_First($sanPham__Get_By_Id->id_sp)->ghichu?>">
        </div>
        <br />
        <div class="col text-center">
            <button type="submit" class="btn btn-primary">Lưu thông tin</button>
            <button type="button" onclick="return location.reload()" class="btn btn-secondary">Hủy</button>
        </div>
    </form>
</div>
<script>
show_thuoctinh_3('<?=$id_sp ?>')
CKEDITOR.replace('mota_u');


function show_thuoctinh_3(id_sp) {
    $.post("pages/san-pham/thuoctinh_u.php", {
        id_sp: id_sp
    }, function(data, status) {
        $(".form-thuoctinh_2").html(data);
    });
}
</script>