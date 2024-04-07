<?php
require_once '../../../model/ChitietsanphamModel.php';
require_once '../../../model/ThuoctinhModel.php';
$thuoctinh = new ThuoctinhModel();
$chitietsp = new chitietspModel();
$id_sp = $_POST['id_sp'];

$chitietsp__Get_By_Id_Sp = $chitietsp->chitietsp__Get_By_Id_Sp($id_sp);

?>
<?php if(count($chitietsp__Get_By_Id_Sp) > 0):?>
<div class="form-control">
    <?php foreach($chitietsp__Get_By_Id_Sp as $item):?>
    <div class="row mt-1 ">
        <div class="col-5 text-end">
            <label for="<?=$item->tenchitietsp?>" class="form-label"><?=$thuoctinh->Thuoctinh__Get_By_Id($item->id_thuoctinh)->tenthuoctinh?>: </label>
        </div>
        <div class="col-7">
            <input type="hidden" name="id_chitietsp[]" value="<?=$item->id_chitietsp?>">
            <input type="<?=$item->is_num == 1?> ? 'number' : 'text'" class="form-control border border-primary"
                id="<?=$item->tenchitietsp?>" name="tenchitietsp[]" required value="<?=$item->tenchitietsp?>">
        </div>
    </div>
    <?php endforeach?>
</div>
<?php else:?>
<div class="form-control">
</div>

<?php endif?>