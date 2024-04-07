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

class DongiaModel extends Database
{

    public function Dongia__Get_All()
    {
        $obj = $this->connect->prepare("SELECT * FROM Dongia");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
    public function Dongia__Add($ngaythang, $giatri, $id_sp, $apdung, $ghichu)
    {
       
        $obj = $this->connect->prepare("INSERT INTO Dongia(ngaythang, giatri, id_sp, apdung, ghichu) VALUES (?,?,?,?,?)");
        $obj->execute(array($ngaythang, $giatri, $id_sp, $apdung, $ghichu));
      
        return $obj->rowCount();
    }

    public function Dongia__Update($id_dongia, $giatri, $id_sp)
    {
        $obj = $this->connect->prepare("UPDATE Dongia SET giatri=?, id_sp=? WHERE id_dongia=?");
        $obj->execute(array($giatri, $id_sp, $id_dongia));
        return $obj->rowCount();
    }
    public function Dongia__Delete($id_dongia)
    {
        $obj = $this->connect->prepare("DELETE FROM Dongia WHERE id_dongia = ?");
        $obj->execute(array($id_dongia));
        return $obj->rowCount();
    }

    public function Dongia__Delete_By_Id_Sp($id_sp)
    {
        $obj = $this->connect->prepare("DELETE FROM Dongia WHERE id_sp = ?");
        $obj->execute(array($id_sp));
        return $obj->rowCount();
    }


    public function Dongia__Get_By_Id($id_dongia)
    {
        $obj = $this->connect->prepare("SELECT * FROM Dongia WHERE id_dongia = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_dongia));
        return $obj->fetch();
    }

    public function Dongia__Get_By_Id_Sp($id_sp)
    {
        $obj = $this->connect->prepare("SELECT * FROM Dongia WHERE id_sp = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_sp));
        return $obj->fetchAll();
    }

    public function Dongia__Get_By_Id_Sp_First($id_sp)
    {
        $obj = $this->connect->prepare("SELECT * FROM Dongia WHERE id_sp = ? AND apdung= ? ORDER BY id_dongia ASC LIMIT 1");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_sp, 1));
        return $obj->fetch();
    }
    public function Dongia__Get_By_Id_Sp_Not_First($id_sp)
    {
        $id_dongia = $this->Dongia__Get_By_Id_Sp_First($id_sp)->id_dongia;
        $obj = $this->connect->prepare("SELECT * FROM Dongia WHERE id_sp = ? AND id_dongia !=? AND apdung= ? ORDER BY id_dongia ASC");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_sp, 1, $id_dongia));
        return $obj->fetchAll();
    }


    public function Dongia__Update_Apdung($id_sp)
    {
        $obj = $this->connect->prepare("UPDATE Dongia SET apdung=? WHERE id_sp=?");
        $obj->execute(array(0, $id_sp));
        return $obj->rowCount();
    }

    public function Dongia__Update_Checked($id_dongia, $id_sp)
    {
        $this->Dongia__Update_Apdung($id_sp);

        $obj = $this->connect->prepare("UPDATE Dongia SET apdung=? WHERE id_dongia=?");
        $obj->execute(array(1, $id_dongia));
        return $obj->rowCount();
    }

    public function DonGia__Chart($id_sp)
    {
        $obj = $this->connect->prepare("SELECT ngaythang , giatri FROM dongia WHERE id_sp = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_sp));
        return $obj->fetchAll();
    }
}
