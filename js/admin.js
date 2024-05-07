let isShown = false 

$('#show-hide-admin-password').click(function(){
    // Get the current type of the password input
    var type = $('#admin-login-password').attr('type');
    // Toggle between password and text
    if(type === 'password') {
        $('#admin-login-password').attr('type', 'text');
        $(this).text('Hide Password');
    } else {
        $('#admin-login-password').attr('type', 'password');
        $(this).text('Show Password');
    }
});