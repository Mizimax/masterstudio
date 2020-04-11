<div style="background-color: #f5f5f5">
    <table style="max-width: 450px; width: 100%; margin: 0 auto;  border-collapse:separate;
    border-spacing:0 10px;" align="center">
        <tr style="background-color: white;">
            <td align="center" style=" padding: 10px">
                <img src="{{$message->embed(asset('/img/logo/logo.png'))}}" alt="@Masterstudio"
                     width="226" />
            </td>
        </tr>
        <tr style="background-color: white;">
            <td align="left" style="padding: 20px; font-size: 13px">
                Hi {{ $user_firstname . $user_surname }}, <br />
                <p style="text-indent: 20px">Welcome to @Masterstudio. Your subscription is now
                    active and you can log in with your email: {{ $user_email }} and password to
                    start experiencing all that we have to offer.</p>
            </td>
        </tr>
        <tr style="background-color: white;">
            <td align="center" style="padding: 20px; font-size: 10px">
                Copyright © 2020 @Masterstudio<br />All Rights Reserved
            </td>
        </tr>
    </table>
</div>
