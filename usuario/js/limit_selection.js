function checkLimit(checkbox) {
    var limit = parseInt($(checkbox).data('limit'));
    var name = $(checkbox).attr('name');
    var checkedCount = $('input[name="' + name + '"]:checked').length;

    if (checkedCount > limit) {
        checkbox.checked = false;
        // Show error toast instead of alert
        var toast = $('.jq-toast-single.jq-icon-error');
        if (toast.length === 0) {
            // Create toast container if it doesn't exist
            toast = $('<div class="jq-toast-single jq-icon-error" style="display:none; position: fixed; top: 20px; right: 20px; z-index: 9999; background-color: #ff6849; color: white; padding: 15px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.3); max-width: 300px;"></div>');
            $('body').append(toast);
        }
        toast.html('<span class="close-jq-toast-single" style="cursor:pointer; float:right; font-weight:bold;">×</span><h2 class="jq-toast-heading" style="margin:0 0 10px 0;">Error</h2>Has alcanzado el límite máximo de opciones seleccionables: ' + limit + '.</h2>');
        toast.css('display', 'block');
        toast.css('text-align', 'left');

        // Close button handler
        toast.find('.close-jq-toast-single').click(function() {
            toast.fadeOut();
        });

        // Hide the toast after 3 seconds
        setTimeout(function() {
            toast.fadeOut();
        }, 3000);
    }
}

function manejarOpcionUnica(name, selectedValue) {
    // Desmarcar todas las opciones con el mismo nombre excepto la seleccionada
    $('input[name="' + name + '"]').not(':checked').prop('checked', false);
}

$(document).ready(function() {
    // For radio buttons (type 5)
    $('input[type=radio]').change(function() {
        var name = $(this).attr('name');
        var selectedValue = $(this).val();
        manejarOpcionUnica(name, selectedValue);
    });
});
