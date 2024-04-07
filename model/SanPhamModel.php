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

class SanPhamModel extends Database
{

    public function SanPham__Get_All($trangthai)
    {
        if ($trangthai != -1) {
            $obj = $this->connect->prepare("SELECT * FROM sanpham");
        } else {
            $obj = $this->connect->prepare("SELECT * FROM sanpham WHERE trangthai = 1");
        }
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
    public function SanPham__Add($tensp, $mota, $ngaythem, $trangthai, $luotmua, $id_th, $id_loai)
    {
        $obj = $this->connect->prepare("INSERT INTO sanpham(tensp,  mota, ngaythem, trangthai, luotmua, id_th, id_loai) VALUES (?,?,?,?,?,?,?)");
        $obj->execute(array($tensp, $mota, $ngaythem, $trangthai, $luotmua, $id_th, $id_loai));
        return $this->connect->lastInsertId();
    }

    public function SanPham__Update($id_sp, $tensp,$mota, $ngaythem, $trangthai, $luotmua, $id_th, $id_loai)
    {
        $obj = $this->connect->prepare("UPDATE sanpham SET tensp=?, mota=?, ngaythem=?, trangthai=?, luotmua=?, id_th=?, id_loai=? WHERE id_sp=?");
        $obj->execute(array($tensp, $mota, $ngaythem, $trangthai, $luotmua, $id_th, $id_loai, $id_sp));
        return $obj->rowCount();
    }

    public function SanPham__Update_Luot_Mua($id_sp, $luotmua)
    {
        $obj = $this->connect->prepare("UPDATE sanpham SET luotmua=? WHERE id_sp=?");
        $obj->execute(array($luotmua, $id_sp));
        return $obj->rowCount();
    }


    public function SanPham__Delete($id_sp)
    {
        $obj = $this->connect->prepare("DELETE FROM sanpham WHERE id_sp = ?");
        $obj->execute(array($id_sp));

        return $obj->rowCount();
    }

    public function SanPham__Get_By_Id($id_sp)
    {
        $obj = $this->connect->prepare("SELECT * FROM sanpham WHERE id_sp = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_sp));
        return $obj->fetch();
    }


    public function SanPham__Get_Top_Sale()
    {
        $sql = "SELECT * FROM sanpham WHERE trangthai=? ORDER BY luotmua DESC  LIMIT 3";
        $obj = $this->connect->prepare($sql);
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array(1));
        return $obj->fetchAll();
    }

    public function SanPham__Get_Top_Updated($limit = 6)
    {
        $sql = "SELECT * FROM sanpham
        WHERE trangthai=?
        GROUP BY sanpham.id_sp
        ORDER BY ngaythem DESC
        LIMIT $limit";

        $obj = $this->connect->prepare($sql);
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array(1));
        return $obj->fetchAll();
    }
    public function SanPham__Get_Top_Random($limit = 6)
    {
        $sql = "SELECT * FROM sanpham
        WHERE trangthai=?
        ORDER BY RAND()
        LIMIT $limit";

        $obj = $this->connect->prepare($sql);
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array(1));
        return $obj->fetchAll();
    }

    public function SanPham__Get_Top_Same($id_th,  $id_sp)
    {
        $sql = "SELECT * FROM sanpham INNER JOIN thuonghieu ON sanpham.id_th = thuonghieu.id_th WHERE thuonghieu.id_th =? AND sanpham.id_sp !=? AND sanpham.trangthai=1
        ORDER BY RAND()
        LIMIT 6";

        $obj = $this->connect->prepare($sql);
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_th, $id_sp));
        return $obj->fetchAll();
    }
    public function SanPham__Get_Ten_Sp_Paged($page_number, $tensp)
    {
    
        $items_per_page = 12;

        $page_start = ($page_number - 1) * $items_per_page;
        $page_end = $items_per_page;

       
        $obj = $this->connect->prepare(
            "SELECT *
            FROM sanpham
            WHERE trangthai = 1 AND tensp LIKE '%$tensp%'
            GROUP BY id_sp
            LIMIT :page_start, :page_end"
        );

        $obj->bindParam(':page_start', $page_start, PDO::PARAM_INT);
        $obj->bindParam(':page_end', $page_end, PDO::PARAM_INT);

        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
    public function SanPham__Get_All_Paged($page_number)
    {
       
        $items_per_page = 12;

        
        $page_start = ($page_number - 1) * $items_per_page;
        $page_end = $items_per_page;

       
        $obj = $this->connect->prepare(
            "SELECT *
            FROM sanpham
            WHERE trangthai = 1
            GROUP BY id_sp
            LIMIT :page_start, :page_end"
        );

        $obj->bindParam(':page_start', $page_start, PDO::PARAM_INT);
        $obj->bindParam(':page_end', $page_end, PDO::PARAM_INT);

        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }

    public function SanPham__Get_By_Th_Paged($page_number, $id_th)
    {
        
        $items_per_page = 12;

       
        $page_start = ($page_number - 1) * $items_per_page;
        $page_end = $items_per_page;

        
        $obj = $this->connect->prepare(
            "SELECT *
            FROM sanpham
            WHERE trangthai = 1 AND id_th = $id_th
            GROUP BY id_sp
            LIMIT :page_start, :page_end"
        );

        $obj->bindParam(':page_start', $page_start, PDO::PARAM_INT);
        $obj->bindParam(':page_end', $page_end, PDO::PARAM_INT);

        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
    public function SanPham__Get_By_Loai_Paged($page_number, $id_loai)
    {
        
        $items_per_page = 12;

        
        $page_start = ($page_number - 1) * $items_per_page;
        $page_end = $items_per_page;

        $obj = $this->connect->prepare(
            "SELECT *
            FROM sanpham
            WHERE trangthai = 1 AND id_ loai = $id_loai
            GROUP BY id_sp
            LIMIT :page_start, :page_end"
        );

        $obj->bindParam(':page_start', $page_start, PDO::PARAM_INT);
        $obj->bindParam(':page_end', $page_end, PDO::PARAM_INT);

        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
}