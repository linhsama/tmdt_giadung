<?php 

require_once '../../../model/DongiaModel.php';

$dg = new DongiaModel();

$id_sp = $_POST['id_sp'];
$donGia__Chart = $dg->DonGia__Chart($id_sp);

?>


<div class="main-chart">
    <canvas id="lineChart"></canvas>
</div>
<div class="main-data">
    <h3 class="section-title">Biến động </h3>
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

</script>
