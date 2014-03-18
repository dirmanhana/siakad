<?php
session_start();
include_once "../dwo.lib.php";
include_once "../db.mysql.php";
include_once "../connectdb.php";
include_once "../parameter.php";
include_once "../cekparam.php";
//include_once "../fpdf.php";

// *** Main ***
$gos = (empty($_REQUEST['gos']))? 'PrvwPngmmn' : $_REQUEST['gos'];
$gos();

function PrvwPngmmn() {
  //TampilkanMdlGrp();
  //$whr = '';
  //$whr .= (empty($_SESSION['mdlgrp']))? '' : "and m.MdlGrpID='$_SESSION[mdlgrp]' ";
  /*$s = "select m.*, mg.Urutan
    from mdl m
    left outer join mdlgrp mg on m.MdlGrpID=mg.MdlGrpID
    where m.MdlID>0 $whr
    order by mg.Urutan, m.Nama";*/
  /*$s = "SELECT pm.*, DATE_FORMAT(pm.TanggalMulai,'".__date_format_mysql__."') AS TanggalMulai, DATE_FORMAT(pm.TanggalSelesai,'".__date_format_mysql__."') AS TanggalSelesai, IF(DATE_FORMAT(pm.TanggalMulai,'".__date_format_mysql__."') > DATE_FORMAT(NOW(),'".__date_format_mysql__."'),1,0) AS Pending
    FROM pengumuman_master pm
    WHERE pm.TanggalEdit IS NULL
    AND pm.LoginEdit IS NULL
    AND DATE_FORMAT(pm.TanggalSelesai,'".__date_format_mysql__."') >= DATE_FORMAT(NOW(),'".__date_format_mysql__."')
    AND DATE_FORMAT(pm.TanggalMulai,'".__date_format_mysql__."') <= DATE_FORMAT(NOW(),'".__date_format_mysql__."')
    AND pm.PengumumanID = ".$_REQUEST['id']."    
    ORDER BY DATE_FORMAT(pm.TanggalMulai,'".__date_format_mysql__."'), pm.Urutan, pm.Judul";
  $r = mysql_query($s) or die("Gagal: $s<br>".mysql_error());
  $n = 0;*/
  //TampilkanMenuModul();
  /*echo "<p><table class=box cellspacing=1 cellpadding=4 align=center width=800>
    <tr><th class=ttl>#</th><th class=ttl>Judul</td>
    <th class=ttl>Konten Pengumuman</th>
    <th class=ttl>Tanggal Mulai</th>
    <th class=ttl>Tanggal Selesai</th>
    </tr>";*/
  $to_be_printed = "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/default/index.css\" />";
  $to_be_printed_script = "<script type=\"text/javascript\">
      function updateHTML(elmId, value) {
        var elem = document.getElementById(elmId);
        if(typeof elem !== 'undefined' && elem !== null) {
          document.getElementById(elmId).innerHTML = value;
        }
      }
      updateHTML('Judul',localStorage[\"PngmmnJudul\"]);
      updateHTML('TanggalMulai',localStorage[\"PngmmnTanggalMulai\"]);
      updateHTML('TanggalSelesai',localStorage[\"PngmmnTanggalSelesai\"]);
      updateHTML('Konten',localStorage[\"PngmmnKonten\"]);
    </script>";
  $to_be_printed .= "<p><table class=box cellspacing=1 cellpadding=4 align=center style=\"table-layout:fixed; width:800px; word-break:break-all; margin-top:20px;\">";
  
    $to_be_printed .= "<tr>
      <td class=ttl align=center width=3%>#</td>  
      <td class=ttl id=\"Judul\"></td>
      <td class=ttl id=\"TanggalMulai\" align=center width=10%></td>
      <td class=ttl id=\"TanggalSelesai\" align=center width=10%></td>
      </tr>
      <tr>
      <td class=ul id=\"Konten\" colspan=4></td>
      </tr>";
    /*      <td $c>$w[MdlGrpID]</td>
      <td $c align=center width=5>
        <a href='?mnux=$_SESSION[mnux]&token=ModNA&mid=$w[MdlID]&BypassMenu=1'><img src='img/book$w[NA].gif'></a>
        </td>*/
  $to_be_printed .= "<tr><td align=right><input type=button class='buttons' name='Tutup' value='Tutup' onClick=\"window.close();\" /></td></tr></table></p>";
  //$to_be_printed = str_replace('{total_pengumuman}', '<b>Jumlah Pengumuman : '.$n.' buah</b>', $to_be_printed);
  echo $to_be_printed.$to_be_printed_script;
}