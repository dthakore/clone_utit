<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>{{ config('app.name') }} - Verify Your SIO Email</title>
</head>
<body style="margin:0; padding:0;background-color:#ffffff;">
<style>
    @media (max-width: 767px) {
        big {font-size:36px !Important;}
        .blue-content {margin:0 !important;}
        h2 {font-size:16px !Important; line-height:22px !important; margin-left:0 !Important; margin-right:0 !important;}
        .bg-grey{margin:0 !important;}
        h1 {font-size:24px !Important;margin:30px 0 !Important;}
        strong, p {font-size:14px !Important;}
    }
</style>
<table style="max-width:800px; margin:0 auto;" width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td colspan="3" style="background:#fff no-repeat right;background-size:cover;padding:0;" align="center">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="4%">&nbsp;</td>
                    <td align="center">
                        <a href="javascript:void()"  style="display:inline-block;">
                            <img src="{{ asset('img/eazybot-logo.png') }}" alt="logo" style="max-width: 30%; margin: 30px 0;"/>
                        </a>
                    </td>
                    <td width="4%">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td width="4%"></td>
        <td align="center">
            <h1 style="font-size:32px; text-transform:uppercase; color:#005aa0; margin:30px 0 50px; font-family:open sans, arial; font-weight:bold;text-align: center;">SIO Account Verification</h1>
            <p style="font-size:16px;color:#5e5e5f;font-family:open sans, arial; margin:0 0 20px;text-align: center;">Hi,</p>
            <p style="font-size:16px;margin:0 0 20px; color:#5e5e5f;font-family:open sans, arial;text-align: center;">We've noticed an activation request at {{ config('app.name') }} through your SIO account. </p>
            <h2 style="font-family:open sans, arial; margin:0 0 20px; color:#5e5e5f; font-size:28px; line-height:32px; text-transform:uppercase; font-weight:400;text-align: center;">you're moving in the right direction!</h2>
            <p style="font-size:16px;margin:0 0 20px; color:#5e5e5f;font-family:open sans, arial;text-align: center;">We just wanted to keep you informed about this activity.!</p>
            <big style="font-family:open sans, arial; font-weight:bold; text-transform:uppercase; color:#d4537d; margin:0; display:block;text-align: center;">Kindly permit us to share some account details with {{ config('app.name') }} from SIO!</big>
        </td>
        <td width="4%"></td>
    </tr>
    <tr>
        <td width="4%"></td>
        <td align="center">
            <div style="width: 300px; margin-bottom: 10px; padding: 10px;text-align: center;">
                @if(isset($url))
                    Permit us by clicking on <a style="text-decoration:none;" href="{{ $url }}">this</a> link
                @endif
            </div>
        </td>
        <td width="4%"></td>
    </tr>
    <tr>
        <td width="4%"></td>
        <td align="center">
            <div class="bg-grey" style="padding:30px 5% 10px; background-color:#eeeeee; margin:0 4%;text-align: center;">
                {{--<div style="display:block; margin:0 0 10px;font-family:open sans, arial;">
                    <a href="javascript:void()" style="margin:0 2px; display:inline-block;"></a>
                    <a href="javascript:void()" style="margin:0 2px; display:inline-block;"></a>
                    <a href="javascript:void()" style="margin:0 2px; display:inline-block;"></a>
                    <a href="javascript:void()" style="margin:0 2px; display:inline-block;"></a>
                </div>
                <p style="font-size:15px;color:#5e5e5f; margin:0 0 10px; font-family:open sans, arial;text-align: center;">Olenseweg 375<br/>2260 Westerlo<br/>Belgium</p> --}}
                <p style="font-size:15px;color:#5e5e5f;margin:0 0 10px; font-family:open sans, arial;text-align: center;text-align: center;">Technical Inquiries or Support: <a style="color:#5e5e5f; text-decoration:none;text-align: center;" href="mailto:Support@utradeitrade.com">Support@utradeitrade.com</a><br />
                    Financial Inquiries: <a style="color:#5e5e5f; text-decoration:none;text-align: center;" href="mailto:info@utradeitrade.com">info@utradeitrade.com</a></p>
            </div>
        </td>
        <td width="4%"></td>
    <tr>
        <td width="4%"></td>
        <td align="center" bgcolor="#fff"><br/>
            <small style="font-size:12px;color:#5e5e5f; font-family:open sans, arial;text-align: center;">This is an automatically generated email.<br/>
                Please do not reply as your message will not be received and will be returned to you by the mail server.</small>
            <p style="font-size:13px;color:#5e5e5f; font-family:open sans, arial;text-align: center;">© {{ date('Y') }} {{ config('app.name') }}</p>
        </td>
        <td width="4%"></td>
    </tr>
</table>
</body>
</html>