<?php
require_once '../../../model/AnhSpModel.php';
require_once '../../../model/SanPhamModel.php';
$anhSp = new AnhSpModel();
$sp = new SanPhamModel();
$id_anh = $_POST['id_anh'];
$anhSp__Get_By_Id = $anhSp->AnhSp__Get_By_Id($id_anh);
$id_sp = $anhSp__Get_By_Id->id_sp;
$sanPham__Get_By_Id = $sp->SanPham__Get_By_Id($id_sp);
?>

<div class="main-update">
    <h3 class="section-title">Cập nhật sp nội dung</h3>
    <form class="form-group" action="pages/san-pham/action.php?req=c_update" method="post" enctype="multipart/form-data">
        <input type="hidden" class="form-control" id="anhsp_cu" name="anhsp_cu" required value="<?=$anhSp__Get_By_Id->anhSp?>" readonly>
        <input type="hidden" class="form-control" id="id_anh" name="id_anh" required value="<?=$anhSp__Get_By_Id->id_anh?>" readonly>
        <input type="hidden" class="form-control" id="id_sp" name="id_sp" required value="<?= $id_sp ?>" readonly>
        <div class="col">
            <label for="c_anhsp" class="form-label">Hình ảnh</label>
            <input accept="image/*" type='file' class="form-control" id="anhsp" name="anhsp">
            <div id="anhsp_preview"><img src="../assets/<?=$anhSp__Get_By_Id->hinhanh ?>" alt="<?= $anhSp__Get_By_Id->id_anh ?>" class="img-fluid" width="200"></div>
        </div>
        <div class="col">
            <label for="tensp" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" id="tensp" name="tensp" required value="<?=$sanPham__Get_By_Id->tensp?>" readonly>
        </div>
        <br>
        <div class="col text-center">
            <button type="submit" class="btn btn-primary">Lưu thông tin</button>
            <button type="button" onclick="return location.reload()" class="btn btn-secondary">Hủy</button>
        </div>
    </form>
</div>


<script>

// Lấy ra đối tượng input có id là 'anhsp'
    var anhsp = document.getElementById('anhsp');
    // Lấy ra đối tượng hiển thị ảnh preview có id là 'anhsp_preview'
    var anhsp_preview = document.getElementById('anhsp_preview');

    // Khi giá trị của input 'anhsp' thay đổi
    anhsp.addEventListener('change', function(evt) {
        // Lấy ra mảng các file được chọn trong input
        var [file] = anhsp.files;

        // Kiểm tra xem có file nào được chọn không
        if (file) {
            // Kiểm tra loại MIME của tệp tin
            if (file.type.startsWith('image/')) {
                // Nếu là ảnh, thì hiển thị nó
                var img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.alt = 'anhsp_preview';
                img.style.width = '200px';
                img.style.height = '200px';
                anhsp_preview.innerHTML = '';
                anhsp_preview.appendChild(img);
            } else {
                // Nếu không phải là ảnh, thông báo lỗi
alert('Vui lòng chọn một tệp tin hình ảnh.');
                // Đặt giá trị của input file về rỗng để xóa tệp đã chọn
                anhsp.value = '';
            }
        }
    });
</script>
<?php
require_once '../model/SanPhamModel.php';
require_once '../model/ThuongHieuModel.php';
require_once '../model/AnhSpModel.php';
$sp = new SanPhamModel();
$th = new ThuongHieuModel();
$anhSp = new AnhSpModel();
$sanPham__Get_All = $sp->SanPham__Get_All(-1);
?>

<div id="main-container">
    <div class="main-title">
        <h3>Quản lý sản phẩm</h3>
        <ul class="breadcrumb">
            <li>
                <a href="#">Quản lý sản phẩm</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="index.php?pages=san-pham">Danh sách sản phẩm</a>
            </li>
        </ul>
    </div>
    <div class="row section-container">
        <div class="col-6">
            <div class="main-data">
                <h3 class="section-title">Danh sách sản phẩm</h3>
                <div class="table-responsive">
                    <table id="table_js" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ảnh sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Đơn giá</th>
                                <th>Thương hiệu</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sanPham__Get_All as $item) : ?>
                            <tr>
                                <td><?= $item->id_sp ?></td>
                                <td><img src="../assets/<?= $anhSp->AnhSp__Get_By_Id_Sp_First($item->id_sp)->hinhanh?>" alt=""
                                        srcset="" class="img-fluid" width="100"></td>
                                <td><?= $item->tensp ?></td>
                                <td><?= number_format($item->dongia) ?></td>
                                <td><?= $th->ThuongHieu__Get_By_Id($item->id_th)->tenth ?></td>
                                <td class="text-center font-weight-bold">
                                    <button type="button" class="btn btn-primary btn-update"
                                        onclick="return update_anhsp_obj('<?= $item->id_sp ?>')">
                                        <i class="bx bx-photo-album" aria-hidden="true"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning btn-update"
                                        onclick="return update_obj('<?= $item->id_sp ?>')">
                                        <i class="bx bx-edit" aria-hidden="true"></i>
                                    </button>
                                    <?php if (isset($_SESSION['admin'])) : ?>
                                    <!-- <button type="button" class="btn btn-danger btn-delete"
onclick="return delete_obj('<?= $item->id_sp ?>')">
                                        <i class="bx bx-trash" aria-hidden="true"></i> Xóa
                                    </button> -->
                                    <?php endif ?>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="col-6">
            <div class="main-form">
                <?php require_once 'add.php' ?>
            </div>
        </div>
    </div>
</div>

<script>


function update_anhsp_obj(id_sp) {
    location.href = "index.php?pages=anh-san-pham&id_sp=" + id_sp;
};

function update_obj(id_sp) {
    $.post("pages/san-pham/update.php", {
        id_sp: id_sp,
    }, function(data, status) {
        $(".main-form").html(data);
    });
};

function delete_obj(id_sp) {
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
            location.href = "pages/san-pham/action.php?req=delete&id_sp=" + id_sp;
        } else if (
            result.dismiss === Swal.DismissReason.cancel
        );
    });
};
window.addEventListener('load', function() {
    document.getElementById('dynamicTitle').innerText = "ADMIN | Quản lý sản phẩm";
})

</script>