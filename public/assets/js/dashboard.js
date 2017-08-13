var Dashboard = {
    initialize: function(){
        console.log('Dashboard Initialize');
        this.displayUserTasks();
        this.saveNewTask();
        $('#date_todo').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });
        $('#edit_date_todo').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });

        // $('[data-toggle="popover"]').popover();
    },

    displayUserTasks: function(){
        let that = this;
        $.ajax({
            synch: 'true',
            type: 'GET',
            url: _root_ + 'user/getUserTasks',
            success: function(data){
                $('#task_list').html(data);
                that.updateTask();
                that.detailTask();
                that.deleteTask();
            }
        });
    },

    saveNewTask: function(){
        let that = this;
        $('#btn_save_task').on('click', function(){
            if ($('#date_todo').val() !=='' && $('#event').val() !=='') {
                $.ajax({
                    data: $('#form_new_task').serialize(),
                    synch: 'true',
                    type: 'POST',
                    url: _root_ + 'user/addNewTask',
                    success: function(data){
                        if (data === '1') {
                            $('#date_todo').val('');
                            $('#event').val('')
                            $('#newTask').modal('hide');
                            $("#new_snack").snackbar("show");
                            that.displayUserTasks();
                        }
                    }
                });
            } else {
                $("#empty_snack").snackbar("show");
                // $('#general_snack').attr('data-content', 'putooo');
                // $('#general_snack').snackbar('show');
            }
        });
    },

    updateTask: function() {
        let that = this;
        $('.btn_edit_task').click(function(){
            $('#editTask').modal('show');
            var tarea = $(this).attr('id');
            $.ajax({
                data: { tarea: tarea },
                synch: 'true',
                type: 'POST',
                url: _root_ + 'user/getTask',
                success: function(data){
                    if (data !== 'null') {
                        var res = JSON.parse(data);
                        
                        $('#id_task').val(res.id_task);
                        $('#edit_date_todo').val(res.date_todo);
                        switch(parseInt(res.priority)) {
                            case 1: $('#edit_opt1').prop('checked',true); break;
                            case 2: $('#edit_opt2').prop('checked',true); break;
                            case 3: $('#edit_opt3').prop('checked',true); break;
                        }
                        $('#edit_event').val(res.task);
                    }
                }
            });
        });

        $('#btn_update_task').click(function() {
            if ($('#edit_date_todo').val() !=='' && $('#edit_event').val() !=='') {
                $.ajax({
                    data: $('#form_update_task').serialize(),
                    synch: 'true',
                    type: 'POST',
                    url: _root_ + 'user/editUserTask',
                    success: function(data){
                        if (data === '1') {
                            $('#editTask').modal('hide');
                            $('#general_snack').attr('data-content', 'Recordatorio actualizado!');
                            $('#general_snack').snackbar('show');
                            that.displayUserTasks();
                        }
                    }
                });
            } else {
                $('#general_snack').attr('data-content', 'Ha dejado campos vacios!');
                $('#general_snack').snackbar('show');
            }
        });
    },

    detailTask: function() {
        let that = this;
        $('.btn_detail_task').click(function(){
            var tarea = $(this).attr('id');
            $.ajax({
                data: { tarea: tarea },
                synch: 'true',
                type: 'POST',
                url: _root_ + 'user/getTask',
                success: function(data){
                    $('#detailTask').modal('show');
                    if (data !== 'null') {
                        var res = JSON.parse(data);
                        
                        $('#date_memo').text(res.date_todo);
                        switch(parseInt(res.priority)) {
                            case 1: $('#prior').addClass('label-warning');
                                    $('#prior').removeClass('label-primary');
                                    $('#prior').removeClass('label-success');
                                    $('#prior').html('&nbsp;&nbsp; ALTA &nbsp;&nbsp;');break;
                            case 2: $('#prior').addClass('label-primary');
                                    $('#prior').removeClass('label-warning');
                                    $('#prior').removeClass('label-success'); 
                                    $('#prior').text('NORMAL'); break;
                            case 3: $('#prior').addClass('label-success');
                                    $('#prior').removeClass('label-warning');
                                    $('#prior').removeClass('label-primary'); 
                                    $('#prior').html('&nbsp;&nbsp; BAJA &nbsp;&nbsp;'); break;
                        }
                        $('#detail_event').html(res.task);
                    }
                }
            });
        });
    },


    deleteTask: function() {
        let that = this;
        $('.btn_delete_task').click(function(){
            $('#delete_task_id').val($(this).attr('id'));
            $('#delete_task').modal('show');
        });

        $('#btn_confirm_delete').click(function() {
            $.ajax({
                data: { tarea : $('#delete_task_id').val() },
                synch: 'true',
                type: 'POST',
                url: _root_ + 'user/removeUserTask',
                success: function(data){
                    if (data === '1') {
                        that.displayUserTasks();
                        $("#del_snack").snackbar("show");
                        $('#delete_task').modal('hide');
                    } 
                    // else {
                    //     var notification = new Notification("No se elimino el recordatorio, intente de nuevo!");
                    //     $('#delete_task').modal('hide');
                    // }
                }
            });
        });
    }

    // if (Notification.permission === "granted") {
    //     var notification = new Notification("Hay Campos vacios!");
    // }

};

Dashboard.initialize();

