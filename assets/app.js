import './styles/app.css';

$(document).ready(function() {
    $('#message_history_channel').on('change', function() {
        let selected = $(this).find('option:selected');
        $('#message_history_type option').eq(1).prop('disabled', !selected.data('email'));
        $('#message_history_type option').eq(2).prop('disabled', !selected.data('sms'));
        $('#message_history_type option').eq(3).prop('disabled', !selected.data('webpush'));
        $('#message_history_type option').eq(4).prop('disabled', !selected.data('telegram'));
        $('#message_history_type option').eq(5).prop('disabled', !selected.data('viber'));

        $('#message_history_type').val('');

    });

    $('#message_history_channel').change();
});