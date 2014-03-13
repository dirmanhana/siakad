<?php

session_start();
// *** Parameters ***
$TahunID = GetSetVar('TahunID');
$ProdiID = GetSetVar('ProdiID');

// *** Main ***
TampilkanJudul("Proses NIM Sementara");
$gos = (empty($_REQUEST['gos']))? 'TampilkanPRC' : $_REQUEST['gos'];
$gos();

// *** Functions ***
function TampilkanPRC() {
  $optprodi = GetProdiUser($_SESSION['_Login'], $_SESSION['ProdiID']);
  $prosesbutton = (!empty($_SESSION['_Login']) and !empty($_SESSION['ProdiID']))? "<input type=button name='Proses' value='Proses Urut NIM' onClick=\"ProsesNIM()\" />" : "";
  CheckFormScript('TahunID,ProdiID');
  ProsesScript();
  echo "<p>
  <table class=box cellspacing=1 align=center>
  <form action='?mnux=$_SESSION[mnux]&gos=' method=POST onSubmit='return CheckForm(this)'>
  <tr><td class=wrn width=2 rowspan=3></td>
      <td class=inp>Tahun Akd:</td>
      <td class=ul><input type=text name='TahunID' value='$_SESSION[TahunID]' size=5 maxlength=5 /></td>
      </tr>
  <tr>
      <td class=inp>Program Studi:</td>
      <td class=ul><select name='ProdiID'>$optprodi</select></td>
      </tr>
  <tr><td class=ul colspan=2 align=center>
	  <input type=submit name='Proses' value='Set Parameter'>$prosesbutton	
      </td></tr>
  </form>
  </table>
  </p>";
}
function ProsesScript() {
  echo <<<SCR
  <script>
    // Buka window proses
	function ProsesNIM()
	{
		lnk = "$_SESSION[mnux].prc.php?TahunID=$_SESSION[TahunID]&ProdiID=$_SESSION[ProdiID]";
		win2 = window.open(lnk, "", "width=500, height=400, scrollbars, status");
		if (win2.opener == null) childWindow.opener = self;
	}
  </script>
SCR;
}
?>
