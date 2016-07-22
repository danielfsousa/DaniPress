$(function() {

    $('#selecionarTodos').on('click', function(e) {

        if(this.checked) {
            $('.selecionar').each(function() {
                this.checked = true;
            });
        } else {
            $('.selecionar').each(function() {
                this.checked = false;
            });
        }

    });

});
