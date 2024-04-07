<?php
require_once "../../../model/DongiaModel.php";
$dg = new DongiaModel();

if (isset($_GET["req"])) {
    switch ($_GET["req"]) {

        case "update":
            $res = 0;
            $id_dongia = $_GET["id_dongia"];
            $id_sp = $_GET["id_sp"];

            $res += $dg->Dongia__Update_Checked($id_dongia, $id_sp);
            if ($res != false) {
                $page_pre = explode("pages=",$_SERVER["HTTP_REFERER"])[1]; 
                header("location: ../../index.php?pages=$page_pre&msg=success");
            } else {
                header("location: ../../index.php?pages=$page_pre&msg=error");
            }
            break;

        // case "delete":
        //     $res = 0;
        //     $id_dongia = $_GET["id_dongia"];
        //     $res += $dg->Dongia__Delete($id_dongia);
        //     if ($res != 0) {
        //         header("location: ../../index.php?pages=$page_pre&msg=success");
        //     } else {
        //         header("location: ../../index.php?pages=$page_pre&msg=error");
        //     }
        //     break;
        default:
            break;
    }
}
