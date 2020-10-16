$('document').ready(function() {
    window.onresize = function() {
        if (document.documentElement.clientWidth > 600 || window.innerWidth > 617) {
            $('#menu-btn').hide();
            $('#close-btn').hide();
            $('#menu-list').show();
        } else {
            $('#menu-btn').show();
            $('#menu-list').hide();
        }
    }
    $('#menu-btn').click(function() {
        $('#menu-list').show();
        $('#menu-btn').hide();
        $('#close-btn').show();
    });
    $('#close-btn').click(function() {
        $('#menu-list').hide();
        $('#close-btn').hide();
        $('#menu-btn').show();
    });
});