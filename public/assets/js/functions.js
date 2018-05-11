

//-- <------------------------- ********* ------------------------->
//-- Mostrar con un modal la info de padrinos del alumno, de la vista Becados.
function moreSponsor(str) {
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
			document.getElementById("datospadrino").innerHTML = xmlhttp.responseText;
		}
	};

	xmlhttp.open("GET","app/php/sponsorsData.php?x=" + str, true);
	xmlhttp.send();
}

//-- <------------------------- ********* ------------------------->
// Funcion para visualizar los datos de los tutores.
function datosTutor(str) {
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
			document.getElementById("datostutor").innerHTML = xmlhttp.responseText;
		}
	};

	xmlhttp.open("GET","app/profiles/transactions/showTutor.php?c=" + str, true);
	xmlhttp.send();
}

//-- <------------------------- ********* ------------------------->
//-- Mostrar con un modal la info de padrinos del alumno, de la vista Becados.
function editUser(str) {
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
			document.getElementById("datosusuario").innerHTML = xmlhttp.responseText;
		}
	};

	xmlhttp.open("GET","app/profiles/direccion/viewEditUser.php?id=" + str, true);
	xmlhttp.send();
}

//-- <------------------------- ********* ------------------------->
//-- Funcion para eliminar Usuarios.
function deleteUser(str) {
	var xmlhttp;
	if (str.length === 0) {
		document.getElementById('salida').innerHTML = "";
		return;
	}
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else { 
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			document.getElementById("salida").innerHTML = xmlhttp.responseText;
		}
	};

	xmlhttp.open("GET","app/profiles/direccion/deleteUser.php?id=" + str, true);
	xmlhttp.send();
}

//-- <------------------------- ********* ------------------------->
// Funcion para visualizar datos de un alumno en especifico.
function datosStudent(idSt,idC) {
	var xmlhttp;
	if (idSt.length === 0 && idC === 0) {
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
			document.getElementById("dataStudent").innerHTML = xmlhttp.responseText;
		}
	};

	xmlhttp.open("GET","app/profiles/transactions/studentData.php?s=" + idSt + "&c=" + idC, true);
	xmlhttp.send();
}

//-- <------------------------- ********* ------------------------->
// Funcion para visualizar los datos de los padrinos de la vista Padrinos.
function datosPadrino(str) {
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
			document.getElementById("datospadrino").innerHTML = xmlhttp.responseText;
		}
	};

	xmlhttp.open("GET","app/views/viewEditSponsor.php?s=" + str, true);
	xmlhttp.send();
}


//-- <------------------------- ********* ------------------------->
// Funcion para visualizar los datos del Tutor, en la vista Alumnos.
function teachers (str) {
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
			document.getElementById("datosteach").innerHTML = xmlhttp.responseText;
		}
	};

	xmlhttp.open("GET","app/php/teachers.php?it=" + str, true);
	xmlhttp.send();
}

//-- <------------------------- ********* ------------------------->
//Función para la seleccion de Grupos de cursos Naatik de la Vista "Alumno nuevo-infoAcademica".
function grup(cadena) {
   var xmlhttp;
	
	if (cadena.length === 0) {
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
			document.getElementById("thisDataGroup").innerHTML = xmlhttp.responseText;
		} 
	};

	xmlhttp.open("GET","app/php/selectionGroup.php?n="+cadena, true);
	xmlhttp.send();
}

//Función para la seleccion de Grupos de cursos Naatik.
function nextGroup(cadena) {
   var xmlhttp;
	if (cadena.length === 0) {
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
			document.getElementById("dataGroup").innerHTML = xmlhttp.responseText;
		} 
	};

	xmlhttp.open("GET","app/php/selectionGroup.php?n="+cadena, true);
	xmlhttp.send();
}

//Función para la seleccion de Grupos de cursos Naatik.
function allGroup(cadena) {
   var xmlhttp;
	if (cadena.length === 0) {
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
			document.getElementById("dGroup").innerHTML = xmlhttp.responseText;
		} 
	};

	xmlhttp.open("GET","app/php/selectionGroup.php?n="+cadena, true);
	xmlhttp.send();
}

//-- <------------------------- ********* ------------------------->
//Función para la seleccion de Grupos de cursos Naatik de la vista "lista de alumnos".
function course(cadena) {
   var xmlhttp;
	
	if (cadena.length === 0) {
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
			document.getElementById("showCourse").innerHTML = xmlhttp.responseText;
		} 
	};

	xmlhttp.open("GET","app/php/selectionCourse.php?n="+cadena, true);
	xmlhttp.send();
}

//-- <------------------------- ********* ------------------------->
//Función para mostrar los Grupos de cursos Naatik en la vista "Alumnos".
function groupss(cadena) {
   var xmlhttp;
	
	if (cadena.length === 0) {
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
			document.getElementById("info").innerHTML = xmlhttp.responseText;
		} 
	};

	xmlhttp.open("GET","app/php/muestraGrupo.php?g="+cadena, true);
	xmlhttp.send();
}

//-- <------------------------- ********* ------------------------->
//Mostrar datos del curso seleccionado, en "NUevo Alumno --> Datos academicos".
function datosCurso(str) {
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
			document.getElementById("datosCurso").innerHTML = xmlhttp.responseText;
		} 
	};

	xmlhttp.open("GET","app/php/showCourseData.php?x="+str, true);
	xmlhttp.send();
}

//-- <------------------------- ********* ------------------------->
//Mostrar datos del alumno becado para cambiar, en "Alumnos becados --> becados".
function changeScholar(str) {
   var xmlhttp;
	
	if (str.length === 0) {
		document.getElementById('newScholar').innerHTML = "";
		return;
	}
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else { 
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			document.getElementById("newscholar").innerHTML = xmlhttp.responseText;
		} 
	};

	xmlhttp.open("GET","app/profiles/transactions/showScholarData.php?x="+str, true);
	xmlhttp.send();
}
