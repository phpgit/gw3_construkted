;(function($) {
    $('#refresh-tiling-state').click(function () {
        $.ajax({
            url : construktedAdminParam.tilingStateEndPoint,
            type : 'get',
            data : {
            },
            success : function( response ) {
                $('#tiling-state-info').html(JSON.stringify(response));
            },
            error: function(xhr, status, error) {
                alert(error);
            }
        });
    });
})(jQuery);
