<?php
require_once '../model/ThuoctinhModel.php';
require_once '../model/LoaispModel.php';
$thuoctinh = new ThuoctinhModel();
$loaisp = new LoaiSpModel();
$Thuoctinh__Get_All = $thuoctinh->Thuoctinh__Get_All(-1);
?>

<div id="main-container">
    <div class="main-title">
        <h3>Quản lý thuộc tính</h3>
        <ul class="breadcrumb">
            <li>
                <a href="#">Quản lý thuộc tính</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="index.php?pages=loai-sp">Danh sách thuộc tính</a>
            </li>
        </ul>
    </div>
    <div class="row section-container">
        <div class="col-8">
            <div class="main-data">
                <h3 class="section-title">Danh sách thuộc tính</h3>
                <div class="table-responsive">
                    <table id="table_js" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên thuộc tính</th>
                                <th>Loại sản phẩm</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($Thuoctinh__Get_All as $item) : ?>
                                <tr>
                                    <td><?= $item->id_thuoctinh ?></td>
                                    <td><?= $item->tenthuoctinh ?></td>
                                    <td><?= $loaisp -> LoaiSp__Get_By_Id($item->id_loai)->tenloai?></td>
                                    <td><?= $item->trangthai == 1 ? '<span class="text-success">Hiển thị</span>' : '<span class="text-danger">Tạm ẩn</span>' ?></td>
                                    <td class="text-center font-weight-bold">
                                        <button type="button" class="btn btn-warning btn-update" onclick="return update_obj('<?= $item->id_thuoctinh ?>')">
                                            <i class="bx bx-edit" aria-hidden="true"></i> Sửa
                                        </button>
                                        <?php if (isset($_SESSION['admin'])) : ?>
                                            <button type="button" class="btn btn-danger btn-delete" onclick="return delete_obj('<?= $item->id_thuoctinh ?>')">
                                                <i class="bx bx-trash" aria-hidden="true"></i> Xóa
                                            </button>
                                        <?php endif ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="col-4">
            <div class="main-form">
                <?php require_once 'add.php' ?>
            </div>
        </div>
    </div>
</div>

<script>
    function update_obj(id_thuoctinh) {
        $.post("pages/chitietsanpham/update.php", {
            id_thuoctinh: id_thuoctinh,
        }, function(data, status) {
            $(".main-form").html(data);
        });
    };

    function delete_obj(id_thuoctinh) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "m-2 btn btn-danger",
                cancelButton: "m-2 btn btn-secondary"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: "Xác nhận thao tác",
            text: "Chắc chắn xóa!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Xóa!",
            cancelButtonText: "Hủy!",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = "pages/chitietsanpham/action.php?req=delete&id_thuoctinh=" + id_thuoctinh;
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            );
        });
    };
    window.addEventListener('load', function() {
        document.getElementById('dynamicTitle').innerText = "ADMIN | Quản lý thuộc tính";
    })
</script>