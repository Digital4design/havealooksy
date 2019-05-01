<!DOCTYPE html>
<html>
	<head>
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<style>
			.inline-text{font-size:0.85rem;font-weight:normal;}
			@media only screen and (max-width: 600px) {
			  .inner-body {
			    width: 100% !important;
			  }
			  .footer {
			    width: 100% !important;
			  }
			}
			@media only screen and (max-width: 500px) {
			  .button {
			    width: 100% !important;
			  }
			}
		</style>
	</head>
<body>
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
					    <td align="center" height="50" bgcolor="#9677b3">
					        <a href="http://dev.havealooksy.com/" style="font-size:1.2rem;text-decoration:none;color:#f3e5ff;">
					            LOOKSY
					        </a>
					    </td>
					</tr>
					<tr>
                        <td width="100%" height="300" cellpadding="0" cellspacing="0" style="border:1px solid #e9d1ff;box-shadow:0px 5px 5px #a74cfc;">
                            <table align="center" width="85%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                    	<h2>Hello,</h2>
                                        <h3>{{ $name }} <span class="inline-text">has sent a message,</span></h3>
                                        <h3>Subject: <span class="inline-text">{{ $subject }}</span></h3>
                                        <p style="line-height:2rem;text-align:justify;">{{ $email_message }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
					    <td>
					        <table width="100%" align="center" height="50" cellpadding="0" cellspacing="0" bgcolor="#9677b3">
					            <tr>
					                <td align="center" style="color:#f3e5ff;">
					                    © 2019 Looksy. All rights reserved.
					                </td>
					            </tr>
					        </table>
					    </td>
					</tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
