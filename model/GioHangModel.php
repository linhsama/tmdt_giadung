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

class GioHangModel extends Database
{

    public function GioHang__Get_All()
    {
        $obj = $this->connect->prepare("SELECT * FROM giohang");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
    public function GioHang__Add($ngaythem, $id_kh, $trangthai)
    {
        $obj = $this->connect->prepare("INSERT INTO giohang(ngaythem, id_kh, trangthai) VALUES (?,?,?)");
        $obj->execute(array($ngaythem, $id_kh, $trangthai));
        return $this->connect->lastInsertId();
    }

    public function GioHang__Update($id_gh, $ngaythem, $id_kh, $trangthai)
    {
        $obj = $this->connect->prepare("UPDATE giohang SET ngaythem=?, id_kh=?, trangthai=? WHERE id_gh=?");
        $obj->execute(array($ngaythem, $id_kh, $trangthai, $id_gh));
        return $obj->rowCount();
    }

    public function GioHang__Update_Trang_Thai($id_gh, $trangthai)
    {
        $obj = $this->connect->prepare("UPDATE giohang SET trangthai=? WHERE id_gh=?");
        $obj->execute(array($trangthai, $id_gh));
        return $obj->rowCount();
    }

    public function GioHang__Delete($id_gh)
    {
        $obj = $this->connect->prepare("DELETE FROM giohang WHERE id_gh = ?");
        $obj->execute(array($id_gh));
        return $obj->rowCount();
    }

    public function GioHang__Get_By_Id($id_gh)
    {
        $obj = $this->connect->prepare("SELECT * FROM giohang WHERE id_gh = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_gh));
        return $obj->fetch();
    }
    public function GioHang__Get_By_Id_Kh($id_kh)
    {
        $obj = $this->connect->prepare("SELECT * FROM giohang WHERE id_kh = ? AND trangthai =1 ORDER BY id_gh DESC LIMIT 1");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_kh));
        return $obj->fetch();
    }
}
