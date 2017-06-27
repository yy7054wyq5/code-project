## personalcode
date:2016.3.30

## base code：
* bootstrap-3.3.5.css
* jQuery-1.11.2.js
* js.cookie.js

## PHPframe
* laravel5.1

## note
foo is callback

## method
* toNum(22.3186317637) &rArr; 22.31
* captcha(mobile) &rArr; tips
* browserVersion(foo) → foo(bversion)
* ellipsis(txt,$obj)
* loadPage(currentpage,totalpage) 
* alertTips
    *  alertTips.btn(txt,url,btn,foo) → foo(url)
    *  alertTips.txt(txt)
* handleURL
* if url = https://github.com/yy7054wyq5/personalcode
    *  handleURL.set(key,value,url) &rArr; https://github.com/yy7054wyq5/personalcode?key=value
    *  handleURL.jump(key,value,url) &rArr; location.href = https://github.com/yy7054wyq5/personalcode?key=value
    *  handleURL.markValue(key) &rArr; value
    *  handleURL.getParam() &rArr; key=value

## md5.js
* function hex_md5(s){ return binl2hex(core_md5(str2binl(s), s.length * chrsz));}
* function b64_md5(s){ return binl2b64(core_md5(str2binl(s), s.length * chrsz));}
* function hex_hmac_md5(key, data) { return binl2hex(core_hmac_md5(key, data)); }
* function b64_hmac_md5(key, data) { return binl2b64(core_hmac_md5(key, data)); }
* function calcMD5(s){ return binl2hex(core_md5(str2binl(s), s.length * chrsz));}

## scrolltopcontrol.js
insert HTML