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

class chitietspModel extends Database
{

    public function chitietsp__Get_All()
    {
        $obj = $this->connect->prepare("SELECT * FROM chitietsanpham");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
    public function chitietsp__Add($id_thuoctinh, $id_sp, $tenchitietsp)
    {
        $obj = $this->connect->prepare("INSERT INTO chitietsanpham(id_thuoctinh, id_sp, tenchitietsp) VALUES (?,?,?)");
        $obj->execute(array($id_thuoctinh, $id_sp, $tenchitietsp));
        return $obj->rowCount();
    }

    public function chitietsp__Update($id_chitietsp,$tenchitietsp)
    {
        $obj = $this->connect->prepare("UPDATE chitietsanpham SET tenchitietsp=? WHERE id_chitietsp=?");
        $obj->execute(array( $tenchitietsp, $id_chitietsp));
        return $obj->rowCount();
    }

    public function chitietsp__Delete($id_chitietsp)
    {
        $obj = $this->connect->prepare("DELETE FROM chitietsanpham WHERE id_chitietsp = ?");
        $obj->execute(array($id_chitietsp));

        return $obj->rowCount();
    }

    public function chitietsp__Get_By_Id($id_chitietsp)
    {
        $obj = $this->connect->prepare("SELECT * FROM chitietsanpham WHERE id_chitietsp = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_chitietsp));
        return $obj->fetch();
    }

    public function chitietsp__Get_By_Id_Sp($id_sp)
    {
        $obj = $this->connect->prepare("SELECT * FROM chitietsanpham WHERE id_sp = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_sp));
        return $obj->fetchAll();
    }
}





 
