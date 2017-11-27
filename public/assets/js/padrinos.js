var Padrinos = {
    initialize: function(){
        console.log('Padrinos Initialize');
        this.getAllSponsors();
        this.newSponsor();
        this.saveSponsor();
    },

    tables: function() {
        $('#example').DataTable();
    },

    getAllSponsors: function() {
        let that = this;
        $.ajax({
            synch: 'true',
            type: 'POST',
            url: _root_ + 'padrinos/padrinos',
            success: function(data){
                $('#sponsors_list').html(data);
                that.tables();
            }
        });
    },

    newSponsor: function(){
        let that = this;
        $('#btnAddSponsor').on('click', function(){
            $('#modalAddNewSponsor').modal('show');
        });
    },

    saveSponsor: function(){
        let that = this;
        $('#saveNewSponsor').on('click', function(){
            var name = $('#sponsor_name');
            if (name !== '' && name !== undefined) {
                $.ajax({
                    data: $('#frmNewSponsor').serialize(),
                    synch: 'true',
                    type: 'POST',
                    url: _root_ + 'padrinos/nuevoPadrino',
                    success: function(data){
                        var response = JSON.parse(data);
                        switch(response) {
                            case 1:
                                $('#general_snack').attr('data-content', 'Datos guardados correctamente!');
                                $('#general_snack').snackbar('show');
                                $('.snackbar').addClass('snackbar-green');
                                break;
                            case 2:
                                $('#general_snack').attr('data-content', 'Fallo guardado de becario!');
                                $('#general_snack').snackbar('show');
                                $('.snackbar').addClass('snackbar-red');
                                break;
                            default:
                                $('#general_snack').attr('data-content', 'Error desconocido: Intente de nuevo!');
                                $('#general_snack').snackbar('show');
                                $('.snackbar').addClass('snackbar-red');
                                break;
                        }

                        $('#modalAddNewSponsor').modal('hide');
                        that.getAllSponsors();
                    }
                });
            }
        });
    },

    editTeacher: function(){
        let that = this;
        $('.editTeacher').on('click', function(){
            var teacher = $(this).data('teacher');
            $.ajax({
                data: { maestro: teacher },
                synch: 'true',
                type: 'POST',
                url: _root_ + 'maestro/maestro',
                success: function(data){
                    var res = JSON.parse(data);
                    $('#user_id').val(res.user_id);
                    $('#name').val(res.name);
                    $('#lastname').val(res.lastname);
                    $('#user_name').val(res.user_name);
                    $('#user_email').val(res.user_email);
                    
                    $('#modalEditTeacher').modal('show');
                }
            });
        });
    }
};

Padrinos.initialize();
