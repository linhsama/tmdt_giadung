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

class AnhSpModel extends Database
{

    public function AnhSp__Get_All()
    {
        $obj = $this->connect->prepare("SELECT * FROM anhsp");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
    public function AnhSp__Add($hinhanh, $id_sp)
    {
        $obj = $this->connect->prepare("INSERT INTO anhsp(hinhanh, id_sp) VALUES (?,?)");
        $obj->execute(array($hinhanh,$id_sp));
        return $obj->rowCount();
    }

    public function AnhSp__Update($id_anh, $hinhanh, $id_sp)
    {
        $obj = $this->connect->prepare("UPDATE anhsp SET hinhanh=?, id_sp=? WHERE id_anh=?");
        $obj->execute(array($hinhanh, $id_sp, $id_anh));
        return $obj->rowCount();
    }
    public function AnhSp__Delete($id_anh)
    {
        $obj = $this->connect->prepare("DELETE FROM anhsp WHERE id_anh = ?");
        $obj->execute(array($id_anh));
        return $obj->rowCount();
    }

    public function AnhSp__Delete_By_Id_Sp($id_sp)
    {
        $obj = $this->connect->prepare("DELETE FROM anhsp WHERE id_sp = ?");
        $obj->execute(array($id_sp));
        return $obj->rowCount();
    }


    public function AnhSp__Get_By_Id($id_anh)
    {
        $obj = $this->connect->prepare("SELECT * FROM anhsp WHERE id_anh = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_anh));
        return $obj->fetch();
    }

    public function AnhSp__Get_By_Id_Sp($id_sp)
    {
        $obj = $this->connect->prepare("SELECT * FROM anhsp WHERE id_sp = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_sp));
        return $obj->fetchAll();
    }

    public function AnhSp__Get_By_Id_Sp_First($id_sp)
    {
        $obj = $this->connect->prepare("SELECT * FROM anhsp WHERE id_sp = ? ORDER BY id_anh ASC LIMIT 1");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_sp));
        return $obj->fetch();
    }
    public function AnhSp__Get_By_Id_Sp_Not_First($id_sp)
    {
        $id_anh = $this->AnhSp__Get_By_Id_Sp_First($id_sp)->id_anh;
        $obj = $this->connect->prepare("SELECT * FROM anhsp WHERE id_sp = ? AND id_anh !=? ORDER BY id_anh ASC");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_sp, $id_anh));
        return $obj->fetchAll();
    }
}
