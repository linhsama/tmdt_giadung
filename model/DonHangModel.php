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

class DonHangModel extends Database
{

    public function DonHang__Get_All()
    {
        $obj = $this->connect->prepare("SELECT * FROM donhang");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
    public function DonHang__Add($ngaythem, $id_kh, $tongdh)
    {
        $obj = $this->connect->prepare("INSERT INTO donhang(ngaythem, id_kh, tongdh) VALUES (?,?,?)");
        $obj->execute(array($ngaythem, $id_kh, $tongdh));
        return $this->connect->lastInsertId();
    }

    public function DonHang__Update($id_don, $ngaythem, $id_kh, $tongdh)
    {
        $obj = $this->connect->prepare("UPDATE donhang SET ngaythem=?, id_kh=?, tongdh=? WHERE id_don=?");
        $obj->execute(array($ngaythem, $id_kh, $tongdh, $id_don));
        return $obj->rowCount();
    }

    public function DonHang__Delete($id_don)
    {
        $obj = $this->connect->prepare("DELETE FROM donhang WHERE id_don = ?");
        $obj->execute(array($id_don));
        return $obj->rowCount();
    }

    public function DonHang__Get_By_Id($id_don)
    {
        $obj = $this->connect->prepare("SELECT * FROM donhang WHERE id_don = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_don));
        return $obj->fetch();
    }
    public function DonHang__Get_By_Id_KH($id_kh)
    {
        $obj = $this->connect->prepare("SELECT * FROM donhang WHERE  id_kh =?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_kh));
        return $obj->fetchAll();
    }
}
