var Inscripcion = {
    initialize: function(){
        console.log('Inscripcion Initialize');
        this.setActiveView();
        this.studentHasTutor();
        this.existTutor();
        this.existStudent();
        this.setWorkplaceLbl();
        this.getGroupsByCourse();
        this.getClassInfo();
        this.activeData();
    },

    setActiveView: function() {
        let that = this;
        let active = $('#viewActive').val();
        let actual = sessionStorage.getItem('s_activo');
            $("."+actual).removeClass('active');
 
            sessionStorage.setItem("s_activo", active);
            $("."+active).addClass('active');
    },

    studentHasTutor: function() {
        let that = this;
        $('#tutor_yes').click(function() {
            $('#info_tutor').show();
            $('#continue').text('');
        });

        $('#tutor_not').click(function() {
            $('#info_tutor').hide();
            $('#continue').text('Indique la ubicación del alumno en el mapa y luego pulse guardar para continuar con el registro del alumno.');
        });
    },

    existTutor: function(){
        let that = this;
        $('#nombre_tutor').keydown(function() {
            if ($('#nombre_tutor').val().length >= 2) {
                $.ajax({
                    data: {
                        name: $('#nombre_tutor').val(),
                        surname: $('#apellido_pat').val(),
                        lastname: $('#apellido_mat').val()
                    },
                    synch: 'true',
                    type: 'POST',
                    url: _root_ + 'alumno/existeTutor',
                    success: function(a){
                        if (a !== 'null') {
                            var res = JSON.parse(a);
                            var ask   = '¿Este es el tutor que quiere registrar? <br />';
                            var tutor = ask+res.namet+' '+res.surnamet+' '+res.lastnamet;
                            var btnOk = '<a id="btn_yes" data-tutor="'+res.id_tutor+'" class="btn btn-sm btn-info btn-raised">Si</a> ';
                            var btnNo = ' <a id="btn_not" class="btn btn-sm btn-warning btn-raised">No</a>';
                            
                            $('#exist_tutor').addClass('mini-box');
                            $('#exist_tutor').html('<p class="text-center">'+tutor+'</p>'+btnOk+btnNo);

                            that.useTutor();
                        }
                    }
                });
            } else {
                $('#exist_tutor').html('');
                $('#exist_tutor').removeClass('mini-box');
            }
        });
    },

    useTutor: function(){
        $('#btn_yes').click(function(){
            var tutor = $(this).data('tutor');
            $.ajax({
                data: {
                    tutor: tutor
                },
                synch: 'true',
                type: 'POST',
                url: _root_ + 'alumno/obtenerTutor',
                success: function(data){
                    if (data !== 'null') {
                        var response = JSON.parse(data);
                        console.log(response);
                        $('#tutor_id').val(response.id_tutor);
                        $('#nombre_tutor').val(response.namet);
                        $('#apellido_pat').val(response.surnamet);
                        $('#apellido_mat').val(response.lastnamet);
                        $("#parentesco option[value='" + response.relationship +"']").attr("selected", true);
                        $("#parent_alt option[value='"+response.relationship_alt+"']").attr("selected", true);
                        $('#ocupacion').val(response.job);
                        $('#tel_celular').val(response.cellphone);
                        $('#tel_casa').val(response.phone);
                        $('#tel_alterno').val(response.phone_alt);

                        $('#street').val(response.street);
                        $('#number').val(response.st_number);
                        $('#between').val(response.st_between);
                        $('#colony').val(response.colony);
                        $('#lat').val(response.latitud);
                        $('#lng').val(response.longitud);

                        $('#btn_not').click();
                    }
                }
            });
        });

        $('#btn_not').click(function(){
            $('#exist_tutor').hide();
            $('#exist_tutor').html('');
            $('#exist_tutor').removeClass('mini-box');
        });
    },

    existStudent: function() {
        let that = this;

        $('#name').keydown(function() {
            if ($('#name').val().length >= 2) {
                $.ajax({
                    data: {
                        name: $('#name').val(),
                        surname: $('#surname').val(),
                        lastname: $('#lastname').val()
                    },
                    synch: 'true',
                    type: 'POST',
                    url: _root_ + 'alumno/existeAlumno',
                    success: function(data){
                        if (data != 'null') {
                            var res = JSON.parse(data);
                            var head  = 'El alumno: ';
                            var foot  = ' <br /> Ya está registrado, se encuentra en '+res.grupo+'.<br /> ¿Desea continuar con el registro actual?';
                            var student = head+res.name+' '+res.surname+' '+res.lastname+foot;
                            var btnOk = '<a id="btn_continue" class="btn btn-sm btn-info btn-raised">Continuar Registro</a>';
                            var btnNo = ' <a id="btn_cancel" class="btn btn-sm btn-warning btn-raised">Cancelar Registro</a>';
                            
                            $('#exist_student').addClass('mini-box');
                            $('#exist_student').html('<p class="text-center">'+student+'</p>'+btnNo+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+btnOk);

                            that.selectAction();
                        }
                    }
                });
            } else {
                $('#exist_student').html('');
                $('#exist_student').removeClass('mini-box');
            }
        });
    },

    selectAction: function(){
        $('#btn_cancel').click(function(){
            $.ajax({
                synch: 'true',
                type: 'POST',
                url: _root_ + 'alumno/cancelarRegistro',
                success: function(data){
                    $('#name').val('');
                    $('#surname').val('');
                    $('#lastname').val('');
                    $('#street_s').val('');
                    $('#number_s').val('');
                    $('#between_s').val('');
                    $('#colony_s').val('');
                    $('#btn_continue').click();
                    $('#general_snack').attr('data-content', 'Registro cancelado correctamente!');
                    $('#general_snack').snackbar('show');
                    $('.snackbar').addClass('snackbar-green');
                    // window.location(_root_+'alumno/nuevo');
                }
            });
        });

        $('#btn_continue').click(function(){
            $('#exist_student').hide();
            $('#exist_student').html('');
            $('#exist_student').removeClass('mini-box');
        });
    },

    setWorkplaceLbl: function() {
        let that = this;
        $('#ocupation').on('change', function(){
            let ocupacion = $('#ocupation').val();

            if (ocupacion === "Estudiante") {
                $('#workplace').text('Dónde Estudia: ');
            }

            if (ocupacion === "Trabajador") {
                $('#workplace').text('Dónde Trabaja: ');
            }
        });
    },

    getGroupsByCourse: function() {
        $('#course').change(function(){
            var curso = $(this).val();
            if (curso !== '' && curso !== '0') {
                $.ajax({
                    data: {
                        curso: curso
                    },
                    synch: 'true',
                    type: 'POST',
                    url: _root_ + 'alumno/obtenerNivelesCurso',
                    success: function(data){
                        var option = '<option value="">Seleccione...</option>';
                        if (data !== 'null') {
                            var res = JSON.parse(data);
                            for (var i = 0; i < res.length; i++) {
                                option = option + '<option value="'+res[i].class_id+'">'+res[i].group_name+'</option>';
                            }
                        } else {
                            option = '<option value="">Curso sin grupos</option>';
                        }
                        $('#groupList').attr('required', true);
                        $('#groupList').attr('disabled', false);
                        $('#groupList').html(option);
                    }
                });
            }

            if (curso === '0') {
                var option = '<option value="0">En Espera</option>';
                $('#groupList').attr('required', false);
                $('#groupList').attr('disabled', true);
                $('#clase_id').val(0);
                $('#groupList').html(option);
            }
        });
    },

    //Informacion de la clase->inscribir alumno.
    getClassInfo: function() {
        $('#groupList').change(function(){
            var clase = $(this).val();
            // console.log(clase);
            if (clase !== '') {
                $.ajax({
                    data: { clase: clase },
                    synch: 'true',
                    type: 'POST',
                    url: _root_ + 'alumno/obtenerInfoClase',
                    success: function(a){
                        // console.log(a);
                        if (a !== 'null') {
                            $('#clasedata').addClass('mini-box');
                            var res = JSON.parse(a);
                            // console.log(res);
                            $('#clase_id').val(res.class_id);
                            $('#clase_name').text('Clase: '+res.course+' '+res.group_name);
                            $('#horario_c').text('Horario: '+res.hour_init+' - '+res.hour_end);
                            $('#f_inicio').text('Inicia: '+res.date_init);
                            $('#f_fin').text('Termina: '+res.date_init);

                            $('#fecha_inicio').val(res.date_init);

                            $.ajax({
                                data: { clase: res.schedul_id },
                                synch: 'true',
                                type: 'POST',
                                url: _root_ + 'alumno/obtenerDiasClase',
                                success: function(data){
                                    console.log(data);
                                    if (data !== 'null') {
                                        var r = JSON.parse(data);
                                        var day = '';
                                        for (var i = 0; i < r.length; i++) {
                                            day !== '' ? day = day+', '+ r[i].day : day = day + r[i].day;
                                        }
                                        $('#dias').text('Días: '+day);
                                    }
                                }
                            });
                        }
                    }
                });
            }
        });
    },

    activeData: function() {
        
        $('.sicknes_detail').hide();
        $('#isSick_yes').click(function() {
            $('.sicknes_detail').show();
        });

        $('#isSick_not').click(function() {
            $('.sicknes_detail').hide();
        });

        $('#describa').hide();
        $('#optionSi').click(function() {
            $('#describa').show();
        });

        $('#optionNo').click(function() {
            $('#describa').hide();
        });

        $('#fecha_inicio').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });

        $('#bornday').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });

        $('.extra').hide();
        $('#nivel').change(function(){
            var nivel = $(this).val();
            if (nivel === 'Primaria' || nivel === 'Licenciatura') {
                $('.extra').show();
            } else {
                $('.extra').hide();
            }
        });

        $("#avatar").fileinput({
            showCaption: true,
            browseClass: "btn btn-info btn-sm btn-lg",
            fileType: "image"
        });
    },
    
};

Inscripcion.initialize();
