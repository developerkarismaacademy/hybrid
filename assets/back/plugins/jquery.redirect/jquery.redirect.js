!function(t){"use strict";var r={url:null,values:null,method:"POST",target:null,traditional:!1,redirectTop:!1};t.redirect=function(e,a,n,o,i,l){var u=e;if("object"!=typeof e)u={url:e,values:a,method:n,target:o,traditional:i,redirectTop:l};var d=t.extend({},r,u),p=t.redirect.getForm(d.url,d.values,d.method,d.target,d.traditional);t("body",d.redirectTop?window.top.document:void 0).append(p.form),p.submit(),p.form.remove()},t.redirect.getForm=function(r,n,o,i,l){o=o&&-1!==["GET","POST","PUT","DELETE"].indexOf(o.toUpperCase())?o.toUpperCase():"POST";var u=(r=r.split("#"))[1]?"#"+r[1]:"";if(r=r[0],!n){var d=t.parseUrl(r);r=d.url,n=d.params}n=a(n);var p=t("<form>").attr("method",o).attr("action",r+u);i&&p.attr("target",i);var c=p[0].submit;return e(n,[],p,null,l),{form:p,submit:function(){c.call(p[0])}}},t.parseUrl=function(t){if(-1===t.indexOf("?"))return{url:t,params:{}};var r=t.split("?"),e=r[1].split("&");t=r[0];var a,n,o={};for(a=0;a<e.length;a+=1)o[(n=e[a].split("="))[0]]=n[1];return{url:t,params:o}};var e=function(r,a,n,o,i){var l=[];Object.keys(r).forEach(function(u){"object"==typeof r[u]?((l=a.slice()).push(u),e(r[u],l,n,Array.isArray(r[u]),i)):n.append(function(r,e,a,n,o){var i;if(a.length>0){var l;for(i=a[0],l=1;l<a.length;l+=1)i+="["+a[l]+"]";r=n&&o?i:i+"["+r+"]"}return t("<input>").attr("type","hidden").attr("name",r).attr("value",e)}(u,r[u],a,o,i))})},a=function(t){for(var r=Object.getOwnPropertyNames(t),e=0;e<r.length;e++){var n=r[e];null===t[n]||void 0===t[n]?delete t[n]:"object"==typeof t[n]?t[n]=a(t[n]):t[n].length<1&&delete t[n]}return t}}(window.jQuery||window.Zepto||window.jqlite);