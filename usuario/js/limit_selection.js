// Function to enforce limit on checkbox selections
function checkLimit(checkbox) {
    var limit = parseInt($(checkbox).data('limit'));
    var name = $(checkbox).attr('name');
    var checkedCount = $('input[name="' + name + '"]:checked').length;

    if (checkedCount > limit) {
        checkbox.checked = false;
        alert('Has alcanzado el límite máximo de opciones seleccionables: ' + limit);
    }
}

// Function to handle single option selection (radio button behavior)
function manejarOpcionUnica(name, selectedValue) {
    // Desmarcar todas las opciones con el mismo nombre excepto la seleccionada
    $('input[name="' + name + '"]').not(':checked').prop('checked', false);
}

// Initialize events for single option questions
$(document).ready(function() {
    // For radio buttons (type 5)
    $('input[type=radio]').change(function() {
        var name = $(this).attr('name');
        var selectedValue = $(this).val();
        manejarOpcionUnica(name, selectedValue);
    });
});
