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

class ChiTietTrangThaiModel extends Database
{

    public function ChiTietTrangThai__Get_All()
    {
        $obj = $this->connect->prepare("SELECT * FROM chitiettrangthai");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
    public function ChiTietTrangThai__Add($id_don, $id_tt, $id_nv, $ngaytao)
    {
        $obj = $this->connect->prepare("INSERT INTO chitiettrangthai(id_don, id_tt, id_nv, ngaytao) VALUES (?,?,?,?)");
        $obj->execute(array($id_don, $id_tt, $id_nv, $ngaytao));
        return $obj->rowCount();
    }

    public function ChiTietTrangThai__Update($id_chitiet, $id_don, $id_tt, $id_nv, $ngaytao)
    {
        $obj = $this->connect->prepare("UPDATE chitiettrangthai SET id_don=?, id_tt=?, id_nv=?, ngaytao=? WHERE id_chitiet=?");
        $obj->execute(array($id_don, $id_tt, $id_nv, $ngaytao, $id_chitiet));
        return $obj->rowCount();
    }
    
    public function ChiTietTrangThai__Delete($id_chitiet)
    {
        $obj = $this->connect->prepare("DELETE FROM chitiettrangthai WHERE id_chitiet = ?");
        $obj->execute(array($id_chitiet));

        return $obj->rowCount();
    }

    public function ChiTietTrangThai__Get_By_Id($id_chitiet)
    {
        $obj = $this->connect->prepare("SELECT * FROM chitiettrangthai WHERE id_chitiet = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_chitiet));
        return $obj->fetch();
    }

    public function ChiTietTrangThai__Get_By_Id_DH($id_don)
    {
        $obj = $this->connect->prepare("SELECT * FROM chitiettrangthai WHERE id_don = ? ORDER BY id_chitiet DESC");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_don));
        return $obj->fetchAll();
    }

    public function ChiTietTrangThai__Get_Last_By_DH($id_don)
    {
        $obj = $this->connect->prepare("SELECT * FROM chitiettrangthai INNER JOIN trangthai ON chitiettrangthai.id_tt = trangthai.id_tt WHERE id_don = ? ORDER BY chitiettrangthai.id_tt DESC LIMIT 1");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_don));
        return $obj->fetch();
    }

    public function ChiTietTrangThai__Get_Sum_Chart()
    {
        $obj = $this->connect->prepare("SELECT *, COUNT(chitiettrangthai.id_don) AS sumtt FROM chitiettrangthai INNER JOIN trangthai ON chitiettrangthai.id_tt = trangthai.id_tt GROUP BY chitiettrangthai.id_tt");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }

    public function ChiTietTrangThai__Check($id_don, $id_tt)
    {
        $obj = $this->connect->prepare("SELECT * FROM chitiettrangthai WHERE id_don = ? AND id_tt=?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_don, $id_tt));
        if($obj->rowCount()>0){
            return $obj->fetch();
        }else{
            return false;
        }
    }
}