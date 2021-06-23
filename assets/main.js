$().ready(function ()
{
    $('#email_form').submit(function (e)
    {
        e.preventDefault();
        let text = $('#email_text').val();
        if(text.length ==0)
        {
            $('#email_text').css('border-color','red');
            return;
        }
        let data = {
            email_text: text
        };
        $.ajax({
            type: "POST", url: '/actions/sendEmail.php', data: data, success: function (response)
            {
                let node = $('<div style="text-align: center;margin-top: 5px; color: #ffe000;font-size: 1.2em"><p>Письмо отправлено</p></div>');
                $('#email_form').append(node);
            }
        });
    });
    $('#email_text').keyup(function ()
    {
        $('#email_text').css('border-color','unset');
    });
});