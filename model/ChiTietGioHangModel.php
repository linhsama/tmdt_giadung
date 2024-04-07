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

class ChiTietGioHangModel extends Database
{

    public function ChiTietGioHang__Get_All()
    {
        $obj = $this->connect->prepare("SELECT * FROM chitietgiohang");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }

    public function ChiTietGioHang__Add($id_gh, $id_sp, $soluong, $dongia)
    {

        $obj = $this->connect->prepare("INSERT INTO chitietgiohang(id_gh, id_sp, soluong, dongia) VALUES (?,?,?,?)");
        $obj->execute(array($id_gh, $id_sp, $soluong, $dongia));

        return $this->connect->lastInsertId();
    }


    public function ChiTietGioHang__Update($id_ctgh, $id_gh, $id_sp, $soluong, $dongia)
    {
        $obj = $this->connect->prepare("UPDATE chitietgiohang SET id_gh=?, id_sp=?, soluong=?, dongia=? WHERE id_ctgh =?");
        $obj->execute(array($id_gh, $id_sp, $soluong, $dongia, $id_ctgh));
        return $obj->rowCount();
    }


    public function ChiTietGioHang__Delete($id_ctgh)
    {
        $deleteStatement = $this->connect->prepare("DELETE FROM chitietgiohang WHERE id_ctgh=?");
        $deleteStatement->execute(array($id_ctgh));
        return $deleteStatement->rowCount();
    }

    public function ChiTietGioHang__Check($id_gh, $id_sp, $id_kh)
    {
        $obj = $this->connect->prepare("SELECT * FROM chitietgiohang INNER JOIN giohang ON chitietgiohang.id_gh = giohang.id_gh WHERE giohang.id_gh=? AND id_sp=? AND id_kh = ? AND trangthai=?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_gh, $id_sp, $id_kh, 1));
        if ($obj->rowCount() > 0) {
            return $obj->fetch();
        } else {
            return false;
        }
    }
    public function ChiTietGioHang__Get_By_Id($id_ctgh)
    {
        $obj = $this->connect->prepare("SELECT * FROM chitietgiohang WHERE id_ctgh=?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_ctgh));
        return $obj->fetch();
    }
    public function ChiTietGioHang__Sum_Tien_GH($id_gh)
    {
        $obj = $this->connect->prepare("SELECT SUM(soluong * dongia) as sum_tien FROM chitietgiohang WHERE id_gh=?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_gh));
        return $obj->fetch();
    }
    public function ChiTietGioHang__Get_By_Id_GH($id_gh)
    {
        $obj = $this->connect->prepare("SELECT *, (soluong*dongia) as tongcong FROM chitietgiohang WHERE id_gh=?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_gh));
        return $obj->fetchAll();
    }
}
