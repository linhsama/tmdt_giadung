<?php

$a = "./config/connect.php";
$b = "../config/connect.php";
$c = "../../config/connect.php";
$d = "../../../config/connect.php";
$e = "../../../../config/connect.php";
$f = "../../../../../config/connect.php";

if (file_exists($a)) {
    $des = $a;
}
if (file_exists($b)) {
    $des = $b;
}
if (file_exists($c)) {
    $des = $c;
}
if (file_exists($d)) {
    $des = $d;
}

if (file_exists($e)) {
    $des = $e;
}

if (file_exists($f)) {
    $des = $f;
}
include_once($des);

class TuongTacModel extends Database
{

    public function TuongTac__Get_All()
    {
        $obj = $this->connect->prepare("SELECT * FROM tuong_tac");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }

    function TuongTac__Check_Exist($id_kh, $loaituongtac, $id_sp)
    {
        $sql = "SELECT COUNT(*) as count FROM tuong_tac WHERE id_kh = ? AND loaituongtac = ? AND id_sp = ?";
        $obj = $this->connect->prepare($sql);
        $obj->execute([$id_kh, $loaituongtac, $id_sp]);
        $result = $obj->fetch(PDO::FETCH_ASSOC);

        return $result['count'] > 0;
    }

    // Hàm thêm mới hoặc cập nhật thông tin
    function TuongTac__AddOrUpdate($noidung, $rating, $loaituongtac, $id_sp, $id_kh)
    {
        // Kiểm tra xem thông tin đã tồn tại chưa
        $kiemTraTuongTac = $this->TuongTac__Check_Exist($id_kh, $loaituongtac, $id_sp);

        if (!$kiemTraTuongTac) {
            // Nếu chưa tồn tại, thêm mới thông tin
            $obj = $this->connect->prepare("INSERT INTO tuong_tac(noidung, rating, loaituongtac, id_sp, id_kh) VALUES (?, ?, ?, ?, ?)");
            $obj->execute([$noidung, $rating, $loaituongtac, $id_sp, $id_kh]);
            return $obj->rowCount();
        } else {
            // Nếu đã tồn tại, cập nhật thông tin
            $obj = $this->connect->prepare("UPDATE tuong_tac SET noidung=?, rating=?, id_sp=? WHERE id_kh=? AND loaituongtac=?");
            $obj->execute([$noidung, $rating, $id_sp, $id_kh, $loaituongtac]);
            return $obj->rowCount();
        }
    }
}
