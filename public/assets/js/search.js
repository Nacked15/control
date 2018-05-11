function searching(str) {
	var xmlhttp;
	if (str.length === 0) {
		document.getElementById('txtHint').innerHTML = "";
		return;
	}
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else { 
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			document.getElementById("resultadoSearch").innerHTML = xmlhttp.responseText;
		}
	};

	xmlhttp.open("GET","app/profiles/transactions/search.php?c=" + str, true);
	xmlhttp.send();
}

