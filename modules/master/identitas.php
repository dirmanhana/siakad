<?php
// Author: Emanuel Setio Dewo, setio_dewo@sisfokampus.net
// 2005-12-26

// *** Functions ***
function DftrIdentitas() {
  $s = "select * from identitas order by Kode";
  $r = _query($s);
  $n = 0;
  echo "<p><table class=box cellspacing=1 cellpadding=4>
    <tr><td colspan=4><a href='?mnux=identitas&gos=IDEdt&md=1'>Tambah Identitas</a></td></tr>
    <tr><th class=ttl>#</th>
    <th class=ttl>Kode</th>
    <th class=ttl>Nama</th>
    <th class=ttl>NA</th>
    </tr>";
  while ($w = _fetch_array($r)) {
    $n++;
    $c = ($w['NA'] == 'Y')? 'class=nac' : 'class=ul';
    echo "<tr><td $c>$n</td>
      <td $c><a href='?mnux=identitas&md=0&kod=$w[Kode]&gos=IDEdt'><img src='img/edit.png' border=0>
      $w[Kode]</a></td>
      <td $c>$w[Nama]</td>
      <td $c align=center><img src='img/book$w[NA].gif'></td>
      </tr>";
  }
  echo "</table></p>";
}
function CariPTDiktiScript() {
  echo <<<EOF
  <SCRIPT LANGUAGE="JavaScript1.2">
  <!--
  function caript(frm){
    lnk = "cetak/cariptdikti.php?PerguruanTinggiID="+frm.KodeHukum.value+"&Cari="+frm.Nama.value;
    win2 = window.open(lnk, "", "width=600, height=600, scrollbars, status");
    win2.creator = self;
  }
  -->
  </script>
EOF;
}
function IDEdt() {
  CariPTDiktiScript();
  $md = $_REQUEST['md'] +0;
  if ($md == 0) {
    $w = GetFields('identitas', 'Kode', $_REQUEST['kod'], '*');
    $jdl = "Edit Identitas";
    $strkod = "<input type=text name='Kode' size=15 maxlength=10 value='$w[Kode]' readonly=true>";
  }
  else {
    $w = array();
    $w['Kode'] = '';
    $w['KodeHukum'] = '';
    $w['Nama'] = '';
    $w['TglMulai'] = date('Y-m-d');
    $w['Alamat1'] = '';
    $w['Alamat2'] = '';
    $w['Kota'] = '';
    $w['KodePos'] = '';
    $w['Telepon'] = '';
    $w['Fax'] = '';
    $w['Email'] = '';
    $w['Website'] = '';
    $w['NoAkta'] = '';
    $w['TglAkta'] = date('Y-m-d');
    $w['NoSah'] = '';
    $w['TglSah'] = date('Y-m-d');
    $w['Logo'] = '';
    $w['NA'] = 'N';
    $jdl = "Tambah Identitas";
    $strkod = "<input type=text name='Kode' size=15 maxlength=10>";
  }
  $na = ($w['NA'] == 'Y')? 'checked' : '';
  $_TglMulai = GetDateOption($w['TglMulai'], 'TglMulai');
  $_TglAkta = GetDateOption($w['TglAkta'], 'TglAkta');
  $_TglSah = GetDateOption($w['TglSah'], 'TglSah');
  $snm = session_name(); $sid = session_id();
  $c1 = 'class=inp1'; $c2 = 'class=ul';
  // tampilan formulir
  echo "
  <form action='?' method=POST name=data>
  <input type=hidden name='mnux' value='identitas'>
  <input type=hidden name='md' value='$md'>
  <input type=hidden name='gos' value='IDSav'>
  
  <fieldset style='width:60%'>
    <legend>$jdl</legend>
      <ol>
	<li>
	  <label for=Kode>Kode Institusi:</label>
	  $strkod
	</li>
	<li>
	  <label for=KodeHukum>Kode Dikti:</label>
	  <input type=text name='KodeHukum' value='$w[KodeHukum]' size=15 maxlength=10> <a href='javascript:caript(data)'>Cari</a>
	</li>
	<li>
	  <label for=Nama>Nama Institusi:</label>
	  <input type=text name='Nama' value='$w[Nama]' size=40 maxlength=100>
	</li>
	<li>
	  <label for=Ijazah>Format Ijazah:</label>
	  <input type=text name='FormatIjazah' value='$w[FormatIjazah]' size=15>
	</li>
	<li>
	  <label for=TglMulai>Tanggal Mulai:</label>
	  $_TglMulai
	</li>
	<li>
	  <label for=Alamat>Alamat:</label>
	  <input type=text name='Alamat1' value='$w[Alamat1]' size=40 maxlength=100>
	</li>
	<li>
	  <label for=Alamat>Alamat 2:</label>
	  <input type=text name='Alamat2' value='$w[Alamat2]' size=40 maxlength=100>
	</li>
	<li>
	  <label for=Kota>Kota:</label>
	  <input type=text name='Kota' value='$w[Kota]' size=40 maxlength=50>
	</li>
	<li>
	  <label for=KodePos>Kode Pos:</label>
	  <input type=text name='KodePos' value='$w[KodePos]' size=40 maxlength=50>
	</li>
	<li>
	  <label for=Telepon>Telepon:</label>
	  <input type=text name='Telepon' value='$w[Telepon]' size=40 maxlength=50>
	</li>
	<li>
	  <label for=Fax>Fax:</label>
	  <input type=text name='Fax' value='$w[Fax]' size=40 maxlength=40>
	</li>
	<li>
	  <label for=Email>Email:</label>
	  <input type=text name='Email' value='$w[Email]' size=40 maxlength=40>
	</li>
	<li>
	  <label for=Website>Website:</label>
	  <input type=text name='Website' value='$w[Website]' size=40 maxlength=40>
	</li>
	<li>
	  <label for=NoAkta>No. Akta:</label>
	  <input type=text name='NoAkta' value='$w[NoAkta]' size=40 maxlength=40>
	</li>
	<li>
	  <label for=TanggalAkta>Tanggal Akta:</label>
	 $_TglAkta
	</li>
	<li>
	  <label for=NoSah>No. Pengesahan:</label>
	  <input type=text name='NoSah' value='$w[NoSah]' size=40 maxlength=50>
	</li>
	<li>
	  <label for=TanggalSah>Tanggal Pengesahan:</label>
	  $_TglSah
	</li>
	<li>
	  <label for=NA>NA (tidak aktif)?:</label>
	  <input type=checkbox value='Y' $na>
	</li>
	<li>
	  <input type=submit name='Simpan' value='Simpan'>
	  <input type=reset name='Reset' value='Reset'>
	  <input type=button name='Batal' value='Batal' onClick=\"location='?mnux=identitas&snm=$sid'\">
	</li>
      </ol>
  </fieldset>
  </form>";
}
function IDSav() {
  $md = $_REQUEST['md'] +0;
  $Kode = $_REQUEST['Kode'];
  $KodeHukum = $_REQUEST['KodeHukum'];
  $Nama = sqling($_REQUEST['Nama']);
  $TglMulai = $_REQUEST['TglMulai_y'].'-'.$_REQUEST['TglMulai_m'].'-'.$_REQUEST['TglMulai_d'];
  $Alamat1 = sqling($_REQUEST['Alamat1']);
  $Alamat2 = sqling($_REQUEST['Alamat2']);
  $Kota = sqling($_REQUEST['Kota']);
  $KodePos = $_REQUEST['KodePos'];
  $Telepon = $_REQUEST['Telepon'];
  $Fax = $_REQUEST['Fax'];
  $Email = $_REQUEST['Email'];
  $Website = $_REQUEST['Website'];
  $NoAkta = $_REQUEST['NoAkta'];
  $TglAkta = "$_REQUEST[TglAkta_y]-$_REQUEST[TglAkta_m]-$_REQUEST[TglAkta_d]";
  $NoSah = $_REQUEST['NoSah'];
  $TglSah = "$_REQUEST[TglSah_y]-$_REQUEST[TglSah_m]-$_REQUEST[TglSah_d]";
  $Logo = $_REQUEST['Logo'];
  $NA = (empty($_REQUEST['NA']))? 'N' : $_REQUEST['NA'];
  // simpan
  if ($md == 0) {
    $s = "update identitas set KodeHukum='$KodeHukum',
      Nama='$Nama', TglMulai='$TglMulai', Alamat1='$Alamat1', Alamat2='$Alamat2',
      Kota='$Kota', KodePos='$KodePos', Telepon='$Telepon', Fax='$Fax', Email='$Email', Website='$Website',
      NoAkta='$NoAkta', TglAkta='$TglAkta', NoSah='$NoSah', TglSah='$TglSah',
      Logo='$Logo', NA='$NA'
      where Kode='$Kode' ";
    $r = _query($s);
  }
  else {
    $ada = GetFields('identitas', 'Kode', $w['Kode'], '*');
    if (!empty($ada)) echo ErrorMsg('Gagal Simpan', "Data identitas tidak dapat disimpan.<br>
      Kode identitas: <b>$w[Kode]</b> telah dipakai oleh <b>$ada[Nama]</b>.<br>
      Gunakan kode lain.");
    else {
      $s = "insert into identitas (Kode, KodeHukum, Nama, TglMulai,
        Alamat1, Alamat2, Kota, KodePos, Telepon, Fax, Email, Website,
        NoAkta, TglAkta, NoSah, TglSah, Logo, NA)
        values ('$Kode', '$KodeHukum', '$Nama', '$TglMulai',
        '$Alamat1', '$Alamat2', '$Kota', '$KodePos', '$Telepon', '$Fax', '$Email', '$Website',
        '$NoAkta', '$TglAkta', '$NoSah', '$TglSah', '$Logo', '$NA')";
      $r = _query($s);
    }
  }
  DftrIdentitas();
}

// *** Parameters ***
$gos = (empty($_REQUEST['gos']))? 'DftrIdentitas' : $_REQUEST['gos'];

// *** Main ***
TampilkanJudul("Identitas Perguruan Tinggi");
$gos();
?>
