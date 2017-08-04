var Maestros = {
    initialize: function(){
        console.log('Maestros Initialize');
        this.tables();
    },

    tables: function() {
        $('#example').DataTable();
    },
};

Maestros.initialize();
