// Author : Emanuel Setio Dewo
// Agustus 2008

var xmlHttp

function _ProsesPMB() { 
  xmlHttp = GetXmlHttpObject()
  if (xmlHttp == null) {
    alert ("Browser does not support HTTP Request")
    return
  }
  var url = "keu/biayacama.proses.php";
  url = url + "?sid=" + Math.random();
  xmlHttp.onreadystatechange = stateChanged;
  xmlHttp.open("GET",url,true);
  xmlHttp.send(null);
}

function stateChanged() 
{ 
  if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") { 
    document.getElementById("ProsesBiayaPMB").innerHTML=xmlHttp.responseText 
  } 
}

function GetXmlHttpObject() {
  var xmlHttp=null;
  try {
    // Firefox, Opera 8.0+, Safari
    xmlHttp=new XMLHttpRequest();
  }
  catch (e) {
    //Internet Explorer
    try {
      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch (e) {
      xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
  return xmlHttp;
}
