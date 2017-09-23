var Evaluaciones = {
    initialize: function(){
        console.log('Evaluations Initialize');
        this.newEvaluation();
    },

    newEvaluation: function() {
        $('#new_evaluation').on('click', function(){
            $.ajax({
                synch: 'true',
                type: 'POST',
                url: _root_ + 'evaluaciones/nuevaEvaluacion',
                success: function(data){
                    $('#new_evaluation').hide();
                    $('#evaluation_template').html(data);


                    $('.btn_volver').on('click', function(){
                        // that.getClasses();
                    });
                }
            });
        });
    },
};

Evaluaciones.initialize();
