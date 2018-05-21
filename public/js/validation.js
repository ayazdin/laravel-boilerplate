$(document).ready(function() {
    $('#frmRequest')
        .formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                quantity: {
                    validators: {
                        integer: {
                            message: 'The value is not an integer',
                            // The default separators
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        }
                    }
                }
            }
        })
        .on('change', '[name="country"]', function() {
            var thousandsSeparator = '',
                decimalSeparator   = '.';
            switch ($(this).val()) {
                case 'en_US':
                    thousandsSeparator = ',';
                    decimalSeparator   = '.';
                    break;

                case 'fr_FR':
                    thousandsSeparator = ' ';
                    decimalSeparator   = ',';
                    break;

                case 'it_IT':
                    thousandsSeparator = '.';
                    decimalSeparator   = ',';
                    break;

                case '':
                default:
                    thousandsSeparator = '';
                    decimalSeparator   = '.';
                    break;
            }

            $('#integerForm')
                // Update the options
                .formValidation('updateOption', 'number', 'integer', 'thousandsSeparator', thousandsSeparator)
                .formValidation('updateOption', 'number', 'integer', 'decimalSeparator', decimalSeparator)
                // and revalidate the number
                .formValidation('revalidateField', 'number');
        })
});
