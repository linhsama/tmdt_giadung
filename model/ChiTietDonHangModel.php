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

class ChiTietDonHangModel extends Database
{

    public function ChiTietDonHang__Get_All()
    {
        $obj = $this->connect->prepare("SELECT * FROM chitietdonhang");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }

    public function ChiTietDonHang__Add($id_don, $id_sp, $soluong, $dongia)
    {
        $obj = $this->connect->prepare("INSERT INTO chitietdonhang(id_don, id_sp, soluong, dongia) VALUES (?,?,?,?)");
        $obj->execute(array($id_don, $id_sp, $soluong, $dongia));

        return $this->connect->lastInsertId();
    }


    public function ChiTietDonHang__Update($id_ctdh, $id_don, $id_sp, $soluong, $dongia)
    {
        $obj = $this->connect->prepare("UPDATE chitietdonhang SET soluong=?, dongia=? WHERE id_ctdh =?");
        $obj->execute(array($soluong, $dongia, $id_don, $id_sp, $id_ctdh));
        return $obj->rowCount();
    }

    public function ChiTietDonHang__Delete($id_ctdh)
    {
        $deleteStatement = $this->connect->prepare("DELETE FROM chitietdonhang WHERE id_ctdh=?");
        $deleteStatement->execute(array($id_ctdh));
        return $deleteStatement->rowCount();
    }
    public function ChiTietDonHang__Delete_By_Id_Dh($id_don)
    {
        $deleteStatement = $this->connect->prepare("DELETE FROM chitietdonhang WHERE id_don=?");
        $deleteStatement->execute(array($id_don));
        return $deleteStatement->rowCount();
    }


    public function ChiTietDonHang__Get_By_Id($id_ctdh)
    {
        $obj = $this->connect->prepare("SELECT * FROM chitietdonhang WHERE id_ctdh=?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_ctdh));
        return $obj->fetch();
    }
    public function ChiTietDonHang__Sum_Tien_DH($id_don)
    {
        $obj = $this->connect->prepare("SELECT SUM(soluong * dongia) as sum_tien FROM chitietdonhang WHERE id_don=?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_don));
        return $obj->fetch();
    }
    public function ChiTietDonHang__Get_By_Id_DH($id_don)
    {
        $obj = $this->connect->prepare("SELECT *, (soluong*dongia) as tongcong FROM chitietdonhang WHERE id_don=?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_don));
        return $obj->fetchAll();
    }

    public function ChiThietDonHang__Top_Ban_Chart()
    {
        $obj = $this->connect->prepare("SELECT sanpham.tensp, SUM(soluong) as sum_soluong FROM chitietdonhang INNER JOIN sanpham ON chitietdonhang.id_sp = sanpham.id_sp GROUP BY chitietdonhang.id_sp ORDER BY chitietdonhang.id_sp DESC LIMIT 10");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array());
        return $obj->fetchAll();
    }

    public function ChiThietDonHang__Doanh_Thu_Chart($startDate, $endDate)
    {
        $obj = $this->connect->prepare("SELECT DATE(donhang.ngaythem) as ngaythem, tongdh AS sum_doanhthu FROM donhang WHERE ngaythem >= (?) AND ngaythem <= (?) GROUP BY id_don ORDER BY id_don");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array(date('Y-m-d 00:00:01', strtotime($startDate)), date('Y-m-d 23:59:59', strtotime($endDate))));
        return $obj->fetchAll();
    }
}
