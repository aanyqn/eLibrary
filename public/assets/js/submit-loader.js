const form = $('#form');
const button = $('#submitBtn');

button.click(function() {
    if (!form[0].checkValidity()) {
        form[0].reportValidity();
        return;
    }
    button.prop('disabled', true);
    button.text('');
    button.html('<span class="spinner-border spinner-border-sm"></span> Loading...');
    form.submit();
})