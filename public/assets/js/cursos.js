var Cursos = {

	initialize: function(){
		console.log('Cursos Initialize');
		this.tables();
        this.getClasses();
        this.getCourses();
        this.getGroups();
        this.getFrmNewClass();
		this.selectAttr();
		this.setAttr();
	},

	tables: function() {
		$('#tbl_cursos').DataTable();
		$('#tbl_niveles').DataTable();
	},

    getClasses: function () {
        let that = this;
        $.ajax({
            synch: 'true',
            type: 'POST',
            url: _root_ + 'curso/obtenerClases',
            success: function(data){
                $('#lista_clases').html(data);
                $('#example').DataTable();
                $('#addClase').show();
                that.deleteClase();
                that.getFrmEditClass();
            }
        });
    },

    getCourses: function () {
        let that = this;
        $.ajax({
            synch: 'true',
            type: 'POST',
            url: _root_ + 'curso/obtenerCursos',
            success: function(data){
                $('#cursos_list').html(data);
                that.tables();
                // that.deleteClase();
                // that.getFrmEditClass();
            }
        });
    },

    getGroups: function () {
        let that = this;
        $.ajax({
            synch: 'true',
            type: 'POST',
            url: _root_ + 'curso/obtenerGrupos',
            success: function(data){
                $('#grupos_list').html(data);
                that.tables();
                // that.deleteClase();
                // that.getFrmEditClass();
            }
        });
    },

    getFrmNewClass: function() {
        let that = this;
        $('#addClase').on('click', function(){
            $.ajax({
                synch: 'true',
                type: 'POST',
                url: _root_ + 'curso/formNewClase',
                success: function(data){
                    $('#lista_clases').html(data);
                    $('#dias').select2();
                    $('#addClase').hide();
                    that.setAttr();

                    $('.cancel_new').on('click', function(){
                        that.getClasses();
                    });
                }
            });
        });
    },

    getFrmEditClass: function() {
        let that = this;
        $('.updateClase').on('click', function(){
            $.ajax({
                data: { clase: $(this).attr('id'),
                        horario: $(this).data('horario') },
                synch: 'true',
                type: 'POST',
                url: _root_ + 'curso/formEditarClase',
                success: function(data){
                    $('#lista_clases').html(data);
                    $('#addClase').hide();
                    $('#days').select2();
                    that.setAttr();

                    $('#cancel_edit').on('click', function(){
                        that.getClasses();
                    });
                }
            });
        });
    },

    deleteClase: function() {
        $('.removeClase').on('click', function(){
            var clase_id = $(this).attr('id'),
                clase_name = $(this).data('name');
                $('#clase_name').text(clase_name);
                $('#clase_id').val(clase_id);
        });
    },

	selectAttr: function() {
        $('#example_length').css('width', '280');
    },

    setAttr: function() {
        let that = this;
    	$('#date_init').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });

        $('#date_end').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });

        $('#editdate_init').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });

        $('#editdate_end').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });
        $("#timepick").timepicker();
        $("#timepick2").timepicker();
        $("#timepick3").timepicker();
        $("#timepick4").timepicker();
    },

};

Cursos.initialize();
