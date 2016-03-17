var exit_ready = false;
function load_slidepage() {
    if (exit_ready == false) {
        exit_ready = true;
        jQuery('#the_box').html('');
        jQuery('#the_box').animate({height: '0px'}, 500, function () {
            jQuery('#main_div').hide();
            jQuery('#main_back').hide();
        });
    }
}
setTimeout('griplock()', 1000);
function griplock() {
    if (jquery_loaded) {
        var exitsplashmessage = 'Click Stay on this Page';
        var exitsplashpage = 'https://motifiles.com/welcome/?pub=9230';
        jQuery(document).ready(function () {
            function addLoadEvent(func) {
                var oldonload = window.onload;
                if (typeof window.onload != 'function') {
                    window.onload = func;
                } else {
                    window.onload = function () {
                        if (oldonload) {
                            oldonload();
                        }
                        func();
                    }
                }
            }

            function addClickEvent(a, i, func) {
                if (typeof a[i].onclick != 'function') {
                    a[i].onclick = func;
                }
            }

            var the_html = '<div id="main_div" style="display:block; width:100%; height:100%; position:absolute; z-index:2;">';
            if (jQuery.browser != undefined) {
                if (jQuery.browser.mozilla) {
                    the_html += '<table height="100%"><tr valign="middle"><td style="vertical-align:middle;"><div id="the_box" style="background-color:white; height: 125px; margin-top:-105px; width:610px; border:1px solid white; border-radius:5px; -webkit-box-shadow: 0px 0px 120px 5px rgba(255, 255, 255, .75);-moz-box-shadow: 0px 0px 120px 5px rgba(255, 255, 255, .75); box-shadow: 0px 0px 120px 5px rgba(255, 255, 255, .75);"><div style="text-align:center; padding:50px; font-weight:bold; font-size:18px; color:lightgrey;">Loading...</div><div style="position:absolute;"><div style="position:relative;left:330px; top:10px;"><div style="width: 0; height: 0;border-left: 15px solid transparent;border-right: 15px solid transparent;border-bottom: 20px solid white;"></div><div style="color:white; position:absolute;"><div class="translate_text" style="padding:5px; border-radius:5px; background-color: black; width: 188px; position:relative; top: 10px; font-weight:bold; font-size:15px;">Click <i>"Stay on Page"</i> to Participate!</div></div></div></div></td></tr></table>';
                } else if (jQuery.browser.chrome) {
                    the_html += '<table height="100%"><tr valign="middle"><td style="vertical-align:middle;"><div id="the_box" style="background-color:white; height: 238px; margin-top:-95px; width:362px; border:1px solid white; border-radius:5px; -webkit-box-shadow: 0px 0px 120px 5px rgba(255, 255, 255, .75);-moz-box-shadow: 0px 0px 120px 5px rgba(255, 255, 255, .75); box-shadow: 0px 0px 120px 5px rgba(255, 255, 255, .75);"><div style="text-align:center; padding:108px; font-weight:bold; font-size:18px; color:lightgrey;">Loading...</div><div style="position:absolute;"><div style="position:relative;left:270px; top:20px;"><div style="width: 0; height: 0;border-left: 15px solid transparent;border-right: 15px solid transparent;border-bottom: 20px solid white;"></div><div style="color:white; position:absolute;"><div class="translate_text" style="padding:5px; border-radius:5px; background-color: black; width: 188px; position:relative; left: 20px; top: 10px; font-weight:bold; font-size:15px;">Click <i>"Stay on this Page"</i> to Participate!</div></div></div></div></td></tr></table>';
                } else if (jQuery.browser.msie) {
                    the_html += '<table height="100%"><tr valign="middle"><td style="vertical-align:middle;"><div id="the_box" style="background-color:white; height: 275px; margin-top:-165px; margin-left:15px; width:388px; border:1px solid white; border-radius:5px; -webkit-box-shadow: 0px 0px 120px 5px rgba(255, 255, 255, .75);-moz-box-shadow: 0px 0px 120px 5px rgba(255, 255, 255, .75); box-shadow: 0px 0px 120px 5px rgba(255, 255, 255, .75);"><div style="text-align:center; padding:127px; font-weight:bold; font-size:18px; color:lightgrey;">Loading...</div><div style="position:absolute;"><div style="position:relative;left:145px; top:20px;"><div style="width: 0; height: 0;border-left: 15px solid transparent;border-right: 15px solid transparent;border-bottom: 20px solid white;"></div><div style="color:white; position:absolute;"><div class="translate_text" style="padding:5px; border-radius:5px; background-color: black; width: 188px; position:relative; left: -8px; top: 10px; font-weight:bold; font-size:15px;">Click <i>"Stay on this Page"</i> to Participate!</div></div></div></div></td></tr></table>';
                } else if (jQuery.browser.safari && !jQuery.browser.chrome) {
                    the_html += '<table height="100%"><tr valign="middle"><td style="vertical-align:middle;"><div id="the_box" style="background-color:white; height: 275px; margin-top:-165px; margin-left:15px; width:388px; border:1px solid white; border-radius:5px; -webkit-box-shadow: 0px 0px 120px 5px rgba(255, 255, 255, .75);-moz-box-shadow: 0px 0px 120px 5px rgba(255, 255, 255, .75); box-shadow: 0px 0px 120px 5px rgba(255, 255, 255, .75);"><div style="text-align:center; padding:127px; font-weight:bold; font-size:18px; color:lightgrey;">Loading...</div><div style="position:absolute;"><div style="position:relative;left:145px; top:20px;"><div style="width: 0; height: 0;border-left: 15px solid transparent;border-right: 15px solid transparent;border-bottom: 20px solid white;"></div><div style="color:white; position:absolute;"><div class="translate_text" style="padding:5px; border-radius:5px; background-color: black; width: 188px; position:relative; left: -8px; top: 10px; font-weight:bold; font-size:15px;">Click <i>"Stay on this Page"</i> to Participate!</div></div></div></div></td></tr></table>';
                    exitsplashmessage = 'Click Stay on Page.';
                } else {
                    the_html += '<table height="100%"><tr valign="middle"><td style="vertical-align:middle;"><div id="the_box" style="background-color:white; height: 275px; margin-top:-165px; margin-left:15px; width:388px; border:1px solid white; border-radius:5px; -webkit-box-shadow: 0px 0px 120px 5px rgba(255, 255, 255, .75);-moz-box-shadow: 0px 0px 120px 5px rgba(255, 255, 255, .75); box-shadow: 0px 0px 120px 5px rgba(255, 255, 255, .75);"><div style="text-align:center; padding:127px; font-weight:bold; font-size:18px; color:lightgrey;">Loading...</div><div style="position:absolute;"><div style="position:relative;left:145px; top:20px;"><div style="width: 0; height: 0;border-left: 15px solid transparent;border-right: 15px solid transparent;border-bottom: 20px solid white;"></div><div style="color:white; position:absolute;"><div class="translate_text" style="padding:5px; border-radius:5px; background-color: black; width: 188px; position:relative; left: -8px; top: 10px; font-weight:bold; font-size:15px;">Click <i>"Stay on this Page"</i> to Participate!</div></div></div></div></td></tr></table>';
                    exitsplashmessage = 'Click Stay on Page.';
                }
            }
            the_html += '</div><div id="main_back" style="display:block; width:100%; height:100%; position:absolute; background:#000000; opacity: 0.5;"></div>';
            var theDiv = '<div onmouseover="load_slidepage();" id="ExitSplashDiv" style="display:block; width:100%; height:100%; position:absolute; margin-top:0px; margin-left:0px;" align="center">';
            theDiv = theDiv + the_html;
            theDiv = theDiv + '<iframe src="' + exitsplashpage + '" width="100%" height="100%" align="middle" frameborder="0"></iframe>';
            theDiv = theDiv + '</div>';
            theBody = document.body;
            if (!theBody) {
                theBody = document.getElementById("body");
                if (!theBody) {
                    theBody = document.getElementsByTagName("body")[0];
                }
            }
            var PreventExitSplash = false;

            function DisableExitSplash() {
                PreventExitSplash = true;
            }

            function EnableExitSplash() {
                PreventExitSplash = false;
            }

            function DisplayExitSplash() {
                if (bypass == false) {
                    if (PreventExitSplash == false) {
                        $("*[style]").attr("style", "");
                        window.scrollTo(0, 0);
                        PreventExitSplash = true;
                        divtag = document.createElement("div");
                        divtag.setAttribute("id", "ExitSplashMainOuterLayer");
                        divtag.style.position = "absolute";
                        divtag.style.width = "100%";
                        divtag.style.height = "100%";
                        divtag.style.zIndex = "99";
                        divtag.style.left = "0px";
                        divtag.style.top = "0px";
                        divtag.innerHTML = theDiv;
                        theBody.innerHTML = "";
                        theBody.topMargin = "0px";
                        theBody.rightMargin = "0px";
                        theBody.bottomMargin = "0px";
                        theBody.leftMargin = "0px";
                        theBody.style.overflow = "hidden";
                        theBody.appendChild(divtag);
                        return exitsplashmessage;
                    } else {
                        PreventExitSplash = false;
                    }
                }
            }

            var a = document.getElementsByTagName('A');
            for (var i = 0; i < a.length; i++) {
                if (a[i].target !== '_blank') {
                    addClickEvent(a, i, function () {
                        PreventExitSplash = true;
                    });
                } else {
                    addClickEvent(a, i, function () {
                        PreventExitSplash = false;
                    });
                }
            }
            disablelinksfunc = function () {
                var a = document.getElementsByTagName('A');
                for (var i = 0; i < a.length; i++) {
                    if (a[i].target !== '_blank') {
                        addClickEvent(a, i, function () {
                            PreventExitSplash = true;
                        });
                    } else {
                        addClickEvent(a, i, function () {
                            PreventExitSplash = false;
                        });
                    }
                }
            };
            addLoadEvent(disablelinksfunc);
            window.onbeforeunload = DisplayExitSplash;
        });
    } else {
        setTimeout('griplock()', 1000);
    }
}
var exit_ready = false;
function load_slidepage() {
    if (exit_ready == false) {
        exit_ready = true;
        jQuery('#the_box').html('');
        jQuery('#the_box').animate({height: '0px'}, 500, function () {
            jQuery('#main_div').hide();
            jQuery('#main_back').hide();
        });
    }
}