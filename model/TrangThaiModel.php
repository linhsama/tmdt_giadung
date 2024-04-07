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

class TrangThaiModel extends Database
{

    public function TrangThai__Get_All()
    {
        $obj = $this->connect->prepare("SELECT * FROM trangthai");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
  
    public function TrangThai__Add($tentt, $mota)
    {
        $obj = $this->connect->prepare("INSERT INTO trangthai(tentt, mota) VALUES (?,?)");
        $obj->execute(array($tentt, $mota));
        return $obj->rowCount();
    }

    public function TrangThai__Update($id_tt, $tentt, $mota)
    {
        $obj = $this->connect->prepare("UPDATE trangthai SET tentt=?, mota=? WHERE id_tt=?");
        $obj->execute(array($tentt, $mota, $id_tt));
        return $obj->rowCount();
    }

    public function TrangThai__Delete($id_tt)
    {
        $obj = $this->connect->prepare("DELETE FROM trangthai WHERE id_tt = ?");
        $obj->execute(array($id_tt));
        return $obj->rowCount();
    }

    public function TrangThai__Get_By_Id($id_tt)
    {
        $obj = $this->connect->prepare("SELECT * FROM trangthai WHERE id_tt = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_tt));
        return $obj->fetch();
    }

    public function TrangThai__Get_By_Id_DH($id_don)
    {
        $obj = $this->connect->prepare("SELECT * FROM trangthai WHERE id_tt NOT IN (SELECT id_tt FROM chitiettrangthai WHERE id_don = ?)");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_don));
        return $obj->fetchAll();
    }
}