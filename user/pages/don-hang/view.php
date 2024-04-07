<?php
require_once '../../../model/ChiTietDonHangModel.php';
require_once '../../../model/SanPhamModel.php';
$sp = new SanPhamModel();
$ctdh = new ChiTietDonHangModel();
$id_don = $_POST['id_don'];
?>
<table class="table-custom" border="1">
    <thead>
        <tr>
            <th>#</th>
            <th>Tên sản phẩm</th>
            <th></th>
            <th>Số lượng</th>
        </tr>
    </thead>
    <tbody>
        <?php $count= 0; 
        foreach ($ctdh->ChiTietDonHang__Get_By_Id_DH($id_don) as $item) : ?>
            <tr>
                <td width=2% style="padding: 5px; "><?=++$count?></td>
                <td width="70%" style="padding: 5px; "><?= $sp->SanPham__Get_By_Id($item->id_sp)->tensp ?></td>
                <td></td>
                <td width="20%" style="padding: 5px; text-align: center"><?= $item->soluong ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>