//-- Código para las pestañas de tabs
(function ($) {
   $(document).ready(function(){
      //== Conjunto de funciones necesarios para caragar contenido de la pagina mediante AJAX
      UpdateDatasDB();
      showSepYes();
      showSepNot();
      exStudents();
      studentsStandBy();
      viewTask();
      viewSchedule();
      showSepTeacher();
      showEvalSt();
      showEvalStTeacher();
      showScholars();

      $('button#hoyday').click();

      //== Funcion que permite la generaacion de PDF de partes de una pagina, las que se indique
      $("#printer").click(function(){
         console.log('Click en la impresora');
         $("#paperPrint").printMe({
           "path" : "css/bootstrap.min.css"
         });
      });

      $(function(){
         $(document).on('click','#impresora', function() {
           console.log('Click en la Impresora');
           $("#hoja").printMe({
           "path" : "css/bootstrap.min.css"
         });
         });
      });
      $(function(){
         $(document).on('click','#imp', function() {
           $("#hojasep").printMe({
           "path" : "css/bootstrap.min.css"
         });
         });
      });

      $("#print").click(function(){
         $("#paper").printMe({
           "path" : "css/bootstrap.min.css"
         });
      });

      //== Funcion que permite la visualizacion del calendario de la pestaña Principal
      var calendar = $("#calendar").calendar({
         tmpl_path: "tmpls/",
         events_source: function () { return []; }
      });

      $('table#example').DataTable(); //-- Para agregar las busquedas en tiempo real y el ordamiento
      $('table#datablog').DataTable();

      //--- Bloque para el efecto del menu estatico al hacer scroll
      var altura = $('nav').offset().top;
      $(window).scroll(function(){
         if ($(this).scrollTop() > altura) $('nav').addClass("navbar-fixed-top").fadeIn('low');
         else $('nav').removeClass("navbar-fixed-top");
      });

      //-- Declaracion de algunas variables para ciertas funciones de ocultar y mostrar elementos.
      $("#describa").hide();
      $("#cual").hide();
      $("#tratamiento").hide();
      $("#tutordata").show();
      $("#a").hide();$("#b").hide();$("#c").hide();$("#d").hide();
      $("#e").hide();$("#f").hide();$("#g").hide();
});
}(jQuery));


//-- Funciones que ocultan o muestran el formulario para los datos del tutor en "Nuevo Alumno"
function showTutor(){
   $("div#tutordata").fadeIn();
}
function hideTutor(){
   $("div#tutordata").fadeOut();
}

//-- Inicializador de la funcion de los tooltips.   
$(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $('.bs-component [data-toggle="popover"]').popover();
}(jQuery));

//-- Mostrar u ocultar info sobre antecedentes del alumno "Nuevo Alumno->infoAcademic"
function ver () {
    $("#describa").show();
}
function ocultar () {
    $('#describa').hide();
}

//-- Mostrar u ocultar info sobre padecimientos del alumno "Nuevo Alumno->infoGeneral"
function mostrar () {
    $("#cual").show();
    $("#tratamiento").show();
}
function guardar () {
    var x;
    $("#cual").hide();
    $("#tratamiento").hide();
}

//Mostrar los grados escolares segun elnivel de estudios.
function showGrade(str) {
    if (str == 'Preescolar' || str == 'Secundaria' || str == 'Bachillerato'){
    $("#a").show();
    $("#b").show();
    $("#c").show();
    $("#d").hide();
    $("#e").hide();
    $("#f").hide();
    $("#g").show();
    } else if (str == 'Primaria' || str == 'Licenciatura') {
        $("#a").show();
        $("#b").show();
        $("#c").show();
        $("#d").show();
        $("#e").show();
        $("#f").show();
        $("#g").show();
    }
}

//=======================================================================

$(function(){
    $(document).on('click','.mdi-action-grade.eval', function() {
        $('.mdi-action-grade.eval').css('color', '#e0e0e0');
        $(this).css('color', '#ffea00');
    });
});
$(function(){
    $(document).on('click','.mdi-action-grade.evalA', function() {
        $('.mdi-action-grade.evalA').css('color', '#e0e0e0');
        $(this).css('color', '#ffea00');
    });
});
$(function(){
    $(document).on('click','.mdi-action-grade.evalB', function() {
        $('.mdi-action-grade.evalB').css('color', '#e0e0e0');
        $(this).css('color', '#ffea00');
    });
});
$(function(){
    $(document).on('click','.mdi-action-grade.evalC', function() {
        $('.mdi-action-grade.evalC').css('color', '#e0e0e0');
        $(this).css('color', '#ffea00');
    });
});
$(function(){
    $(document).on('click','.mdi-action-grade.evalD', function() {
        $('.mdi-action-grade.evalD').css('color', '#e0e0e0');
        $(this).css('color', '#ffea00');
    });
});
$(function(){
    $(document).on('click','.mdi-action-grade.evalone', function() {
        $('.mdi-action-grade.evalone').css('color', '#e0e0e0');
        $(this).css('color', '#ffea00');
    });
});
$(function(){
    $(document).on('click','.mdi-action-grade.evaltwo', function() {
        $('.mdi-action-grade.evaltwo').css('color', '#e0e0e0');
        $(this).css('color', '#ffea00');
    });
});
$(function(){
    $(document).on('click','.mdi-action-grade.evaltre', function() {
        $('.mdi-action-grade.evaltre').css('color', '#e0e0e0');
        $(this).css('color', '#ffea00');
    });
});
$(function(){
    $(document).on('click','.mdi-action-grade.evalfour', function() {
        $('.mdi-action-grade.evalfour').css('color', '#e0e0e0');
        $(this).css('color', '#ffea00');
    });
});
$(function(){
    $(document).on('click','.mdi-action-grade.evalfive', function() {
        $('.mdi-action-grade.evalfive').css('color', '#e0e0e0');
        $(this).css('color', '#ffea00');
    });
});
$(function(){
    $(document).on('click','.mdi-action-grade.evalsix', function() {
        $('.mdi-action-grade.evalsix').css('color', '#e0e0e0');
        $(this).css('color', '#ffea00');
    });
});

$(function(){
    $('ul.nav-tabs li:first').addClass('state-on');
    $(document).on('click','ul.nav-tabs li', function() {
        $('ul.nav-tabs li').removeClass('state-on');
        $(this).addClass('state-on');
    });
});

$(function(){
    $(document).on('click','div.collapse ul.nav-main li', function() {
        $('div.collapse ul.nav-main li:first').removeClass('activado');
        $(this).addClass('activado');
    });
});


//============================================================================
//== ESTE BLOQUE CORRESPONDE A TODA LA FUNCION DE LOS CHECKBOX PARA SELECCION 
//== MULTIPLE DE ALUMNOS.
//===========================================================================

//== Marca todos los alumnos que se encuentran en la tabla mostrada
function checkAll() {
  if(document.querySelector('#changeAll').checked==true) {
    $('input[type=checkbox]').each(function() {
        this.checked = true;
    });
  } else {
    $('input[type=checkbox]').each(function() {
        this.checked = false;
    });
  }
}
//== Desmarca todos los check seleccionados
function uncheckAll() {
   $('input[type=checkbox]').each(function() {
      this.checked = false;
   });
}

//== Activa los checkbox de la tabla de alumnos utilizando los botones de paginacion
$(function(){
   $(document).on('click','#paginador', function() {
      $('.checkingSt').removeClass('hidden');
      $('.paginate_button').attr('id', 'paginador');
      $('input[type=search]').attr('id', 'filtrador');
      checkAll();
   });
});
//== Activa los checkbox de la tabla de alumnos utilizando el buscador de registros
$(function(){
   $(document).on('keypress','input[type=search]#filtrador', function() {
      $('.checkingSt').removeClass('hidden');
      $('.paginate_button').attr('id', 'paginador');
      checkAll();
   });
});
$(function(){
   $(document).on('click','#btnCancel', function() {
      $('#msgAlert').html('');
   });
});
$(function(){
   $(document).on('keypress','input[type=search]#buscador', function() {
      $('input[type=checkbox]').addClass('hidden');
   });
});
//== Activa los checkbox de la tabla de alumnos al seleccionar la cantidad de registros a mostrar
$(function(){
   $(document).on('change','.grupos', function() {
      $('.checkingSt').removeClass('hidden');
      $('.paginate_button.current').attr('id', 'paginador');
      checkAll();
   });
});
//== Activa todos los elementos para realizar la seleccion multiple
$(function(){
   $(document).on('click','#showChecks', function() {
      $('#markerSt').removeClass('hidden');
      $('.checkingSt').removeClass('hidden');
      $('.changeopttwo').removeClass('hidden');
      $('#cancelchange').removeClass('hidden');
      $('#markAll').removeClass('hidden');
      $('.paginate_button').attr('id', 'paginador');
      $('input[type=search]').attr('id', 'filtrador');
      $('.dataTables_length select').addClass('grupos');
      $(this).attr('id', 'changeSelect');
      $(this).attr({
         'data-toggle': 'modal',
         'data-target': '.bs-example-modal-change'
      });
   });
});
//== Desactiva todos los elementos para realizar la seleccion multiple
$(function(){
   $(document).on('click','#cancelchange', function() {
      $('input[type=checkbox]').addClass('hidden');
      $('.paginate_button').removeAttr('id', 'paginador');
      $('input[type=search]#filtrador').removeAttr('id', 'filtrador');
      $('.dataTables_length select').removeClass('grupos');
      $('#markerSt').addClass('hidden');
      $('.checkingSt').addClass('hidden');
      $('.changeopttwo').addClass('hidden');
      $('#markAll').addClass('hidden');
      $('#changeSelect').attr({
         'data-toggle': '',
         'data-target': ''
      });
      $('#changeSelect').attr('id', 'showChecks');
      uncheckAll();
      $('#cancelchange').addClass('hidden');
      $('input[type=search]').attr('id', 'buscador');
   });
});
//== Activa el modal para seleccionar el nuevo curso y grupo
function selectNewClass(){
   $('#thosestudents').attr('value', ''+marcados()+'');
   if (marcados()=='') {
      $('#btnOk').addClass('hidden');
      $('#msgAlert').html("<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Upss!! Parece que no selecciono ningún a alumno.</strong></div>");
   }
}

//== Optiene la cantidad de alumnos seleccionados
function marcados() {
   var contador = document.querySelector('#mycounter').value;
   var students =[];
   var c = 0; 
   for (var i = 1; i <= contador; i++) {
      if (document.querySelector('#changeCheck'+i) != null) {
         if (document.querySelector('#changeCheck'+i).checked == true) {
            c++;
            if (c==1) {
               students = document.querySelector('#changeCheck'+i).value;
            } else {
               students +='-'+document.querySelector('#changeCheck'+i).value;
            }
         }
      }
   };
   return students;
}
//== pasar la cantidad de alumnos y datos al formulario que procesara el cambio.
$(function(){
  $(document).on('click','#changeSelect', function() {
      $('#thosestudents').attr('value', ''+marcados()+'');
      if (marcados()=='') {
         $('#btnOk').addClass('hidden');
         $('#msgAlert').html("<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Upss!! Parece que no selecciono ningún a alumno.</strong></div>");
      } else {
         $('#btnOk').removeClass('hidden');
      }
   });
});

//=====================================================================================
//== 
//=====================================================================================

