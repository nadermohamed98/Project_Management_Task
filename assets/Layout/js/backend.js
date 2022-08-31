$(function() {
    'use strict';
    // Hide Placeholder On Form Focus
    $('[placeholder]').focus(function() {
        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', '');
    }).blur(function() {
        $(this).attr('placeholder', $(this).attr('data-text'));
    });
    // Add Asterisk On Required Field
    $('input').each(function() {
        if ($(this).attr('required') === 'required') {
            $(this).after('<span class="asterisk">*</span>');
        }
    });
    // Convert Password Field To Text Field On Hover
    var passField = $('.password');
    $('.show-pass').hover(function() {

        passField.attr('type', 'text');

    }, function() {
        passField.attr('type', 'password');
    });
    // Confirmation Message On Button
    $('.confirm').click(function() {
        return confirm('Are You Sure ??');
    });
});


<
script >
    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toLowerCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toLowerCase().indexOf(filter) > -1) {
                    tr[0].style.display = "";
                    tr[i].style.display = "";
                } else {
                    tr[0].style.display = "";
                    tr[i].style.display = "none";
                }
            }
        }
    } <
    /script>
    /script>
    /script>
    /script>
    /script>
    /script>
    /script>