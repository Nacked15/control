var Alumnos = {
    initialize: function(){
        console.log('Alumnos Initialize');
        this.getStudents();
        this.defaultGetStudents();
        this.activeData();
        this.checkIfExistTutor();
        this.getLevels();
        this.getClassInfo();
        this.getGroupsByCourse();
    },

    defaultGetStudents: function(){
        let that = this;
        var view = sessionStorage.getItem('st_alive');
        $('#second_head').hide();
        if (view === '5') {
            that.displayAllStudents(view);
        } else {
           that.displayStudents(view); 
        }
        
    },

    getStudents: function(){
        let that = this;
        $('.menu_student_list li').on('click', function(){ 
            var activo = $(this).data('group');
            if (activo != 5) {
                that.displayStudents(activo);
            } else {
                that.displayAllStudents(activo);
            }
            
        }); 
    },

    displayStudents:function(activo){
        let that = this;
        $.ajax({
            data: { curso :  activo },
            synch: 'true',
            type: 'POST',
            url: _root_ + 'alumno/obtenerAlumnos',
            success: function(data){
                $('#second_head').hide();
                $('#head_menu').show();
                switch(parseInt(activo)) {
                    case 1: $('#club').html(data);
                        break;
                    case 2: $('#primary').html(data); 
                        break;
                    case 3: $('#adolescent').html(data); 
                        break;
                    case 4: $('#adult').html(data); 
                        break;
                }
                that.addStudentInGroup();
                that.setStudentID();
                that.tables(activo);
                that.getStudentProfile();
            }
        });
    },

    displayAllStudents: function(activo){
        let that = this;
        $.ajax({
            synch: 'true',
            type: 'POST',
            url: _root_ + 'alumno/obtenerAlumnosTodos',
            success: function(data){
                $('#second_head').hide();
                $('#head_menu').show();
                $('#all_students').html(data);

                that.addStudentInGroup(); 
                that.setStudentID();
                that.tables(activo);
                that.getStudentProfile();
            }
        });
    },

    getStudentProfile: function() {
        let that = this;
        $('.profile').on('click', function(){
            var curso = $(this).data('curso');
            $.ajax({
                data: {
                    student: $(this).data('student'),
                    tutor:   $(this).data('tutor'),
                    clase:   $(this).data('clase')
                },
                synch: 'true',
                type: 'POST',
                url: _root_ + 'alumno/obtenerPerfilAlumno',
                success: function(data){
                    $('#head_menu').hide();
                    $('#second_head').show();
                    switch(parseInt(curso)) {
                        case 1: $('#club').html(data);
                            break;
                        case 2: $('#primary').html(data);
                            break;
                        case 3: $('#adolescent').html(data);
                            break;
                        case 4: $('#adult').html(data);
                            break;
                        case 5: $('#all_students').html(data);
                            break;
                    }

                    $('#return_list').click(function(){
                        if (parseInt(curso) !== 5) {
                            that.displayStudents(curso);
                        } else {
                            that.displayAllStudents(curso);
                        }
                        
                    });
                }
            });
        });
    },

    checkIfExistTutor: function(){
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
                            var tutor = ask+res.namet+' '+res.surname1+' '+res.surname2;
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
        });

        $('#btn_not').click(function(){
            $('#exist_tutor').hide();
            $('#exist_tutor').html('');
            $('#exist_tutor').removeClass('mini-box');
        });
    },

    getLevels: function() {
        $('#course').change(function(){
            var curso = $(this).val();
            if (curso !== '') {
                $.ajax({
                    data: {
                        curso: curso
                    },
                    synch: 'true',
                    type: 'POST',
                    url: _root_ + 'alumno/obtenerNivelesCurso',
                    success: function(a){
                        var option = '<option value="">Seleccione...</option>';
                        if (a !== 'null') {
                            var res = JSON.parse(a);
                            for (var i = 0; i < res.length; i++) {
                                option = option + '<option value="'+res[i].id+'">'+res[i].level+'</option>';
                            }
                        } else {
                            option = '<option value="">Curso sin grupos</option>';
                        }
                        
                        $('#levelList').html(option);
                    }
                });
            }
        });
    },

    getClassInfo: function() {
        $('#levelList').change(function(){
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
                            $('#clase_id').val(res.id);
                            $('#clase_name').text('Clase: '+res.name+' '+res.level);
                            $('#horario_c').text('Horario: '+res.hour_init+' - '+res.hour_end);
                            $('#f_inicio').text('Inicia: '+res.date_init);
                            $('#f_fin').text('Termina: '+res.date_init);

                            $('#fecha_inicio').val(res.date_init);

                            $.ajax({
                                data: { clase: res.horario },
                                synch: 'true',
                                type: 'POST',
                                url: _root_ + 'alumno/obtenerDiasClase',
                                success: function(data){
                                    // console.log(data);
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

    getGroupsByCourse: function(){
        let that = this;
        $('#course').on('change', function(){
            if ($(this).val() !== '') {
                $.ajax({
                    data: { curso: $(this).val() },
                    synch: 'true',
                    type: 'POST',
                    url: _root_ + 'alumno/obtenerNivelesCurso',
                    success: function(data){
                        var option = '<option value="">Seleccione...</option>';
                        if (data !== 'null') {
                            var res = JSON.parse(data);
                            for (var i = 0; i < res.length; i++) {
                                option = option + '<option value="'+res[i].id+'">'+res[i].level+'</option>';
                            }
                        } else {
                            option = '<option value="">Curso sin grupos</option>';
                        }
                        
                        $('#groups').html(option);
                    }
                });
            }
        });
    },

    setStudentID: function(){
        let that = this;
        $('.adding_group').on('click', function(){
            var student = $(this).data('student');
            $('#alumno_id').val(student);
        });
    },

    addStudentInGroup: function() {
        let that = this;
        $('#add_in_group').on('click', function(){
            var alumno = $('#alumno_id').val(),
                curso  = $('#course').val(),
                clase  = $('#groups').val();
                // console.log(alumno, clase);
            $.ajax({
                data: { alumno: alumno, clase: clase },
                synch: 'true',
                type: 'POST',
                url: _root_ + 'alumno/agregarAlumnoGrupo',
                success: function(data){
                    if (data !== '0') {
                        $('#add_to_group').modal('hide');
                        $('#feed_msg').addClass('alert-success');
                        $('#message').text('Información actualizada correctamente.');
                        $('#feed_msg').show();
                        that.displayStudents(curso);
                    } else {
                        $('#add_to_group').modal('hide');
                        
                        $('#feed_msg').addClass('alert-danger');
                        $('#message').text('No se pudo completar el proceso, intente de nuevo.');
                        $('#feed_msg').show();
                    }

                    var view = sessionStorage.getItem('st_alive');
                    if (view === '5') {
                        that.displayAllStudents(view);
                    } else {
                       that.displayStudents(view); 
                    }
                }
            });
        });
    },

    activeData: function() {

        $('#tutor_yes').click(function() {
            $('#info_tutor').show();
            $('#continue').text('');
        });

        $('#tutor_not').click(function() {
            $('#info_tutor').hide();
            $('#continue').text('Continúe con los datos del alumno.');
        });
        
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

    tables: function(group) {
        $('#tbl_students_'+group).DataTable();
        $('#tbl_primary').DataTable();
        $('#tbl_adols').DataTable();
        $('#tbl_adults').DataTable();
    },
    
};

Alumnos.initialize();
