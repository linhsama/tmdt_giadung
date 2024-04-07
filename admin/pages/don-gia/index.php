<?php
require_once '../model/DongiaModel.php';
require_once '../model/SanPhamModel.php';

$dgs = new DongiaModel();
$sp = new SanPhamModel();
$Dongia__Get_All = $dgs->Dongia__Get_All(-1);


?>
<style>
    .text_over{
        display: -webkit-box;
        height: auto;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
<div id="main-container">
    <div class="main-title">
        <h3>Quản lý Đơn Giá</h3>
        <ul class="breadcrumb">
            <li>
                <a href="#">Quản lý Đơn Giá</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="index.php?pages=san-pham">Danh sách đơn giá</a>
            </li>
        </ul>
    </div>
    <div class="row section-container">
        <div class="col-8">
            <div class="main-data">
                <h3 class="section-title">Danh sách đơn giá</h3>
                <div class="table-responsive">
                    <table id="table_js" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Giá trị</th>
                                <th>ID sản phẩm</th>
                                <th>Áp dụng</th>
                                <th>Ngày tháng</th>
                                <th>Ghi chú</th>
                                <th>Thao tác</th>
                                <th>Xem thống kê</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($Dongia__Get_All as $item) : ?>
                            <tr>
                                <td><?= $item->id_dongia ?></td>
                                <td><?= $item->giatri ?></td>
                                <td><p class="text_over"><?= $sp->SanPham__Get_By_Id($item->id_sp )->tensp?></p></td>
                                <td><?= $item->apdung ?></td>
                                <td><?= $item->ngaythang ?></td>
                                <td><p class="text_over"><?= $item->ghichu ?> </p></td>
                                <td>
                                    <?php if($item->apdung == 0):?>

                                    <button class="btn btn-sm btn-danger"
                                        onclick="update_checked('<?=$item->id_dongia?>', '<?= $item->id_sp ?>')">Áp dụng
                                        lại</button>

                                    <?php else:?>

                                    <button class="btn btn-sm btn-success"
                                        onclick="update_checked('<?=$item->id_dongia?>', '<?= $item->id_sp ?>')">Đang áp
                                        dụng
                                    </button>

                                    <?php endif?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning"
                                        onclick="view_chart('<?= $item->id_sp ?>')">Xem
                                        chart</button>
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

            </div>

        </div>
    </div>
</div>










<script>
function view_chart(id_sp) {
    $.post("pages/don-gia/chart.php", {
        id_sp: id_sp,
    }, function(data, status) {
        $(".main-form").html(data);
    });
};

function update_obj(id_dongia) {
    $.post("pages/don-gia/update.php", {
        id_dongia: id_dongia,
    }, function(data, status) {
        $(".main-form").html(data);
    });
};

function delete_obj(id_dongia) {
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
            location.href = "pages/don-gia/action.php?req=delete&id_dongia=" + id_dongia;
        } else if (
            result.dismiss === Swal.DismissReason.cancel
        );
    });
};


function update_checked(id_dongia, id_sp) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "m-2 btn btn-danger",
            cancelButton: "m-2 btn btn-secondary"
        },
        buttonsStyling: false
    });
    swalWithBootstrapButtons.fire({
        title: "Xác nhận thao tác",
        text: "Muốn sử dụng lại!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ok!",
        cancelButtonText: "Hủy!",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            location.href = "pages/don-gia/action.php?req=update&id_dongia=" + id_dongia + "&id_sp=" + id_sp;
        } else if (
            result.dismiss === Swal.DismissReason.cancel
        );
    });
};
</script>