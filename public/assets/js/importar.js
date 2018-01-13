var Import = {
    initialize: function(){
        console.log('Import Initialize');
        $('#example').DataTable();
        this.importStudent();
    },


    importStudent: function() {
        let that = this; 
        $('.btn_import').on('click', function(){
            let alumno = $(this).attr('id');
            $.ajax({
                data: { alumno: alumno },
                synch: 'true',
                type: 'POST',
                url: _root_ + 'alumno/importarAlumno',
                success: function(data){
                    console.log(data);
                }
            });
        }); 
    },
    
};

Import.initialize();
