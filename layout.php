<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Miran</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>

<noscript>
	<div id="noscript_column-1" class="noscript_container">
		<div id="noscript_messageoverlay"></div>
		<div id="noscript_messagecontent">
			<b>Javascript error</b><br />
			<br />
			For this site is javascript required. Please make sure you have javascript enabled.<br />
			<br />
		</div>
	</div>
</noscript>

<div id="column-1" class="container">
  <div id="messageoverlay"></div>
  <div id="messagecontent"><b>title</b><br /><br />content <br /><br /><a href="#" onclick="messageOut();">Close message</a></div>
</div>

<div id="msnmessage"><div id="msnmessage_title"><b>title</b></div><br /><div id="msnmessage_content">content</div><br /><a href="#" onclick="msnmessageOut();">Close message</a></div>

<div id="base">

	<div id="header">
		<ul id="topmenu">
			<li><a href="/">Home</a></li>
			<li><a href="/accounts/login/">Log in</a></li>
			<li><a href="/accounts/register/">Register</a></li>
			<li>Contact</li>
		</ul>
    	</div>

	<div id="sidemenu">

        <div id="sidemenu_top_title">Mainmenu</div>
        <div id="sidemenu_top">
                <form method="post" action="login">
                    <table>
                        <tr>
                            <td><label for="id_username">Username</label>: <input id="id_username" type="text" name="username" /></td>
                        </tr>
                        <tr>
                            <td><label for="id_password">Password</label>: <input type="password" name="password" id="id_password" /></td>
                        </tr>
                    </table>

                    <a href="#">Forgot password?</a> <input type="submit" value="login" />
                    <input type="hidden" name="next" value="/profile/" />
                </form>
        </div>

        <div id="sidemenu_second_title">Statistics</div>
        <div id="sidemenu_second">
                <p>You are not logged in. Please <a href="/accounts/login/">log in</a> to see your stats.</p>
                <p>If you do not have an account yet, you can <a href="/accounts/register/">register here</a>.</p>                
        </div>
	
    </div>

	<div id="content_top">Title HERE!</div>
    <div id="content">Content here!</div>
    <div id="content_bottom"></div>

</div>

<div id="footer">&copy; Copyright <b>Miran.com</b> 2008-2009. All rights reserved.</div>

</body>
</html>
