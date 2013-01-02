<?php
// Popup window for viewing images
//
// webtrees: Web based Family History software
// Copyright (C) 2013 webtrees development team.
//
// Derived from PhpGedView
// Copyright (C) 2002 to 2009  PGV Development Team.  All rights reserved.
//
// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//
// $Id$

define('WT_SCRIPT_NAME', 'imageview.php');
require './includes/session.php';

$controller=new WT_Controller_Media();

$view='simple'; // TODO, this is a "full screen" controller, but this is a "simple" page.
$controller->pageHeader();

if (!$controller->record) {
	echo '<b>', WT_I18N::translate('Unable to find record with ID'), '</b>';
	exit;
}

if (!$controller->record->canDisplayDetails()) {
	print_privacy_error();
	exit;
}
?>
<script>
	var zoom = 100;
	function zoomin() {
		i = document.getElementById('theimage');
		zoom=zoom+10;
		i.style.width=Math.round((zoom/100)*imgwidth)+"px";
		i.style.height=null;
		document.getElementById('zoomval').value=Math.round(zoom);
	}
	function zoomout() {
		i = document.getElementById('theimage');
		zoom=zoom-10;
		if (zoom<10) zoom=10;
		diff = i.offsetWidth - Math.round((zoom/100)*imgwidth);
		i.style.width=Math.round((zoom/100)*imgwidth)+"px";
		i.style.height=null;
		viewport = document.getElementById("imagecropper");
		if (i.offsetLeft<-5) i.style.left = i.offsetLeft+diff + "px";
		if (i.offsetTop<-5) i.style.top = i.offsetTop+diff+ "px";
		document.getElementById('zoomval').value=Math.round(zoom);
	}
	function setzoom(perc) {
		i = document.getElementById('theimage');
		zoom=parseInt(perc);
		if (zoom<10) zoom=10;
		i.style.width=Math.round((zoom/100)*imgwidth)+"px";
		i.style.height=null;
		//viewport = document.getElementById("imagecropper");
		//if (i.offsetLeft + i.offsetWidth < 0) i.style.left = (viewport.offsetWidth - i.offsetWidth) + "px";
		//if (i.offsetTop + i.offsetHeight < 0) i.style.top = (viewport.offsetHeight - i.offsetHeight) + "px";
	}
	function resetimage() {
		setzoom('100');
		document.getElementById('zoomval').value=zoom;
		i = document.getElementById('theimage');
		i.style.left='0px';
		i.style.top='0px';
	}
	var oldMx = 0;
	var oldMy = 0;
	var movei = "";
	function panimage() {
		if (movei=="") {
			oldMx = msX;
			oldMy = msY;
		}
		i = document.getElementById('theimage');
		//alert(i.style.top);
		movei = i;
		return false;
	}
	function releaseimage() {
		movei = "";
		return true;
	}
	// Main function to retrieve mouse x-y pos.s
	function getMouseXY(e) {
	if (IE) { // grab the x-y pos.s if browser is IE
		msX = event.clientX + document.documentElement.scrollLeft;
		msY = event.clientY + document.documentElement.scrollTop;
	} else {  // grab the x-y pos.s if browser is NS
		msX = e.pageX;
		msY = e.pageY;
	}
	// catch possible negative values in NS4
	if (msX < 0) {msX = 0;}
	if (msY < 0) {msY = 0;}
	if (movei!="") {
		ileft = parseInt(movei.style.left);
		itop = parseInt(movei.style.top);
		ileft = ileft - (oldMx-msX);
		itop = itop - (oldMy-msY);
		movei.style.left = ileft+"px";
		movei.style.top = itop+"px";
		oldMx = msX;
		oldMy = msY;
		return false;
		}
	}

	function resizeWindow() {
		if (document.images) {
			if (document.images.length == 3) {
				height=document.images[0].height+80;
				width=document.images[0].width+20;
				if (width > screen.width-100) width = screen.width-100;
				if (height > screen.height-110) height = screen.height-110;
				if (document.layers) window.resizeTo(width+20,height+20)
				else if (document.all) window.resizeTo(width+30,height+50)
				else if (document.getElementById) window.resizeTo(width+40,height+20)
			}
			else setTimeout('resizeWindow()',1000);
		}
		resizeViewport();
		resetimage();
	}

	function resizeViewport() {
		if (IE) {
			pagewidth = document.documentElement.offsetWidth;
			pageheight = document.documentElement.offsetHeight;
		}
		else {
			pagewidth = window.outerWidth-25;
			pageheight = window.outerHeight-25;
		}
		viewport = document.getElementById("imagecropper");
		viewport.style.width=(pagewidth-35)+"px";
		viewport.style.height=(pageheight-60)+"px";
		i = document.getElementById('theimage');
		i.style.left="0px";
		i.style.top="0px";
		if ((pagewidth-40)-imgwidth < ((pageheight-65)-imgheight)) {
			i.style.width=(pagewidth-40)+"px";
			i.style.height=null;
			zoom = ((pagewidth-40) / imgwidth)*100;
		}
		else {
			i.style.height=(pageheight-65)+"px";
			i.style.width=null;
			zoom = ((pageheight-65) / imgheight)*100;
		}
		document.getElementById('zoomval').value=Math.round(zoom);
	}

	var IE = document.all?true:false;
	if (!IE) document.captureEvents(Event.MOUSEMOVE | Event.MOUSEUP)
	document.onmousemove = getMouseXY;
	document.onmouseup = releaseimage;

	window.onresize = resizeViewport;
	//window.onload = resizeWindow;
</script>
<?php

echo "<form name=\"zoomform\" onsubmit=\"setzoom(document.getElementById('zoomval').value); return false;\" action=\"imageview.php\">";
if (!$controller->record->isExternal() && !$controller->record->fileExists() ) {
	echo '<p class="ui-state-error">', WT_I18N::translate('The file “%s” does not exist.', $controller->record->getLocalFilename()), '</p>';
} else {
	echo "<center><font size=\"6\"><a href=\"#\" onclick=\"zoomin(); return false;\">+</a> <a href=\"#\" onclick=\"zoomout();\">&ndash;</a> </font>";
	echo "<input type=\"text\" size=\"2\" name=\"zoomval\" id=\"zoomval\" value=\"100\">%";
	echo "<input type=\"button\" value=\"".WT_I18N::translate('Reset')."\" onclick=\"resetimage(); return false;\">";
	echo "<br><a href=\"#\" onclick=\"window.opener.location='".$controller->record->getRawUrl()."'; window.close();\">".WT_I18N::translate('View image details')."</a>";
	echo "</center>";
	$imgsize = $controller->record->getImageAttributes('main',2,2);
	$imgwidth = $imgsize['adjW'];
	$imgheight = $imgsize['adjH'];
	echo '<script>';
	echo "var imgwidth = $imgwidth-5; var imgheight = $imgheight-5;";
	echo "var landscape = false;";
	echo "if (imgwidth > imgheight) landscape = true;";
	echo "</script>";
	echo '<br><center><div id="imagecropper" style="position: relative; border: outset white 3px; background-color: black; overflow: auto; vertical-align: middle; text-align: center; width: '.$imgwidth.'px; height: '.$imgheight.'px; ">';
	echo "<img id=\"theimage\" src=\"".$controller->record->getHtmlUrlDirect()."\" style=\"position: absolute; left: 1px; top: 1px; cursor: move;\" onmousedown=\"panimage(); return false;\" alt=\"\">";
	echo '</div></center>';
}
echo "</form>";
echo "<div style=\"position: relative; \">";
echo "</div>";
echo '<button onclick="window.close();">', WT_I18N::translate('close'), '</button>';
