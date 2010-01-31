{% load inbox %}
{% load render_statbars %}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Miran v3 (django based) | {% block page_title %}{% endblock %}</title>
<link rel="stylesheet" type="text/css" href="http://miranmedia.krisje8.com/style.css" />
{% block js %} {% endblock %}
{% if not user.is_anonymous %}
<script src="{{ MEDIA_URL }}/js/json.js" type="text/javascript"></script>
<script src="{{ MEDIA_URL }}/js/jquery-1.3.2.min.js" type="text/javascript"></script>

<script type="text/javascript">
function pullMessages(){
	$.getJSON("/check_messages/", function(json){
		$.each(json, function(i,item){
			msnmessageIn("New message!", json[i].fields.body);
		});
	});
	setTimeout("pullMessages()", 1500);
}
pullMessages();
</script>
{% endif %}
</head>

<body>

<noscript><div id="noscript_column-1" class="noscript_container"><div id="noscript_messageoverlay"></div><div id="noscript_messagecontent"><b>Javascript error</b><br /><br />For this site is javascript required. Please make sure you have javascript enabled.<br /><br /></div>
</div></noscript>

<div id="column-1" class="container">
  <div id="messageoverlay"></div>
  <div id="messagecontent"><b>title</b><br /><br />content <br /><br /><a href="#" onclick="messageOut();">Close message</a></div>
</div>

<div id="msnmessage"><div id="msnmessage_title"><b>title</b></div><br /><div id="msnmessage_content">content</div><br /><a href="#" onclick="msnmessageOut();">Close message</a></div>

<div id="base">

	<div id="header">

		{% if user.is_anonymous %}
		<ul id="topmenu">
			<li><a href="/">Home</a></li>
			<li><a href="/accounts/login/">Log in</a></li>
			<li><a href="/accounts/register/">Register</a></li>
			<li>Contact</li>
		</ul>
		{% else %}
        <ul id="topmenu">
			<li><a href="/">Miran</a></li>
			<li><a href="#">Forum</a></li>
			<li><a href="#">Somelink</a></li>
			<li><a href="/accounts/logout/">Logout</a></li>
		</ul>
        {% endif %}

    </div>

	<div id="sidemenu">

        <div id="sidemenu_top_title">Mainmenu</div>
        <div id="sidemenu_top">

        		{% if user.is_anonymous %}
                <form method="post" action="{% url django.contrib.auth.views.login %}">
                    <table>
                        <tr>
                            <td><label for="id_username">Username</label>: <input id="id_username" type="text" name="username" maxlength="30" /></td>
                        </tr>
                        <tr>
                            <td><label for="id_password">Password</label>: <input type="password" name="password" id="id_password" /></td>
                        </tr>
                    </table>

                    <a href="#">Forgot password?</a> <input type="submit" value="login" />
                    <input type="hidden" name="next" value="/profile/" />
                </form>
                {% else %}

                <ul id="sidemenu_top_cats">
                    <li>Character
                        <ul>
                            <li><a href="/profile/">Headquarter</a></li>
                            <li><a href="/inventory/">Inventory</a></li>
                        </ul>
                    </li>

                    <li>Actions
                        <ul>
                            <li>Explore</li>
                            <li>Skills</li>
                            <li>Travel</li>
                        </ul>
                    </li>

                    <li>Game options
                        <ul>
                            <li><a href="/messages/inbox/">Messages ({% inbox_count %})</a></li>
                            <li><a href="/messages/compose/">Send a message</a></li>
                            <li><a href="/memberlist/">Memberlist</a></li>
                            <li><a href="/onlineusers/">Online users</li>
                            <li><a href="/accounts/logout/">Logout</a></li>
                        </ul>
                    </li>

                    <li>Cool stuff
                        <ul>
                            <li><a href="/changelog/">Changelog</a></li>
                            <li><a href="/bugs/">Bugreport</a></li>
                        </ul>
                    </li>

                </ul>
                {% endif %}

        </div>

        <div id="sidemenu_second_title">Statistics</div>
        <div id="sidemenu_second">
            {% if user.is_anonymous %}
                <p>You are not logged in. Please <a href="/accounts/login/">log in</a> to see your stats.</p>
                <p>If you do not have an account yet, you can <a href="/accounts/register/">register here</a>.</p>                
            {% else %}
                {% if user.get_profile %}
                {% with user.get_profile as character %}
                    <b>{{ user }}</b> <span style="font-size: 9px;">[lvl{{ character.level }}]<br />{{ character.race }}</span><br />
                    <table cellpadding="0" cellspacing="0" style="padding-top: 7px;">
                    	<tr>
                        	<td style="padding-right: 7px;">HP: </td>
                        	<td><div id="hpbar"><div id="hpbar_inner" style="width: {% calc_hp character.currenthp character.generate_stats.hp %}px;"></div></div></td>
                        </tr>
                        <tr>
                        	<td>MP: </td>
                            <td><div id="mpbar"><div id="mpbar_inner" style="width: {% calc_mp character.currentmana character.generate_stats.mana %}px;"></div></div></td>
                        </tr>
                    </table>
                    {% with user.get_profile.generate_stats as stats %}
                        <ul id="statistics_left">
                            <li id="stat_attack">{{ stats.attack }}</li>
                            <li id="stat_defence">{{ stats.defence }}</li>
                            <li id="stat_critical">{{ stats.critrate }}</li>
                        </ul>

                        <ul id="statistics_right">
                            <li id="stat_attackspeed">{{ stats.speed }}</li>
                            <li id="stat_gold">{{ character.gold }}</li>
                            <li id="stat_crystal">0</li>
                        </ul>
                    {% endwith %}
                    <!--<div id="expbar"><div id="expbar_inner" style="width: {% calc_hp character.currenthp character.generate_stats.hp %}px;"></div></div>    

                    <li>HP: {{ character.currenthp }}/{{ character.generate_stats.hp }}</li>
                            <li>Mana: {{ character.currentmana }}/{{ character.generate_stats.mana }}</li>
                            <li>Level: {{ character.level }}</li>
                            <li>Race: {{ character.race }}</li>
                            <li>Gold: {{ character.gold }}</li>
                            <li>{% if character.is_alive %}<font color="green">Alive</font>{% else %}<font color="red">Dead</font>{% endif %}</li>-->  
                {% endwith %}
                {% else %}
                    <p>You have not set up a profile yet, <a href="/profile/">click here to do so</a>.</p>
                {% endif %}
            {% endif %}
        </div>
	
    </div>

	<div id="content_top">{% block content_title %}{% endblock %}</div>
    <div id="content">{% block content %}{% endblock %}</div>
    <div id="content_bottom"></div>

</div>

<div id="footer">&copy; Copyright <b>Miran.com</b> 2008-2009. All rights reserved.</div>

</body>
</html>

