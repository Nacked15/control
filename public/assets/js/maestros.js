var Maestros = {
    initialize: function(){
        console.log('Maestros Initialize');
        this.tables();
        this.newTeacher();
        this.editTeacher();
    },

    tables: function() {
        $('#example').DataTable();
    },

    newTeacher: function(){
        let that = this;
        $('#newTeacher').on('click', function(){
            $('#modalAddTeacher').modal('show');

            $("#avatar").fileinput({
                showCaption: true,
                browseClass: "btn btn-info btn-sm btn-lg",
                fileType: "image"
            });
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

Maestros.initialize();
