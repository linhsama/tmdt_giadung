<?php
require_once '../../../model/ThuoctinhModel.php';
$thuoctinh = new ThuoctinhModel();
$id_loai = $_POST['id_loai'];
$tenloai = $_POST['tenloai'];

$thuoctinh__Get_By_Id_Loai = $thuoctinh->Thuoctinh__Get_By_Id_Loai($id_loai);

?>
<?php if(count($thuoctinh__Get_By_Id_Loai) > 0):?>
<div class="form-control">
    <?php foreach($thuoctinh__Get_By_Id_Loai as $item):?>
    <div class="row mt-1 ">
        <div class="col-5 text-end">
            <label for="<?=$item->tenthuoctinh?>" class="form-label"><?=$item->tenthuoctinh?>: </label>
        </div>
        <div class="col-7">
            <input type="hidden" name="id_thuoctinh[]" value="<?=$item->id_thuoctinh?>">
            <input type="<?=$item->is_num == 1?> ? 'number' : 'text'" class="form-control border border-primary"
                id="<?=$item->tenthuoctinh?>" name="noidung[]" required>
        </div>
    </div>
    <?php endforeach?>
</div>
<?php else:?>
<div class="form-control">
    <p class="text-danger">Chưa có thuộc tính cho <b><?=$tenloai?></b>!</p>
</div>

<?php endif?>