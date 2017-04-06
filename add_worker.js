/**
 * Created by ilaevsin on 03.04.17.
 */
$(document).ready(function() {
    $('#dateRangePicker')
        .datepicker({
            format: 'yyyy-mm-dd',
            startDate: '1900/01/01',
            endDate: '2020/10/12'
        })
        .on('changeDate', function(e) {
            // Revalidate the date field
            $('#dateRangeForm').formValidation('revalidateField', 'date');
        });

    $('#dateRangeForm').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            date: {
                validators: {
                    notEmpty: {
                        message: 'The date is required'
                    },
                    date: {
                        message: 'The date is not a valid',
                        format: 'YYYY/MM/DD'
                    }
                }
            }
        }
    });
});
