<script>
    function validation(errors) {
        var validations = '<div class="alert alert-danger">';
        validations += '<ul style="margin-left: -20px; margin-top: 10px">';
        $.each(errors.errors, function (i, error) {
            validations += '<li>' + error[0].charAt(0).toUpperCase() + error[0].slice(1) + '</li>';
        });
        validations += '</ul>';
        validations += '<button type="button" class="btn btn-text-light btn-icon alert-dismiss bg-danger text-light" data-dismiss="alert" style="position: absolute; top: 0; right: 10px">';
        validations += '<i class="fa fa-times"></i>';
        validations += '</button>';
        validations += '</div>';
        return validations;
    }
</script>
