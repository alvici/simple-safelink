var base46={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(a){var b="",d,e,f,g,h,j,k,l=0;for(a=base46._utf8_encode(a);l<a.length;)d=a.charCodeAt(l++),e=a.charCodeAt(l++),f=a.charCodeAt(l++),g=d>>2,h=(3&d)<<4|e>>4,j=(15&e)<<2|f>>6,k=63&f,isNaN(e)?j=k=64:isNaN(f)&&(k=64),b=b+this._keyStr.charAt(g)+this._keyStr.charAt(h)+this._keyStr.charAt(j)+this._keyStr.charAt(k);return b},decode:function(a){var d,e,f,g,h,j,k,b="",l=0;for(a=a.replace(/[^A-Za-z0-9\+\/\=]/g,"");l<a.length;)g=this._keyStr.indexOf(a.charAt(l++)),h=this._keyStr.indexOf(a.charAt(l++)),j=this._keyStr.indexOf(a.charAt(l++)),k=this._keyStr.indexOf(a.charAt(l++)),d=g<<2|h>>4,e=(15&h)<<4|j>>2,f=(3&j)<<6|k,b+=String.fromCharCode(d),64!=j&&(b+=String.fromCharCode(e)),64!=k&&(b+=String.fromCharCode(f));return b=base46._utf8_decode(b),b},_utf8_encode:function(a){a=a.replace(/\r\n/g,"\n");for(var e,b="",d=0;d<a.length;d++)e=a.charCodeAt(d),128>e?b+=String.fromCharCode(e):127<e&&2048>e?(b+=String.fromCharCode(192|e>>6),b+=String.fromCharCode(128|63&e)):(b+=String.fromCharCode(224|e>>12),b+=String.fromCharCode(128|63&e>>6),b+=String.fromCharCode(128|63&e));return b},_utf8_decode:function(a){for(var b="",d=0,e=c1=c2=0;d<a.length;)e=a.charCodeAt(d),128>e?(b+=String.fromCharCode(e),d++):191<e&&224>e?(c2=a.charCodeAt(d+1),b+=String.fromCharCode((31&e)<<6|63&c2),d+=2):(c2=a.charCodeAt(d+1),c3=a.charCodeAt(d+2),b+=String.fromCharCode((15&e)<<12|(63&c2)<<6|63&c3),d+=3);return b}};
var _bh={encode:function(a){var d,b=0,c=a.length,e='';for(b;b<c;++b)d=a.charCodeAt(b).toString(16),e+=2>d.length?'0'+d:d;return e},decode:function(a){for(var b=[],d=0;d<a.length-1;d+=2)b.push(parseInt(a.substr(d,2),16));return String.fromCharCode.apply(String,b)}};
function arrayContains(a,b){return-1<b.indexOf(a)}function hostname(a){var b=a.match(/:\/\/(www[0-9]?\.)?(.[^/:]+)/i);if(null!=b&&2<b.length&&'string'==typeof b[2]&&0<b[2].length)return b[2]}
window.onload = function() {
	var anchors = document.getElementsByTagName("a");
	for (var i = 0; i < anchors.length; i++) {
		var link = decodeURIComponent(anchors[i].href);
		console.log(link);
		if(typeof exclude_domains !== 'undefined') {
			if (!arrayContains(hostname(link), exclude_domains)) {
				var enc = _bh.encode(link);
				anchors[i].setAttribute('target', '_blank');
			    anchors[i].href = location.protocol+"//"+apphost+"?go=" + enc;
			}
		} else if(typeof shorts !== 'undefined') {
			if (arrayContains(hostname(link), shorts)) {
				var enc = _bh.encode(link);
				anchors[i].setAttribute('target', '_blank');
			    anchors[i].href = location.protocol+"//"+apphost+"?go=" + enc;
			}
		}
	}
}