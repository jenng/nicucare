<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>UBER CORP SHORTCODES</title>
	<link href='http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/custom.css">
	<script language="javascript" type="text/javascript" src="js/tiny_mce_popup.js"></script>
	<script type="text/javascript" src="js/dialog.js"></script>
</head>
<body onLoad="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';">
<form onsubmit="tinypluginDialog.insert();return false;" action="#">
	<p>Choose Your Shortcodes here. </p>
	<p>
		<select id="shortcode" name="shortcode">
			<option value="Button">Button</option>
			<option value="Icon">Icon</option>	
		</select>
	</p>
	<script>
	function result(){
		var resultstring;
		var getstr=tinyMCE.activeEditor.selection.getContent();

		if(document.getElementById('shortcode').value == 'Icon'){
			resultstring = '[icon name= "icon name" size= "small/medium/large" style= "circle/plain/square" color= "" bg_color= "" hover_color= "" hover_bg_color= "" href= ""]';
		}
		if(document.getElementById('shortcode').value == 'Button'){
			resultstring = '[button button_text= "" type= "small/medium/large" rounded= "1/0" icon= "icon name" color= "bg color code" hover= "bg color code in hover state" url= ""]';
		}

		tinyMCE.activeEditor.selection.setContent(resultstring);
		tinyMCEPopup.close();
	}
	</script>
	<div class="mceActionPanel">
		<input type="button" id="insert" name="insert" value="{#insert}" onclick="result();" />
		<input type="button" id="cancel" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" />
	</div>
</form>

</body>
</html>
