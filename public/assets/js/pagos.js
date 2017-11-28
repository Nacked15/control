var Pagos = {
    initialize: function(){
        console.log('Pagos Initialize');
        this.defaultPaylist();
        this.getPaylist();
    },

    defaultPaylist: function(){
        let that = this;
        var list = sessionStorage.getItem('plist_alive');
        that.showPaylist(list); 
    },

    getPaylist: function(){
        let that = this;
        $('.menu_pay_list li').on('click', function(){ 
            var list = $(this).data('group');
            that.showPaylist(list);
            
        }); 
    },

    showPaylist: function(lista){
        let that = this;
        $.ajax({
            data: { lista :  lista },
            synch: 'true',
            type: 'POST',
            url: _root_ + 'pagos/obtenerListaPagos',
            success: function(data){
                switch(parseInt(lista)) {
                    case 1: $('#pay_club').html(data);
                        break;
                    case 2: $('#pay_primary').html(data); 
                        break;
                    case 3: $('#pay_adolescent').html(data);
                        break;
                    case 4: $('#pay_adult').html(data);
                        break;
                    case 6: $('#pay_all').html(data);
                        break;
                }
                $.material.init();
                that.tables(lista);
            }
        });
    },

    tables: function(list) {
        $('#tbl_paylist_'+list).DataTable();
    },
};

Pagos.initialize();
