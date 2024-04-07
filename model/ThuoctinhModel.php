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

class ThuoctinhModel extends Database
{

    public function Thuoctinh__Get_All($trangthai = null)
    {
        if ($trangthai == -1) {
            $obj = $this->connect->prepare("SELECT * FROM  thuoctinhsanpham");
        } else {
            $obj = $this->connect->prepare("SELECT * FROM thuoctinhsanpham WHERE trangthai=1");
        }
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
    public function Thuoctinh__Add($tenthuoctinh, $trangthai, $id_loai)
    {
        $obj = $this->connect->prepare("INSERT INTO  thuoctinhsanpham(tenthuoctinh =?, trangthai =?, id_loai=? ) VALUES (?,?,?)");
        $obj->execute(array($tenthuoctinh, $trangthai, $id_loai));
        return $obj->rowCount();
    }

    public function Thuoctinh__Update($id_thuoctinh, $tenthuoctinh, $trangthai, $id_loai)
    {
        $obj = $this->connect->prepare("UPDATE  thuoctinhsanpham SET tenthuoctinh=?,  trangthai=? , id_loai =? WHERE id_thuoctinh=?");
        $obj->execute(array($tenthuoctinh, $trangthai, $id_thuoctinh, $id_loai));
        return $obj->rowCount();
    }
    public function Thuoctinh__Delete($id_thuoctinh)
    {
        $obj = $this->connect->prepare("DELETE FROM  thuoctinhsanpham WHERE id_thuoctinh = ?");
        $obj->execute(array($id_thuoctinh));
        return $obj->rowCount();
    }

    public function Thuoctinh__Get_By_Id($id_thuoctinh)
    {
        $obj = $this->connect->prepare("SELECT * FROM  thuoctinhsanpham WHERE id_thuoctinh = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_thuoctinh));
        return $obj->fetch();
    }
    public function Thuoctinh__Get_By_Id_Loai($id_loai)
    {
        $obj = $this->connect->prepare("SELECT * FROM  thuoctinhsanpham WHERE id_loai = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_loai));
        return $obj->fetchAll();
    }

}