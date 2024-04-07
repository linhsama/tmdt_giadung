<?php
require_once '../../../model/DongiaModel.php';

$dg = new DongiaModel();

$tensp = $_POST['tensp'];
$id_sp = $_POST['id_sp'];
$dongia__Get_By_Id_Sp = $dg->Dongia__Get_By_Id_Sp($id_sp);
$donGia__Chart = $dg->DonGia__Chart($id_sp);

?>

<div class="main-update">
    <div class="form-control">
    <h5 class="section-title"><?=$tensp?></h5>
    <hr>
        <div class="main-chart">
            <canvas id="lineChart"></canvas>
        </div>
        <div class="main-data">
            <h5 class="section-title">Biến động </h5>
            <div class="table-responsive">
                <table id="" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ngày tháng</th>
                            <th>Đơn giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 0 ?>
                        <?php foreach ($donGia__Chart as $item) : ?>
                        <tr>
                            <td><?= $count++ ?></td>
                            <td><?= date($item->ngaythang, strtotime("d-m-Y")) ?></td>
                            <td><?= number_format($item->giatri)?> đ</td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr>
    <div class="form-control">
        <h5 class="section-title">Thao tác</h5>

        <div class="table-responsive">
            <table id="table_js" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Giá trị</th>
                        <th>Áp dụng</th>
                        <th>Ngày tháng</th>
                        <th>Ghi chú</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dongia__Get_By_Id_Sp as $item) : ?>
                    <tr>
                        <td><?= $item->id_dongia ?></td>
                        <td><?= $item->giatri ?></td>
                        <td><?= $item->apdung ?></td>
                        <td><?= $item->ngaythang ?></td>
                        <td>
                            <p class="text_over"><?= $item->ghichu ?> </p>
                        </td>
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
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="../assets/vendor/chart-js-v4.4.1.js"></script>
<script>
// Line Chart

var ngaythang = <?php echo json_encode(array_column($donGia__Chart, 'ngaythang')); ?>;
var giatri = <?php echo json_encode(array_column($donGia__Chart, 'giatri')); ?>;

var lineChartColors = ['#FF6384', '#36A2EB', '#FFCE56', '#4CAF50', '#FF5733'];

var lineChartCanvas = document.getElementById("lineChart").getContext('2d');
var lineChartData = {
    labels: ngaythang,
    datasets: [{
        data: giatri,
        backgroundColor: lineChartColors,
        borderColor: lineChartColors,
        borderWidth: 1
    }]
};
var lineChartOptions = {
    responsive: true,
    fill: false,
    tension: 0.1
};
var myPieChart = new Chart(lineChartCanvas, {
    type: 'line',
    data: lineChartData,
    options: lineChartOptions
});



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
            location.href = "pages/don-gia/action.php?req=update&id_dongia=" + id_dongia + "&id_sp=" +
                id_sp;
        } else if (
            result.dismiss === Swal.DismissReason.cancel
        );
    });
};
</script>