<?php
namespace System\Helpers;
use Zend\View\Helper\AbstractHelper;

class loadEditor extends AbstractHelper{

	public function __invoke($field, $width = "100%", $height = "450", $var = "oEdit1"){

		print '<script type="text/javascript" src="/'.FILE_MANAGER_ASSETS.'/editor/scripts/innovaeditor.js"></script>
		<script src="/'.FILE_MANAGER_ASSETS.'/editor/scripts/jquery.innovaeditor.js" type="text/javascript"></script>
		';
		print '
		<script type="text/javascript">
		    // <![CDATA[
		
		var '.$var.' = new InnovaEditor("'.$var.'");
		'.$var.'.width="'.$width.'";
		'.$var.'.height='.$height.';
		'.$var.'.arrCustomButtons = [
		["CustomName1","modelessDialogShow(\'/'.FILE_MANAGER_ASSETS.'/editor/scripts/youtube_video.htm\',380,110)","Insert Youtube","btnYuytube.gif"],
		["CustomName2","modelessDialogShow(\'/'.FILE_MANAGER_ASSETS.'/editor/scripts/paypal.htm\',350,270)","PayPal Button","btnPayPal.gif"],
		["CustomName3","oUtil.obj.insertHTML(\"<img src=\'images/pagesplit.gif\' style=\'display:block;margin-left:auto;margin-right:auto\' />\")","Page Split","btnPagebreak.gif"]
		]
		'.$var.'.toolbarMode = 2;
		'.$var.'.groups=[
		["grpEdit", "", ["XHTMLSource", "FullScreen", "Preview", "Search", "RemoveFormat", "BRK", "Undo", "Redo", "Cut", "Copy", "Paste", "PasteWord", "PasteText"]],
		["grpFont", "", ["FontName", "FontSize", "Strikethrough", "Superscript", "BRK", "Bold", "Italic", "Underline", "ForeColor", "BackColor"]],
		["grpPara", "", ["Paragraph", "Indent", "Outdent", "Styles", "StyleAndFormatting", "Absolute", "BRK", "JustifyLeft", "JustifyCenter", "JustifyRight", "JustifyFull", "Numbering", "Bullets"]],
		["grpInsert", "", ["Hyperlink", "Bookmark", "BRK", "Image", "Form"]],
		["grpTables", "", ["Table", "BRK", "Guidelines", "Guidelines", "CustomName2"]],
		["grpMedia", "", ["Media", "Flash", "CustomName1", "BRK", "CustomTag", "Characters", "Line"]]
		];

		'.$var.'.css="/'.FILE_MANAGER_ASSETS.'/editor/css/custom.css";
		'.$var.'.cmdAssetManager = "modalDialogShow(\''.URL_WEB.'system/file/viewtree\',800,500)";
		'.$var.'.arrCustomTag=[
		["First Last Name","[NAME]"],
		["Username","[USERNAME]"],
		["Site Name","[SITE_NAME]"],
		["Site Url","[URL]"]
		];
		'.$var.'.customColors=["#ff4500","#ffa500","#808000","#4682b4","#1e90ff","#9400d3","#ff1493","#a9a9a9"];
		'.$var.'.mode="XHTMLBody";
		'.$var.'.REPLACE("'.$field.'");
			// ]]>
		</script>
		';
		echo "<style>#idContentoEdit1{margin-top:15px;}</style>";
	}
}