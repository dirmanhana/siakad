<?php
// Author: Khusnul
// 2014-03-13

$_SESSION['KCFINDER'] = array();
$_SESSION['KCFINDER']['disabled'] = false;
$_SESSION['KCFINDER']['uploadURL'] = "upload/users/" . $_SESSION['_Login'];
$_SESSION['KCFINDER']['uploadDir'] = "";

define(__path_mnux__, 'new_module/pengumuman');
define(__date_format_mysql__, '%d-%m-%Y');
define(__date_format_datepicker__, 'dd-mm-yy');

function TampilanKonten($html_konten, $limit_str = 100) {
    $special_char = array('&nbsp;');
    //$limit_str = 100;
    $open_bracket = '<';
    $close_bracket = '>';
    while (true) {
        $pos_open_bracket = strpos($html_konten, $open_bracket);
        if ($pos_open_bracket === FALSE) {
            break;
        } else {
            $pos_close_bracket = strpos($html_konten, $close_bracket);
            $str_for_replace = substr($html_konten, $pos_open_bracket, ($pos_close_bracket-$pos_open_bracket+1));
            $html_konten = trim(str_replace($str_for_replace, ' ', $html_konten));
        }
    }
    foreach ($special_char as $value) {
        $html_konten = trim(str_replace($value, ' ', $html_konten));
    }
    if (strlen($html_konten) > $limit_str) {
        $html_konten = trim(substr($html_konten, 0, $limit_str));
        $html_konten .= '...';
    }
    return $html_konten;
}

// *** Functions ***
function TampilkanMenuModul() {
  /*$str_menu = "<p align=center><a href=\"?mnux=".__path_mnux__."&token=ExprdPngmmn\">Pengumuman yang Expired</a> |
    <a href=\"?mnux=".__path_mnux__."&token=\">Daftar Pengumuman</a> |
    <a href=\"?mnux=".__path_mnux__."&token=PndngPngmmn\">Pengumuman yang Pending</a> |
    <a href=\"?mnux=".__path_mnux__."&token=PngmmnEdt&md=1\">Tambah Pengumuman</a>
    </p>";*/
  $arr_menu = array(
      array('token' => 'ExprdPngmmn', 'title' => 'Pengumuman yang Expired'),
      array('token' => '', 'title' => 'Daftar Pengumuman'),
      array('token' => 'PndngPngmmn', 'title' => 'Pengumuman yang Pending'),
      //array('token' => 'PngmmnEdt', 'extended' => '&md=1', 'title' => 'Tambah Pengumuman'),
  );
  
  $str_menu = "<p align=center>";
  foreach ($arr_menu as $value) {
      $title = '';
      if (isset($_REQUEST['token'])) {
          if ($value['token'] == $_REQUEST['token']) {
            $title = '<b>'.$value['title'].'</b>';
          } else {
            $title = $value['title'];
          }
      } else {
          $title = $value['title'];
      }
      if (isset($value['extended'])) {
          $token = $value['token'].$value['extended'];
      } else {
          $token = $value['token'];
      }
      $str_menu .= "<a href=\"?mnux=".__path_mnux__."&token=$token\">$title</a> | ";
  }
  $str_menu = trim(substr($str_menu, 0, (strlen($str_menu)-2)));
  $str_menu .= "</p>";
  
  echo $str_menu;
}

function DftrPngmmn() {
  //TampilkanMdlGrp();
  //$whr = '';
  //$whr .= (empty($_SESSION['mdlgrp']))? '' : "and m.MdlGrpID='$_SESSION[mdlgrp]' ";
  /*$s = "select m.*, mg.Urutan
    from mdl m
    left outer join mdlgrp mg on m.MdlGrpID=mg.MdlGrpID
    where m.MdlID>0 $whr
    order by mg.Urutan, m.Nama";*/
  $s = "SELECT pm.*, DATE_FORMAT(pm.TanggalMulai,'".__date_format_mysql__."') AS TanggalMulai, DATE_FORMAT(pm.TanggalSelesai,'".__date_format_mysql__."') AS TanggalSelesai, IF(DATE_FORMAT(pm.TanggalMulai,'".__date_format_mysql__."') > DATE_FORMAT(NOW(),'".__date_format_mysql__."'),1,0) AS Pending
    FROM pengumuman_master pm
    WHERE pm.TanggalEdit IS NULL
    AND pm.LoginEdit IS NULL
    AND DATE_FORMAT(pm.TanggalSelesai,'".__date_format_mysql__."') >= DATE_FORMAT(NOW(),'".__date_format_mysql__."')
    AND DATE_FORMAT(pm.TanggalMulai,'".__date_format_mysql__."') <= DATE_FORMAT(NOW(),'".__date_format_mysql__."')
    ORDER BY DATE_FORMAT(pm.TanggalMulai,'".__date_format_mysql__."'), pm.Urutan, pm.Judul";
  $r = mysql_query($s) or die("Gagal: $s<br>".mysql_error());
  $n = 0;
  TampilkanMenuModul();
  echo "<p><table class=box cellspacing=1 cellpadding=4 align=center style=\"width:800px; word-break:break-all;\">
    <tr><td class=ul1 colspan=4>
    <input type=button name='Refresh' value='Refresh' onClick=\"location='?mnux=".__path_mnux__."&token='\" />
    <input type=button name='Tambah' value='Tambah' onClick=\"location='?mnux=".__path_mnux__."&token=PngmmnEdt&md=1'\" />
    </td><td align='right'><input type=button name='Preview' value='Preview' onClick=\"location='?mnux=".__path_mnux__."&token=PrvwDftrPngmmn'\" />
    </td></tr>
    <tr><th class=ttl>#</th><th class=ttl>Judul</td>
    <th class=ttl>Konten Pengumuman</th>
    <th class=ttl>Tanggal Mulai</th>
    <th class=ttl>Tanggal Selesai</th>
    </tr>";
  while ($w = mysql_fetch_array($r)) {
    $n++;
    $c = ($w['Pending'] == 1)? 'class=nac' : 'class=ul';
    echo "<tr>
      <td $c><a href=\"?mnux=$_SESSION[mnux]&token=PngmmnEdt&md=0&id=$w[PengumumanID]\"><img src='img/edit.png' border=0></a>
      $n</td>
      <td $c>$w[Judul]</td>
      <td $c>".TampilanKonten($w['Konten'])."</td>
      <td $c>$w[TanggalMulai]</td>
      <td $c>$w[TanggalSelesai]</td>
      </tr>";
    /*      <td $c>$w[MdlGrpID]</td>
      <td $c align=center width=5>
        <a href='?mnux=$_SESSION[mnux]&token=ModNA&mid=$w[MdlID]&BypassMenu=1'><img src='img/book$w[NA].gif'></a>
        </td>*/
  }
  echo "</table></p>";
}

function PrvwDftrPngmmn() {
  //TampilkanMdlGrp();
  //$whr = '';
  //$whr .= (empty($_SESSION['mdlgrp']))? '' : "and m.MdlGrpID='$_SESSION[mdlgrp]' ";
  /*$s = "select m.*, mg.Urutan
    from mdl m
    left outer join mdlgrp mg on m.MdlGrpID=mg.MdlGrpID
    where m.MdlID>0 $whr
    order by mg.Urutan, m.Nama";*/
  $s = "SELECT pm.*, DATE_FORMAT(pm.TanggalMulai,'".__date_format_mysql__."') AS TanggalMulai, DATE_FORMAT(pm.TanggalSelesai,'".__date_format_mysql__."') AS TanggalSelesai, IF(DATE_FORMAT(pm.TanggalMulai,'".__date_format_mysql__."') > DATE_FORMAT(NOW(),'".__date_format_mysql__."'),1,0) AS Pending
    FROM pengumuman_master pm
    WHERE pm.TanggalEdit IS NULL
    AND pm.LoginEdit IS NULL
    AND DATE_FORMAT(pm.TanggalSelesai,'".__date_format_mysql__."') >= DATE_FORMAT(NOW(),'".__date_format_mysql__."')
    AND DATE_FORMAT(pm.TanggalMulai,'".__date_format_mysql__."') <= DATE_FORMAT(NOW(),'".__date_format_mysql__."')
    ORDER BY DATE_FORMAT(pm.TanggalMulai,'".__date_format_mysql__."'), pm.Urutan, pm.Judul";
  $r = mysql_query($s) or die("Gagal: $s<br>".mysql_error());
  $n = 0;
  //TampilkanMenuModul();
  /*echo "<p><table class=box cellspacing=1 cellpadding=4 align=center width=800>
    <tr><th class=ttl>#</th><th class=ttl>Judul</td>
    <th class=ttl>Konten Pengumuman</th>
    <th class=ttl>Tanggal Mulai</th>
    <th class=ttl>Tanggal Selesai</th>
    </tr>";*/
  $to_be_printed = "<p><table class=box cellspacing=1 cellpadding=4 align=center style=\"width:800px; word-break:break-all;\">
    <tr><td class=ul1 colspan=3>{total_pengumuman}</td>
    <td align=right><input type=button name='Kembali' value='Kembali' onClick=\"location='?mnux=".__path_mnux__."&token='\" />
    </td></tr>";
  while ($w = mysql_fetch_array($r)) {
    $n++;
    $to_be_printed .= "<tr>
      <td class=ttl align=center width=3%>#$n</td>  
      <td class=ttl>$w[Judul]</td>
      <td class=ttl align=center width=10%>$w[TanggalMulai]</td>
      <td class=ttl align=center width=10%>$w[TanggalSelesai]</td>
      </tr>
      <tr>
      <td class=ul colspan=4>".$w['Konten']."</td>
      </tr>";
    /*      <td $c>$w[MdlGrpID]</td>
      <td $c align=center width=5>
        <a href='?mnux=$_SESSION[mnux]&token=ModNA&mid=$w[MdlID]&BypassMenu=1'><img src='img/book$w[NA].gif'></a>
        </td>*/
  }
  $to_be_printed .= "</table></p>";
  $to_be_printed = str_replace('{total_pengumuman}', '<b>Jumlah Pengumuman : '.$n.' buah</b>', $to_be_printed);
  echo $to_be_printed;
}

function PndngPngmmn() {
  //TampilkanMdlGrp();
  //$whr = '';
  //$whr .= (empty($_SESSION['mdlgrp']))? '' : "and m.MdlGrpID='$_SESSION[mdlgrp]' ";
  /*$s = "select m.*, mg.Urutan
    from mdl m
    left outer join mdlgrp mg on m.MdlGrpID=mg.MdlGrpID
    where m.MdlID>0 $whr
    order by mg.Urutan, m.Nama";*/
  $s = "SELECT pm.*, DATE_FORMAT(pm.TanggalMulai,'".__date_format_mysql__."') AS TanggalMulai, DATE_FORMAT(pm.TanggalSelesai,'".__date_format_mysql__."') AS TanggalSelesai, IF(DATE_FORMAT(pm.TanggalMulai,'".__date_format_mysql__."') > DATE_FORMAT(NOW(),'".__date_format_mysql__."'),1,0) AS Pending
    FROM pengumuman_master pm
    WHERE pm.TanggalEdit IS NULL
    AND pm.LoginEdit IS NULL
    AND DATE_FORMAT(pm.TanggalSelesai,'".__date_format_mysql__."') > DATE_FORMAT(NOW(),'".__date_format_mysql__."')
    AND DATE_FORMAT(pm.TanggalMulai,'".__date_format_mysql__."') > DATE_FORMAT(NOW(),'".__date_format_mysql__."')
    ORDER BY DATE_FORMAT(pm.TanggalMulai,'".__date_format_mysql__."'), pm.Urutan, pm.Judul";
  $r = mysql_query($s) or die("Gagal: $s<br>".mysql_error());
  $n = 0;
  TampilkanMenuModul();
  echo "<p><table class=box cellspacing=1 cellpadding=4 align=center style=\"width:800px; word-break:break-all;\">
    <tr><td class=ul1 colspan=5>
    <input type=button name='Refresh' value='Refresh' onClick=\"location='?mnux=".__path_mnux__."&token=PndngPngmmn'\" />
    <input type=button name='Tambah' value='Tambah' onClick=\"location='?mnux=".__path_mnux__."&token=PngmmnEdt&md=1'\" />
    </td></tr>
    <tr><th class=ttl>#</th><th class=ttl>Judul</td>
    <th class=ttl>Konten Pengumuman</th>
    <th class=ttl>Tanggal Mulai</th>
    <th class=ttl>Tanggal Selesai</th>
    </tr>";
  while ($w = mysql_fetch_array($r)) {
    $n++;
    //$c = ($w['Pending'] == 1)? 'class=nac' : 'class=ul';
    $c = 'class=ul';
    echo "<tr>
      <td $c><a href=\"?mnux=$_SESSION[mnux]&token=PngmmnEdt&md=0&id=$w[PengumumanID]\"><img src='img/edit.png' border=0></a>
      $n</td>
      <td $c>$w[Judul]</td>
      <td $c>".TampilanKonten($w['Konten'])."</td>
      <td $c>$w[TanggalMulai]</td>
      <td $c>$w[TanggalSelesai]</td>
      </tr>";
    /*      <td $c>$w[MdlGrpID]</td>
      <td $c align=center width=5>
        <a href='?mnux=$_SESSION[mnux]&token=ModNA&mid=$w[MdlID]&BypassMenu=1'><img src='img/book$w[NA].gif'></a>
        </td>*/
  }
  echo "</table></p>";
}

function ExprdPngmmn() {
  //TampilkanMdlGrp();
  //$whr = '';
  //$whr .= (empty($_SESSION['mdlgrp']))? '' : "and m.MdlGrpID='$_SESSION[mdlgrp]' ";
  /*$s = "select m.*, mg.Urutan
    from mdl m
    left outer join mdlgrp mg on m.MdlGrpID=mg.MdlGrpID
    where m.MdlID>0 $whr
    order by mg.Urutan, m.Nama";*/
  $s = "SELECT pm.*, DATE_FORMAT(pm.TanggalMulai,'".__date_format_mysql__."') AS TanggalMulai, DATE_FORMAT(pm.TanggalSelesai,'".__date_format_mysql__."') AS TanggalSelesai, IF(DATE_FORMAT(pm.TanggalSelesai,'".__date_format_mysql__."') < DATE_FORMAT(NOW(),'".__date_format_mysql__."'),1,0) AS Expired
    FROM pengumuman_master pm
    WHERE pm.TanggalEdit IS NULL
    AND pm.LoginEdit IS NULL
    AND DATE_FORMAT(pm.TanggalSelesai,'".__date_format_mysql__."') < DATE_FORMAT(NOW(),'".__date_format_mysql__."')
    AND DATE_FORMAT(pm.TanggalMulai,'".__date_format_mysql__."') < DATE_FORMAT(NOW(),'".__date_format_mysql__."')
    ORDER BY DATE_FORMAT(pm.TanggalSelesai,'".__date_format_mysql__."'), pm.Urutan, pm.Judul";
  $r = mysql_query($s) or die("Gagal: $s<br>".mysql_error());
  $n = 0;
  TampilkanMenuModul();
  echo "<p><table class=box cellspacing=1 cellpadding=4 align=center style=\"width:800px; word-break:break-all;\">
    <tr><th class=ttl>#</th><th class=ttl>Judul</td>
    <th class=ttl>Konten Pengumuman</th>
    <th class=ttl>Tanggal Mulai</th>
    <th class=ttl>Tanggal Selesai</th>
    </tr>";
  while ($w = mysql_fetch_array($r)) {
    $n++;
    $c = ($w['Expired'] == 1)? 'class=nac' : 'class=ul';
    echo "<tr>
      <td $c><a href=\"?mnux=$_SESSION[mnux]&token=PngmmnEdt&md=-1&id=$w[PengumumanID]\"><img src='img/edit.png' border=0></a>
      $n</td>
      <td $c>$w[Judul]</td>
      <td $c>".TampilanKonten($w['Konten'])."</td>
      <td $c>$w[TanggalMulai]</td>
      <td $c>$w[TanggalSelesai]</td>
      </tr>";
    /*      <td $c>$w[MdlGrpID]</td>
      <td $c align=center width=5>
        <a href='?mnux=$_SESSION[mnux]&token=ModNA&mid=$w[MdlID]&BypassMenu=1'><img src='img/book$w[NA].gif'></a>
        </td>*/
  }
  echo "</table></p>";
}

function PngmmnEdt() {
  $md = $_REQUEST['md']+0;
  $script_judul = "<input type=text id='Judul' name='Judul' size=120 maxlength=100";
  $disabled = "";
  $script_tombol = "<input type=submit name='Simpan' value='Simpan'>
  <input type=reset name='Reset' value='Reset'>
  <input type=button name='Batal' value='Batal' onClick=\"location='?mnux=".__path_mnux__."&token='\">";
  $w = GetFields('pengumuman_master pm', 'PengumumanID', $_REQUEST['id'], "pm.*, DATE_FORMAT(pm.TanggalMulai,'".__date_format_mysql__."') AS TanggalMulai, DATE_FORMAT(pm.TanggalSelesai,'".__date_format_mysql__."') AS TanggalSelesai, IF(DATE_FORMAT(pm.TanggalSelesai,'".__date_format_mysql__."') < DATE_FORMAT(NOW(),'".__date_format_mysql__."'),1,0) AS Expired");
  if (($md == 0) && ($w['Expired'] == 0)) {
    //$w = GetFields('pengumuman_master pm', 'PengumumanID', $_REQUEST['id'], "pm.*, DATE_FORMAT(pm.TanggalMulai,'".__date_format_mysql__."') AS TanggalMulai, DATE_FORMAT(pm.TanggalSelesai,'".__date_format_mysql__."') AS TanggalSelesai");
    $_grid = "<input type=hidden name='PengumumanID' value='$w[PengumumanID]'>".$script_judul." value=\"$w[Judul]\">";
    $jdl = "Edit Pengumuman";
  }
  else if (($md == -1) || ($w['Expired'] == 1)) {
    //$w = GetFields('pengumuman_master pm', 'PengumumanID', $_REQUEST['id'], "pm.*, DATE_FORMAT(pm.TanggalMulai,'".__date_format_mysql__."') AS TanggalMulai, DATE_FORMAT(pm.TanggalSelesai,'".__date_format_mysql__."') AS TanggalSelesai");
    $disabled = " disabled='disabled' style='background: white;'";
    $_grid = $script_judul." value=\"$w[Judul]\"".$disabled.">";
    $jdl = "Edit Pengumuman";
    $script_tombol = "<input type=button name='Kembali' value='Kembali' onClick=\"location='?mnux=".__path_mnux__."&token=ExprdPngmmn'\">";
  }
  else {
    $w = array();
    $w[Judul] = '';
    $w[Konten] = '';
    $w[Urutan] = 0;
    $_grid = $script_judul.">";
    $jdl = "Tambah Pengumuman";
  }
  $js_script = '';
  if ($disabled == "") {
    $js_script = '$(function() {
      $( "#from" ).datepicker({
        dateFormat: "'.__date_format_datepicker__.'",
        changeMonth: true,
        onClose: function( selectedDate ) {
          var arr = selectedDate.split(\'-\');
          $( "#to" ).datepicker( "option", "minDate", new Date(arr[2],(arr[1]-1),arr[0]) );
        }
      });
      $( "#to" ).datepicker({
        dateFormat: "'.__date_format_datepicker__.'",
        defaultDate: "+1w",
        changeMonth: true,
        onClose: function( selectedDate ) {
          var arr = selectedDate.split(\'-\');
          $( "#from" ).datepicker( "option", "maxDate", new Date(arr[2],(arr[1]-1),arr[0]) );
        }
      });
    });';
  }
  $js_script .= 'CKEDITOR.replace( \'Konten\' );';
  $js_script .= 'function jprvwPngmmn() {
        var orgnl_url = new String(document.location);
        var arr_tmp = orgnl_url.replace("?","").replace("&","").replace("=","").split(\'token\');
        var arr_tmp2 = arr_tmp[0].split(\'mnux\');
        var url = arr_tmp2[0]+arr_tmp2[1]+\'.window.php?gos=PrvwPngmmn\';
        localStorage.clear();
        localStorage.setItem("PngmmnJudul", document.getElementById(\'Judul\').value);
        localStorage.setItem("PngmmnTanggalMulai", document.getElementById(\'TanggalMulai\').value);
        localStorage.setItem("PngmmnTanggalSelesai", document.getElementById(\'TanggalSelesai\').value);
        var editorText = CKEDITOR.instances.Konten.getData();
        localStorage.setItem("PngmmnKonten", editorText);
        localStorage.setItem("PrevUrl", document.location);
        //document.location = url;
        var win = window.open(url,"","width=1024");
        win.focus();
     }';
  $tombol_preview = "</td><td align='right'><input type=button name='Preview' value='Preview' onClick=\"jprvwPngmmn();\">";
  echo "<script type=\"text/javascript\" src=\"include/js/ui.datepicker.js\"></script>
  <link rel=\"stylesheet\" type=\"text/css\" href=\"include/js/ui.datepicker.css\"/>
  <script src=\"include/ckeditor/ckeditor.js\"></script>
  <p><table class=box cellspacing=1 cellpadding=4>
  <form action='?' method=POST>
  <input type=hidden name='mnux' value='".__path_mnux__."'>
  <input type=hidden name='md' value='$md'>
  <input type=hidden name='token' value='PngmmnSav'>
  <tr><th></th><th width=200></th><th></th></tr>
  <tr><th class=ttl colspan=3>$jdl</th></tr>
  <tr><td class=inp1>Judul</td><td class=ul colspan=2>$_grid</td></tr>
  <tr><td class=inp1>Tanggal</td><td class=ul colspan=2><input type=text id='TanggalMulai' name='TanggalMulai' value='$w[TanggalMulai]' id=\"from\" readonly=\"readonly\" ".$disabled."> s.d. <input type=text id='TanggalSelesai' name='TanggalSelesai' value='$w[TanggalSelesai]' id=\"to\" readonly=\"readonly\" ".$disabled."></td></tr>
  <tr><td class=inp1>Urutan</td><td class=ul colspan=2><input type=text id='Urutan' name='Urutan' value='$w[Urutan]' size=5 maxlength=5".$disabled."></td></tr>
  <tr><td class=inp1>Konten</td><td class=ul colspan=2><textarea name='Konten' id='Konten'".$disabled.">$w[Konten]</textarea></td></tr>
  <tr><td colspan=2>".$script_tombol.$tombol_preview."</td></tr>
  </form></table></p>
  <script>
  $js_script
  </script>";
}

function PngmmnSav() {
  $md = $_REQUEST['md'];
  $PengumumanID = $_REQUEST['PengumumanID'];
  $Judul = sqling($_REQUEST['Judul']);
  $Konten = sqling($_REQUEST['Konten']);
  $Urutan = $_REQUEST['Urutan']+0;
    
  if (!empty($PengumumanID)) {
    if ($md == 0) {
      $ada = GetFields('pengumuman_master', 'Judul', $Judul.' AND PengumumanID != '.$PengumumanID, '*');
      if (empty($ada)) {
        $arrMulai = explode('-', $_REQUEST['TanggalMulai']);
        $arrSelesai = explode('-', $_REQUEST['TanggalSelesai']);
        $s = "UPDATE pengumuman_master SET"
                . " Judul='$Judul',"
                . " Konten='$Konten',"
                . " Urutan=$Urutan,"
                . " TanggalSelesai=DATE_ADD(MAKEDATE($arrSelesai[2], $arrSelesai[0]), INTERVAL ($arrSelesai[1]-1) MONTH),"
                . " TanggalMulai=DATE_ADD(MAKEDATE($arrMulai[2], $arrMulai[0]), INTERVAL ($arrMulai[1]-1) MONTH)"
                . " WHERE PengumumanID=$PengumumanID";
        $r = _query($s);
        echo "<script>window.location='?mnux=$_SESSION[mnux]&token='</script>";
      } else {
          echo ErrorMsg("Data Tidak Dapat Disimpan",
            "Judul Pengumuman telah ada.<br/>"
            . "Gunakan Judul lain."
            . "<hr size=1 color=black>"
            . "<a href='?mnux=".__path_mnux__."&token='>Kembali</a>");
      }
    }
  } else if ($md == 1) {
      $ada = GetFields('pengumuman_master', 'Judul', $Judul, '*');
      if (empty($ada)) {
        $arrMulai = explode('-', $_REQUEST['TanggalMulai']);
        $arrSelesai = explode('-', $_REQUEST['TanggalSelesai']);
        $s = "INSERT into pengumuman_master (Judul, Konten, Urutan, TanggalMulai, TanggalSelesai)
          values ('$Judul', '$Konten', $Urutan, DATE_ADD(MAKEDATE($arrMulai[2], $arrMulai[0]), INTERVAL ($arrMulai[1]-1) MONTH), DATE_ADD(MAKEDATE($arrSelesai[2], $arrSelesai[0]), INTERVAL ($arrSelesai[1]-1) MONTH))";
        $r = _query($s);
        echo "<script>window.location='?mnux=$_SESSION[mnux]&token='</script>";
      } else {
          echo ErrorMsg("Data Tidak Dapat Disimpan",
            "Judul Pengumuman telah ada.<br/>"
            . "Gunakan Judul lain."
            . "<hr size=1 color=black>"
            . "<a href='?mnux=".__path_mnux__."&token='>Kembali</a>");
      }
  }
}

function TampilkanMdlGrp() {
//function GetOption2($_table, $_field, $_order='', $_default='', $_where='', $_value='', $not=0) {
  $opt = GetOption2('mdlgrp', "concat(Urutan, '. ', Nama)", 'Urutan', $_SESSION['mdlgrp'], '', 'MdlGrpID');
  echo "<p><table class=box cellspacing=1 cellpadding=4 align=center>
  <form action='?' method=POST>
  <input type=hidden name='mnux' value='".__path_mnux__."'>
  <input type=hidden name='token' value='DftrMdl'>
  <tr><td class=inp1>Group Modul</td><td class=ul><select name='mdlgrp' onChange=\"this.form.submit()\">$opt</select></td></tr>
  </form></table></p>";
}

function ModNA() {
  $mid = $_REQUEST['mid'];
  $m = GetaField('mdl', 'MdlID', $mid, 'NA');
  $NA = ($m['NA'] == 'N')? 'Y' : 'N';
  $s = "update mdl set NA = '$NA' where MdlID = '$mid' ";
  $r = _query($s);
  BerhasilSimpan("?mnux=$_SESSION[mnux]&gos=", 1);
}
function ModEdt() {
  global $_Author, $_AuthorEmail;
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $w = GetFields('mdl', 'MdlID', $_REQUEST['mid'], '*');
    $jdl = 'Edit Modul';
  }
  else {
    $w = array();
    $w['MdlID'] = '';
    $w['MdlGrpID'] = $_SESSION['mdlgrp'];
    $w['Nama'] = '';
    $w['Script'] = '';
    $w['LevelID'] = '.';
    $w['Web'] = 'Y';
    $w['Author'] = $_Author;
    $w['EmailAuthor'] = $_AuthorEmail;
    $w['Simbol'] = '';
    $w['Help'] = '';
    $w['NA'] = 'N';
    $w['Keterangan'] = '';
    $jdl = "Tambah Modul";
  }
  $optgrp = GetOption2('mdlgrp', "concat(MdlGrpID, ' - ', Nama)", 'Nama', $w['MdlGrpID'], '', 'MdlGrpID');
  $na = ($w['NA'] == 'Y')? 'checked' : '';
  $web = ($w['Web'] == 'Y')? 'checked' : '';
  $snm = session_name(); $sid = session_id();
  $DftrLevel = GetDftrLevel($w['LevelID']);
  // Tampilkan form
  echo "<p><table class=box cellspacing=1 cellpadding=4 align=center>
  <form action='?' name='data' method=POST>
  <input type=hidden name='md' value='$md'>
  <input type=hidden name='MdlID' value='$w[MdlID]'>
  <input type=hidden name='mnux' value='".__path_mnux__."'>
  <input type=hidden name='token' value='ModSav'>
  <input type=hidden name='BypassMenu' value='1' />

  <tr><th colspan=3 class=ttl>$jdl</th></tr>
  <tr><td class=inp>Nama</td><td class=ul><input type=text name='Nama' value='$w[Nama]' size=40 maxlength=50></td>
    <td class=ul rowspan=12 valign=bottom>$DftrLevel</td></tr>
  <tr><td class=inp>Group</td><td class=ul><select name='MdlGrpID'>$optgrp</select></td></tr>
  <tr><td class=inp>Script</td><td class=ul><input type=text name='Script' value='$w[Script]' size=40 maxlength=50></td></tr>
  <tr><td class=inp>Level</td><td class=ul><input type=text name='LevelID' value='$w[LevelID]' size=40 maxlength=50></td></tr>
  <tr><td class=inp>Versi Web</td><td class=ul><input type=checkbox name='Web' value='Y' $web></td></tr>
  <tr><td class=inp>Author</td><td class=ul><input type=text name='Author' value='$w[Author]' size=40 maxlength=50></td></tr>
  <tr><td class=inp>Email</td><td class=ul><input type=text name='EmailAuthor' value='$w[EmailAuthor]' size=40 maxlength=50></td></tr>
  <tr><td class=inp>Simbol</td><td class=ul><input type=text name='Simbol' value='$w[Simbol]' size=40 maxlength=50></td></tr>
  <tr><td class=inp>Help</td><td class=ul><input type=text name='Help' value='$w[Help]' size=40 maxlength=50></td></tr>
  <tr><td class=inp>NA (tdk aktif)</td><td class=ul><input type=checkbox name='NA' value='Y' $na></td></tr>
  <tr><td class=inp>Keterangan</td><td class=ul><textarea name='Keterangan' cols=30 rows=3>$w[Keterangan]</textarea></td></tr>
  <tr><td colspan=2 align=center><input type=submit name='Simpan' value='Simpan'>
    <input type=reset name='Reset' value='Reset'>
    <input type=button name='Batal' value='Batal' onClick=\"location='?mnux=".__path_mnux__."'\"></td></tr>
  </form></table></p>";
}
function ModSav() {
  $md = $_REQUEST['md'];
  $MdlID = $_REQUEST['MdlID'];
  $MdlGrpID = $_REQUEST['MdlGrpID'];
  $Nama = sqling($_REQUEST['Nama']);
  $Script = $_REQUEST['Script'];
  $_levelid = TRIM($_REQUEST['LevelID'], '.');
  if (empty($_levelid)) $LevelID = '';
  else {
    $arrLevelID = explode('.', $_levelid);
    sort($arrLevelID);
    $LevelID = '.'.implode('.', $arrLevelID).'.';
  }
  $Web = (!empty($_REQUEST['Web']))? $_REQUEST['Web'] : 'N';
  $Author = sqling($_REQUEST['Author']);
  $EmailAuthor = sqling($_REQUEST['EmailAuthor']);
  $Simbol = $_REQUEST['Simbol'];
  $Help = $_REQUEST['Help'];
  $NA = (!empty($_REQUEST['NA']))? $_REQUEST['NA'] : 'N';
  $Keterangan = sqling($_REQUEST['Keterangan']);
  // Simpan
  if ($md == 0) {
    $s = "update mdl set Nama='$Nama', MdlGrpID='$MdlGrpID', Script='$Script',
      LevelID='$LevelID', Web='$Web',
      Author='$Author', EmailAuthor='$EmailAuthor', Simbol='$Simbol',
      Help='$Help', NA='$NA', Keterangan='$Keterangan'
      where MdlID='$MdlID'";
  }
  else {
    $s = "insert into mdl (MdlGrpID, Nama, Script, LevelID, Web,
      Author, EmailAuthor, Simbol, Help, NA, Keterangan)
      values ('$MdlGrpID', '$Nama', '$Script', '$LevelID', '$Web',
      '$Author', '$EmailAuthor', '$Simbol', '$Help', '$NA', '$Keterangan')";
  }
  _query($s);
  BerhasilSimpan("?mnux=$_SESSION[mnux]&gos=", 100);
}
function GetDftrLevel($lvl='') {
  TulisScriptUbahLevel();
  $s = "select *
    from level
    order by LevelID";
  $r = _query($s);
  $a = '';
  while ($w = _fetch_array($r)) {
    $ck = (strpos($lvl, ".$w[LevelID].") === false)? '' : 'checked';
    $a .= "<input type=checkbox name='Level$w[LevelID]' value='$w[LevelID]' $ck onChange='javascript:UbahLevel(data.Level$w[LevelID])'> $w[LevelID] - $w[Nama]<br />";
  }
  return $a;
}
function TulisScriptUbahLevel() {
  echo <<<END
  <SCRIPT LANGUAGE="JavaScript1.2">
  function UbahLevel(nm){
    ck = "";
    if (nm.checked == true) {
      var nilai = data.LevelID.value;
      if (nilai.match(nm.value+".") != nm.value+".") data.LevelID.value += nm.value + ".";
    }
    else {
      var nilai = data.LevelID.value;
      data.LevelID.value = nilai.replace(nm.value+".", "");
    }
  }
  //-->
  </script>
END;
}
function DftrGrp() {
  TampilkanMenuModul();
  $s = "select mg.*
    from mdlgrp mg
    order by mg.Urutan";
  $r = _query($s);
  echo "<p><table class=box cellspacing=1 cellpadding=4 align=center>
  <tr><th class=ttl>#</th>
  <th class=ttl>ID</th>
  <th class=ttl>Group</th>
  <th class=ttl>Nama</th>
  <th class=ttl>NA</th></tr>";
  while ($w = _fetch_array($r)) {
    $c = ($w['NA'] == 'Y')? 'class=nac' : 'class=ul';
    echo "<tr><td class=inp1>$w[Urutan]</td>
    <td $c><a href='?mnux=".__path_mnux__."&token=GrpEdt&md=0&grid=$w[MdlGrpID]'><img src='img/edit.png' border=0>
    $w[MdlGrpID]</a></td>
    <td $c>$w[Nama]</td>
    <td $c align=center><img src='img/book$w[NA].gif'></td>
    </tr>";
  }
  echo "</table></p>";
}
function GrpEdt() {
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $w = GetFields('mdlgrp', 'MdlGrpID', $_REQUEST['grid'], '*');
    $_grid = "<input type=hidden name='MdlGrpID' value='$w[MdlGrpID]'><b>$w[MdlGrpID]</b>";
    $jdl = "Edit Group";
  }
  else {
    $w = array();
    $w['MdlGrpID'] = '';
    $w['Nama'] = '';
    $w['Urutan'] = 0;
    $w['NA'] = 'N';
    $_grid = "<input type=text name='MdlGrpID' size=10 maxlength=10>";
    $jdl = "Tambah Group";
  }
  $_NA = ($w['NA'] == 'Y')? 'checked' : '';
  echo "<p><table class=box cellspacing=1 cellpadding=4>
  <form action='?' method=POST>
  <input type=hidden name='mnux' value='".__path_mnux__."'>
  <input type=hidden name='md' value='$md'>
  <input type=hidden name='token' value='GrpSav'>
  <input type=hidden name='BypassMenu' value='1' />
  
  <tr><th class=ttl colspan=2>$jdl</th></tr>
  <tr><td class=inp1>Group ID</td><td class=ul>$_grid</td></tr>
  <tr><td class=inp1>Nama Group</td><td class=ul><input type=text name='Nama' value='$w[Nama]' size=20 maxlength=50></td></tr>
  <tr><td class=inp1>Urutan</td><td class=ul><input type=text name='Urutan' value='$w[Urutan]' size=5 maxlength=5></td></tr>
  <tr><td class=inp1>Tidak Aktif?</td><td class=ul><input type=checkbox name='NA' value='Y' $_NA></td></tr>
  <tr><td colspan=2><input type=submit name='Simpan' value='Simpan'>
  <input type=reset name='Reset' value='Reset'>
  <input type=button name='Batal' value='Batal' onClick=\"location='?mnux=".__path_mnux__."&token=DftrGrp'\"></td></tr>
  </form></table></p>";
}


// *** Parameters ***
$mdlgrp = GetSetVar('mdlgrp');
//$token = (empty($_REQUEST['token']))? 'DftrPngmmn' : $_REQUEST['token'];
$token = (empty($_REQUEST['token']))? 'DftrPngmmn' : $_REQUEST['token'];


// *** Main ***
TampilkanJudul("Pengumuman");
$token();
?>
