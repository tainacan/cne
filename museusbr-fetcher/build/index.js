(()=>{"use strict";var e={n:t=>{var n=t&&t.__esModule?()=>t.default:()=>t;return e.d(n,{a:n}),n},d:(t,n)=>{for(var r in n)e.o(n,r)&&!e.o(t,r)&&Object.defineProperty(t,r,{enumerable:!0,get:n[r]})},o:(e,t)=>Object.prototype.hasOwnProperty.call(e,t),r:e=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})}},t={};e.r(t),e.d(t,{hasBrowserEnv:()=>me,hasStandardBrowserEnv:()=>ye,hasStandardBrowserWebWorkerEnv:()=>ge,origin:()=>we});const n=window.wp.domReady;var r=e.n(n);const o=window.wp.element,s=window.wp.components,i=window.wp.i18n,a=window.ReactJSXRuntime;function c({item:e}){const{label:t,author:n,thumbnail:r,description:o}=e;return(0,a.jsxs)(s.Flex,{gap:3,children:[(0,a.jsx)(s.FlexItem,{children:r?(0,a.jsx)("img",{src:r,alt:t,width:"68px",height:"68px"}):(0,a.jsx)(s.Icon,{icon:"bank",size:"68"})}),(0,a.jsxs)(s.FlexBlock,{children:[(0,a.jsx)("strong",{children:t||(0,a.jsx)("em",{children:(0,i.__)("Museu sem título","cne")})}),n?(0,a.jsxs)(a.Fragment,{children:[(0,a.jsx)("br",{}),(0,a.jsxs)("small",{children:[(0,i.__)("por","cne")," ",(0,a.jsx)("em",{children:n})]})]}):null,o?(0,a.jsxs)(a.Fragment,{children:[(0,a.jsx)("br",{}),(0,a.jsx)("small",{children:(0,a.jsx)(s.__experimentalTruncate,{numberOfLines:2,children:o})})]}):null]})]})}const u=({museus:e,setMuseus:t,fetchMuseus:n,museuSelecionado:r,setMuseuSelecionado:o})=>(0,a.jsx)(a.Fragment,{children:(0,a.jsx)(s.ComboboxControl,{__next40pxDefaultSize:!0,__experimentalRenderItem:({item:e})=>(0,a.jsx)(c,{item:e}),label:(0,i.__)("Pesquise um museu","cne"),options:e,onFilterValueChange:e=>n(e),value:r?r.label:"",expandOnFocus:!1,onChange:n=>{o(e.find((e=>e.value===n))),t([])}})}),l=({onClick:e,isCreatingInstituicao:t})=>(0,a.jsx)(s.Button,{variant:"primary",__next40pxDefaultSize:!0,onClick:e,__next40pxDefaultSize:!0,disabled:t,children:t?(0,a.jsx)(s.Spinner,{}):(0,i.__)("Criar instituição","cne")});function d(e,t){return function(){return e.apply(t,arguments)}}const{toString:f}=Object.prototype,{getPrototypeOf:p}=Object,h=(m=Object.create(null),e=>{const t=f.call(e);return m[t]||(m[t]=t.slice(8,-1).toLowerCase())});var m;const y=e=>(e=e.toLowerCase(),t=>h(t)===e),b=e=>t=>typeof t===e,{isArray:g}=Array,w=b("undefined"),E=y("ArrayBuffer"),S=b("string"),R=b("function"),O=b("number"),x=e=>null!==e&&"object"==typeof e,T=e=>{if("object"!==h(e))return!1;const t=p(e);return!(null!==t&&t!==Object.prototype&&null!==Object.getPrototypeOf(t)||Symbol.toStringTag in e||Symbol.iterator in e)},j=y("Date"),v=y("File"),A=y("Blob"),C=y("FileList"),F=y("URLSearchParams"),[N,P,B,L]=["ReadableStream","Request","Response","Headers"].map(y);function U(e,t,{allOwnKeys:n=!1}={}){if(null==e)return;let r,o;if("object"!=typeof e&&(e=[e]),g(e))for(r=0,o=e.length;r<o;r++)t.call(null,e[r],r,e);else{const o=n?Object.getOwnPropertyNames(e):Object.keys(e),s=o.length;let i;for(r=0;r<s;r++)i=o[r],t.call(null,e[i],i,e)}}function D(e,t){t=t.toLowerCase();const n=Object.keys(e);let r,o=n.length;for(;o-- >0;)if(r=n[o],t===r.toLowerCase())return r;return null}const k="undefined"!=typeof globalThis?globalThis:"undefined"!=typeof self?self:"undefined"!=typeof window?window:global,M=e=>!w(e)&&e!==k,I=(q="undefined"!=typeof Uint8Array&&p(Uint8Array),e=>q&&e instanceof q);var q;const z=y("HTMLFormElement"),H=(({hasOwnProperty:e})=>(t,n)=>e.call(t,n))(Object.prototype),J=y("RegExp"),V=(e,t)=>{const n=Object.getOwnPropertyDescriptors(e),r={};U(n,((n,o)=>{let s;!1!==(s=t(n,o,e))&&(r[o]=s||n)})),Object.defineProperties(e,r)},W="abcdefghijklmnopqrstuvwxyz",K="0123456789",$={DIGIT:K,ALPHA:W,ALPHA_DIGIT:W+W.toUpperCase()+K},G=y("AsyncFunction"),X={isArray:g,isArrayBuffer:E,isBuffer:function(e){return null!==e&&!w(e)&&null!==e.constructor&&!w(e.constructor)&&R(e.constructor.isBuffer)&&e.constructor.isBuffer(e)},isFormData:e=>{let t;return e&&("function"==typeof FormData&&e instanceof FormData||R(e.append)&&("formdata"===(t=h(e))||"object"===t&&R(e.toString)&&"[object FormData]"===e.toString()))},isArrayBufferView:function(e){let t;return t="undefined"!=typeof ArrayBuffer&&ArrayBuffer.isView?ArrayBuffer.isView(e):e&&e.buffer&&E(e.buffer),t},isString:S,isNumber:O,isBoolean:e=>!0===e||!1===e,isObject:x,isPlainObject:T,isReadableStream:N,isRequest:P,isResponse:B,isHeaders:L,isUndefined:w,isDate:j,isFile:v,isBlob:A,isRegExp:J,isFunction:R,isStream:e=>x(e)&&R(e.pipe),isURLSearchParams:F,isTypedArray:I,isFileList:C,forEach:U,merge:function e(){const{caseless:t}=M(this)&&this||{},n={},r=(r,o)=>{const s=t&&D(n,o)||o;T(n[s])&&T(r)?n[s]=e(n[s],r):T(r)?n[s]=e({},r):g(r)?n[s]=r.slice():n[s]=r};for(let e=0,t=arguments.length;e<t;e++)arguments[e]&&U(arguments[e],r);return n},extend:(e,t,n,{allOwnKeys:r}={})=>(U(t,((t,r)=>{n&&R(t)?e[r]=d(t,n):e[r]=t}),{allOwnKeys:r}),e),trim:e=>e.trim?e.trim():e.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,""),stripBOM:e=>(65279===e.charCodeAt(0)&&(e=e.slice(1)),e),inherits:(e,t,n,r)=>{e.prototype=Object.create(t.prototype,r),e.prototype.constructor=e,Object.defineProperty(e,"super",{value:t.prototype}),n&&Object.assign(e.prototype,n)},toFlatObject:(e,t,n,r)=>{let o,s,i;const a={};if(t=t||{},null==e)return t;do{for(o=Object.getOwnPropertyNames(e),s=o.length;s-- >0;)i=o[s],r&&!r(i,e,t)||a[i]||(t[i]=e[i],a[i]=!0);e=!1!==n&&p(e)}while(e&&(!n||n(e,t))&&e!==Object.prototype);return t},kindOf:h,kindOfTest:y,endsWith:(e,t,n)=>{e=String(e),(void 0===n||n>e.length)&&(n=e.length),n-=t.length;const r=e.indexOf(t,n);return-1!==r&&r===n},toArray:e=>{if(!e)return null;if(g(e))return e;let t=e.length;if(!O(t))return null;const n=new Array(t);for(;t-- >0;)n[t]=e[t];return n},forEachEntry:(e,t)=>{const n=(e&&e[Symbol.iterator]).call(e);let r;for(;(r=n.next())&&!r.done;){const n=r.value;t.call(e,n[0],n[1])}},matchAll:(e,t)=>{let n;const r=[];for(;null!==(n=e.exec(t));)r.push(n);return r},isHTMLForm:z,hasOwnProperty:H,hasOwnProp:H,reduceDescriptors:V,freezeMethods:e=>{V(e,((t,n)=>{if(R(e)&&-1!==["arguments","caller","callee"].indexOf(n))return!1;const r=e[n];R(r)&&(t.enumerable=!1,"writable"in t?t.writable=!1:t.set||(t.set=()=>{throw Error("Can not rewrite read-only method '"+n+"'")}))}))},toObjectSet:(e,t)=>{const n={},r=e=>{e.forEach((e=>{n[e]=!0}))};return g(e)?r(e):r(String(e).split(t)),n},toCamelCase:e=>e.toLowerCase().replace(/[-_\s]([a-z\d])(\w*)/g,(function(e,t,n){return t.toUpperCase()+n})),noop:()=>{},toFiniteNumber:(e,t)=>null!=e&&Number.isFinite(e=+e)?e:t,findKey:D,global:k,isContextDefined:M,ALPHABET:$,generateString:(e=16,t=$.ALPHA_DIGIT)=>{let n="";const{length:r}=t;for(;e--;)n+=t[Math.random()*r|0];return n},isSpecCompliantForm:function(e){return!!(e&&R(e.append)&&"FormData"===e[Symbol.toStringTag]&&e[Symbol.iterator])},toJSONObject:e=>{const t=new Array(10),n=(e,r)=>{if(x(e)){if(t.indexOf(e)>=0)return;if(!("toJSON"in e)){t[r]=e;const o=g(e)?[]:{};return U(e,((e,t)=>{const s=n(e,r+1);!w(s)&&(o[t]=s)})),t[r]=void 0,o}}return e};return n(e,0)},isAsyncFn:G,isThenable:e=>e&&(x(e)||R(e))&&R(e.then)&&R(e.catch)};function Q(e,t,n,r,o){Error.call(this),Error.captureStackTrace?Error.captureStackTrace(this,this.constructor):this.stack=(new Error).stack,this.message=e,this.name="AxiosError",t&&(this.code=t),n&&(this.config=n),r&&(this.request=r),o&&(this.response=o)}X.inherits(Q,Error,{toJSON:function(){return{message:this.message,name:this.name,description:this.description,number:this.number,fileName:this.fileName,lineNumber:this.lineNumber,columnNumber:this.columnNumber,stack:this.stack,config:X.toJSONObject(this.config),code:this.code,status:this.response&&this.response.status?this.response.status:null}}});const Z=Q.prototype,Y={};["ERR_BAD_OPTION_VALUE","ERR_BAD_OPTION","ECONNABORTED","ETIMEDOUT","ERR_NETWORK","ERR_FR_TOO_MANY_REDIRECTS","ERR_DEPRECATED","ERR_BAD_RESPONSE","ERR_BAD_REQUEST","ERR_CANCELED","ERR_NOT_SUPPORT","ERR_INVALID_URL"].forEach((e=>{Y[e]={value:e}})),Object.defineProperties(Q,Y),Object.defineProperty(Z,"isAxiosError",{value:!0}),Q.from=(e,t,n,r,o,s)=>{const i=Object.create(Z);return X.toFlatObject(e,i,(function(e){return e!==Error.prototype}),(e=>"isAxiosError"!==e)),Q.call(i,e.message,t,n,r,o),i.cause=e,i.name=e.name,s&&Object.assign(i,s),i};const ee=Q;function te(e){return X.isPlainObject(e)||X.isArray(e)}function ne(e){return X.endsWith(e,"[]")?e.slice(0,-2):e}function re(e,t,n){return e?e.concat(t).map((function(e,t){return e=ne(e),!n&&t?"["+e+"]":e})).join(n?".":""):t}const oe=X.toFlatObject(X,{},null,(function(e){return/^is[A-Z]/.test(e)})),se=function(e,t,n){if(!X.isObject(e))throw new TypeError("target must be an object");t=t||new FormData;const r=(n=X.toFlatObject(n,{metaTokens:!0,dots:!1,indexes:!1},!1,(function(e,t){return!X.isUndefined(t[e])}))).metaTokens,o=n.visitor||u,s=n.dots,i=n.indexes,a=(n.Blob||"undefined"!=typeof Blob&&Blob)&&X.isSpecCompliantForm(t);if(!X.isFunction(o))throw new TypeError("visitor must be a function");function c(e){if(null===e)return"";if(X.isDate(e))return e.toISOString();if(!a&&X.isBlob(e))throw new ee("Blob is not supported. Use a Buffer instead.");return X.isArrayBuffer(e)||X.isTypedArray(e)?a&&"function"==typeof Blob?new Blob([e]):Buffer.from(e):e}function u(e,n,o){let a=e;if(e&&!o&&"object"==typeof e)if(X.endsWith(n,"{}"))n=r?n:n.slice(0,-2),e=JSON.stringify(e);else if(X.isArray(e)&&function(e){return X.isArray(e)&&!e.some(te)}(e)||(X.isFileList(e)||X.endsWith(n,"[]"))&&(a=X.toArray(e)))return n=ne(n),a.forEach((function(e,r){!X.isUndefined(e)&&null!==e&&t.append(!0===i?re([n],r,s):null===i?n:n+"[]",c(e))})),!1;return!!te(e)||(t.append(re(o,n,s),c(e)),!1)}const l=[],d=Object.assign(oe,{defaultVisitor:u,convertValue:c,isVisitable:te});if(!X.isObject(e))throw new TypeError("data must be an object");return function e(n,r){if(!X.isUndefined(n)){if(-1!==l.indexOf(n))throw Error("Circular reference detected in "+r.join("."));l.push(n),X.forEach(n,(function(n,s){!0===(!(X.isUndefined(n)||null===n)&&o.call(t,n,X.isString(s)?s.trim():s,r,d))&&e(n,r?r.concat(s):[s])})),l.pop()}}(e),t};function ie(e){const t={"!":"%21","'":"%27","(":"%28",")":"%29","~":"%7E","%20":"+","%00":"\0"};return encodeURIComponent(e).replace(/[!'()~]|%20|%00/g,(function(e){return t[e]}))}function ae(e,t){this._pairs=[],e&&se(e,this,t)}const ce=ae.prototype;ce.append=function(e,t){this._pairs.push([e,t])},ce.toString=function(e){const t=e?function(t){return e.call(this,t,ie)}:ie;return this._pairs.map((function(e){return t(e[0])+"="+t(e[1])}),"").join("&")};const ue=ae;function le(e){return encodeURIComponent(e).replace(/%3A/gi,":").replace(/%24/g,"$").replace(/%2C/gi,",").replace(/%20/g,"+").replace(/%5B/gi,"[").replace(/%5D/gi,"]")}function de(e,t,n){if(!t)return e;const r=n&&n.encode||le,o=n&&n.serialize;let s;if(s=o?o(t,n):X.isURLSearchParams(t)?t.toString():new ue(t,n).toString(r),s){const t=e.indexOf("#");-1!==t&&(e=e.slice(0,t)),e+=(-1===e.indexOf("?")?"?":"&")+s}return e}const fe=class{constructor(){this.handlers=[]}use(e,t,n){return this.handlers.push({fulfilled:e,rejected:t,synchronous:!!n&&n.synchronous,runWhen:n?n.runWhen:null}),this.handlers.length-1}eject(e){this.handlers[e]&&(this.handlers[e]=null)}clear(){this.handlers&&(this.handlers=[])}forEach(e){X.forEach(this.handlers,(function(t){null!==t&&e(t)}))}},pe={silentJSONParsing:!0,forcedJSONParsing:!0,clarifyTimeoutError:!1},he={isBrowser:!0,classes:{URLSearchParams:"undefined"!=typeof URLSearchParams?URLSearchParams:ue,FormData:"undefined"!=typeof FormData?FormData:null,Blob:"undefined"!=typeof Blob?Blob:null},protocols:["http","https","file","blob","url","data"]},me="undefined"!=typeof window&&"undefined"!=typeof document,ye=(be="undefined"!=typeof navigator&&navigator.product,me&&["ReactNative","NativeScript","NS"].indexOf(be)<0);var be;const ge="undefined"!=typeof WorkerGlobalScope&&self instanceof WorkerGlobalScope&&"function"==typeof self.importScripts,we=me&&window.location.href||"http://localhost",Ee={...t,...he},Se=function(e){function t(e,n,r,o){let s=e[o++];if("__proto__"===s)return!0;const i=Number.isFinite(+s),a=o>=e.length;return s=!s&&X.isArray(r)?r.length:s,a?(X.hasOwnProp(r,s)?r[s]=[r[s],n]:r[s]=n,!i):(r[s]&&X.isObject(r[s])||(r[s]=[]),t(e,n,r[s],o)&&X.isArray(r[s])&&(r[s]=function(e){const t={},n=Object.keys(e);let r;const o=n.length;let s;for(r=0;r<o;r++)s=n[r],t[s]=e[s];return t}(r[s])),!i)}if(X.isFormData(e)&&X.isFunction(e.entries)){const n={};return X.forEachEntry(e,((e,r)=>{t(function(e){return X.matchAll(/\w+|\[(\w*)]/g,e).map((e=>"[]"===e[0]?"":e[1]||e[0]))}(e),r,n,0)})),n}return null},Re={transitional:pe,adapter:["xhr","http","fetch"],transformRequest:[function(e,t){const n=t.getContentType()||"",r=n.indexOf("application/json")>-1,o=X.isObject(e);if(o&&X.isHTMLForm(e)&&(e=new FormData(e)),X.isFormData(e))return r?JSON.stringify(Se(e)):e;if(X.isArrayBuffer(e)||X.isBuffer(e)||X.isStream(e)||X.isFile(e)||X.isBlob(e)||X.isReadableStream(e))return e;if(X.isArrayBufferView(e))return e.buffer;if(X.isURLSearchParams(e))return t.setContentType("application/x-www-form-urlencoded;charset=utf-8",!1),e.toString();let s;if(o){if(n.indexOf("application/x-www-form-urlencoded")>-1)return function(e,t){return se(e,new Ee.classes.URLSearchParams,Object.assign({visitor:function(e,t,n,r){return Ee.isNode&&X.isBuffer(e)?(this.append(t,e.toString("base64")),!1):r.defaultVisitor.apply(this,arguments)}},t))}(e,this.formSerializer).toString();if((s=X.isFileList(e))||n.indexOf("multipart/form-data")>-1){const t=this.env&&this.env.FormData;return se(s?{"files[]":e}:e,t&&new t,this.formSerializer)}}return o||r?(t.setContentType("application/json",!1),function(e,t,n){if(X.isString(e))try{return(0,JSON.parse)(e),X.trim(e)}catch(e){if("SyntaxError"!==e.name)throw e}return(0,JSON.stringify)(e)}(e)):e}],transformResponse:[function(e){const t=this.transitional||Re.transitional,n=t&&t.forcedJSONParsing,r="json"===this.responseType;if(X.isResponse(e)||X.isReadableStream(e))return e;if(e&&X.isString(e)&&(n&&!this.responseType||r)){const n=!(t&&t.silentJSONParsing)&&r;try{return JSON.parse(e)}catch(e){if(n){if("SyntaxError"===e.name)throw ee.from(e,ee.ERR_BAD_RESPONSE,this,null,this.response);throw e}}}return e}],timeout:0,xsrfCookieName:"XSRF-TOKEN",xsrfHeaderName:"X-XSRF-TOKEN",maxContentLength:-1,maxBodyLength:-1,env:{FormData:Ee.classes.FormData,Blob:Ee.classes.Blob},validateStatus:function(e){return e>=200&&e<300},headers:{common:{Accept:"application/json, text/plain, */*","Content-Type":void 0}}};X.forEach(["delete","get","head","post","put","patch"],(e=>{Re.headers[e]={}}));const Oe=Re,xe=X.toObjectSet(["age","authorization","content-length","content-type","etag","expires","from","host","if-modified-since","if-unmodified-since","last-modified","location","max-forwards","proxy-authorization","referer","retry-after","user-agent"]),Te=Symbol("internals");function je(e){return e&&String(e).trim().toLowerCase()}function _e(e){return!1===e||null==e?e:X.isArray(e)?e.map(_e):String(e)}function ve(e,t,n,r,o){return X.isFunction(r)?r.call(this,t,n):(o&&(t=n),X.isString(t)?X.isString(r)?-1!==t.indexOf(r):X.isRegExp(r)?r.test(t):void 0:void 0)}class Ae{constructor(e){e&&this.set(e)}set(e,t,n){const r=this;function o(e,t,n){const o=je(t);if(!o)throw new Error("header name must be a non-empty string");const s=X.findKey(r,o);(!s||void 0===r[s]||!0===n||void 0===n&&!1!==r[s])&&(r[s||t]=_e(e))}const s=(e,t)=>X.forEach(e,((e,n)=>o(e,n,t)));if(X.isPlainObject(e)||e instanceof this.constructor)s(e,t);else if(X.isString(e)&&(e=e.trim())&&!/^[-_a-zA-Z0-9^`|~,!#$%&'*+.]+$/.test(e.trim()))s((e=>{const t={};let n,r,o;return e&&e.split("\n").forEach((function(e){o=e.indexOf(":"),n=e.substring(0,o).trim().toLowerCase(),r=e.substring(o+1).trim(),!n||t[n]&&xe[n]||("set-cookie"===n?t[n]?t[n].push(r):t[n]=[r]:t[n]=t[n]?t[n]+", "+r:r)})),t})(e),t);else if(X.isHeaders(e))for(const[t,r]of e.entries())o(r,t,n);else null!=e&&o(t,e,n);return this}get(e,t){if(e=je(e)){const n=X.findKey(this,e);if(n){const e=this[n];if(!t)return e;if(!0===t)return function(e){const t=Object.create(null),n=/([^\s,;=]+)\s*(?:=\s*([^,;]+))?/g;let r;for(;r=n.exec(e);)t[r[1]]=r[2];return t}(e);if(X.isFunction(t))return t.call(this,e,n);if(X.isRegExp(t))return t.exec(e);throw new TypeError("parser must be boolean|regexp|function")}}}has(e,t){if(e=je(e)){const n=X.findKey(this,e);return!(!n||void 0===this[n]||t&&!ve(0,this[n],n,t))}return!1}delete(e,t){const n=this;let r=!1;function o(e){if(e=je(e)){const o=X.findKey(n,e);!o||t&&!ve(0,n[o],o,t)||(delete n[o],r=!0)}}return X.isArray(e)?e.forEach(o):o(e),r}clear(e){const t=Object.keys(this);let n=t.length,r=!1;for(;n--;){const o=t[n];e&&!ve(0,this[o],o,e,!0)||(delete this[o],r=!0)}return r}normalize(e){const t=this,n={};return X.forEach(this,((r,o)=>{const s=X.findKey(n,o);if(s)return t[s]=_e(r),void delete t[o];const i=e?function(e){return e.trim().toLowerCase().replace(/([a-z\d])(\w*)/g,((e,t,n)=>t.toUpperCase()+n))}(o):String(o).trim();i!==o&&delete t[o],t[i]=_e(r),n[i]=!0})),this}concat(...e){return this.constructor.concat(this,...e)}toJSON(e){const t=Object.create(null);return X.forEach(this,((n,r)=>{null!=n&&!1!==n&&(t[r]=e&&X.isArray(n)?n.join(", "):n)})),t}[Symbol.iterator](){return Object.entries(this.toJSON())[Symbol.iterator]()}toString(){return Object.entries(this.toJSON()).map((([e,t])=>e+": "+t)).join("\n")}get[Symbol.toStringTag](){return"AxiosHeaders"}static from(e){return e instanceof this?e:new this(e)}static concat(e,...t){const n=new this(e);return t.forEach((e=>n.set(e))),n}static accessor(e){const t=(this[Te]=this[Te]={accessors:{}}).accessors,n=this.prototype;function r(e){const r=je(e);t[r]||(function(e,t){const n=X.toCamelCase(" "+t);["get","set","has"].forEach((r=>{Object.defineProperty(e,r+n,{value:function(e,n,o){return this[r].call(this,t,e,n,o)},configurable:!0})}))}(n,e),t[r]=!0)}return X.isArray(e)?e.forEach(r):r(e),this}}Ae.accessor(["Content-Type","Content-Length","Accept","Accept-Encoding","User-Agent","Authorization"]),X.reduceDescriptors(Ae.prototype,(({value:e},t)=>{let n=t[0].toUpperCase()+t.slice(1);return{get:()=>e,set(e){this[n]=e}}})),X.freezeMethods(Ae);const Ce=Ae;function Fe(e,t){const n=this||Oe,r=t||n,o=Ce.from(r.headers);let s=r.data;return X.forEach(e,(function(e){s=e.call(n,s,o.normalize(),t?t.status:void 0)})),o.normalize(),s}function Ne(e){return!(!e||!e.__CANCEL__)}function Pe(e,t,n){ee.call(this,null==e?"canceled":e,ee.ERR_CANCELED,t,n),this.name="CanceledError"}X.inherits(Pe,ee,{__CANCEL__:!0});const Be=Pe;function Le(e,t,n){const r=n.config.validateStatus;n.status&&r&&!r(n.status)?t(new ee("Request failed with status code "+n.status,[ee.ERR_BAD_REQUEST,ee.ERR_BAD_RESPONSE][Math.floor(n.status/100)-4],n.config,n.request,n)):e(n)}const Ue=(e,t,n=3)=>{let r=0;const o=function(e,t){e=e||10;const n=new Array(e),r=new Array(e);let o,s=0,i=0;return t=void 0!==t?t:1e3,function(a){const c=Date.now(),u=r[i];o||(o=c),n[s]=a,r[s]=c;let l=i,d=0;for(;l!==s;)d+=n[l++],l%=e;if(s=(s+1)%e,s===i&&(i=(i+1)%e),c-o<t)return;const f=u&&c-u;return f?Math.round(1e3*d/f):void 0}}(50,250);return function(e,t){let n=0;const r=1e3/t;let o=null;return function(){const t=!0===this,s=Date.now();if(t||s-n>r)return o&&(clearTimeout(o),o=null),n=s,e.apply(null,arguments);o||(o=setTimeout((()=>(o=null,n=Date.now(),e.apply(null,arguments))),r-(s-n)))}}((n=>{const s=n.loaded,i=n.lengthComputable?n.total:void 0,a=s-r,c=o(a);r=s;const u={loaded:s,total:i,progress:i?s/i:void 0,bytes:a,rate:c||void 0,estimated:c&&i&&s<=i?(i-s)/c:void 0,event:n,lengthComputable:null!=i};u[t?"download":"upload"]=!0,e(u)}),n)},De=Ee.hasStandardBrowserEnv?function(){const e=/(msie|trident)/i.test(navigator.userAgent),t=document.createElement("a");let n;function r(n){let r=n;return e&&(t.setAttribute("href",r),r=t.href),t.setAttribute("href",r),{href:t.href,protocol:t.protocol?t.protocol.replace(/:$/,""):"",host:t.host,search:t.search?t.search.replace(/^\?/,""):"",hash:t.hash?t.hash.replace(/^#/,""):"",hostname:t.hostname,port:t.port,pathname:"/"===t.pathname.charAt(0)?t.pathname:"/"+t.pathname}}return n=r(window.location.href),function(e){const t=X.isString(e)?r(e):e;return t.protocol===n.protocol&&t.host===n.host}}():function(){return!0},ke=Ee.hasStandardBrowserEnv?{write(e,t,n,r,o,s){const i=[e+"="+encodeURIComponent(t)];X.isNumber(n)&&i.push("expires="+new Date(n).toGMTString()),X.isString(r)&&i.push("path="+r),X.isString(o)&&i.push("domain="+o),!0===s&&i.push("secure"),document.cookie=i.join("; ")},read(e){const t=document.cookie.match(new RegExp("(^|;\\s*)("+e+")=([^;]*)"));return t?decodeURIComponent(t[3]):null},remove(e){this.write(e,"",Date.now()-864e5)}}:{write(){},read:()=>null,remove(){}};function Me(e,t){return e&&!/^([a-z][a-z\d+\-.]*:)?\/\//i.test(t)?function(e,t){return t?e.replace(/\/?\/$/,"")+"/"+t.replace(/^\/+/,""):e}(e,t):t}const Ie=e=>e instanceof Ce?{...e}:e;function qe(e,t){t=t||{};const n={};function r(e,t,n){return X.isPlainObject(e)&&X.isPlainObject(t)?X.merge.call({caseless:n},e,t):X.isPlainObject(t)?X.merge({},t):X.isArray(t)?t.slice():t}function o(e,t,n){return X.isUndefined(t)?X.isUndefined(e)?void 0:r(void 0,e,n):r(e,t,n)}function s(e,t){if(!X.isUndefined(t))return r(void 0,t)}function i(e,t){return X.isUndefined(t)?X.isUndefined(e)?void 0:r(void 0,e):r(void 0,t)}function a(n,o,s){return s in t?r(n,o):s in e?r(void 0,n):void 0}const c={url:s,method:s,data:s,baseURL:i,transformRequest:i,transformResponse:i,paramsSerializer:i,timeout:i,timeoutMessage:i,withCredentials:i,withXSRFToken:i,adapter:i,responseType:i,xsrfCookieName:i,xsrfHeaderName:i,onUploadProgress:i,onDownloadProgress:i,decompress:i,maxContentLength:i,maxBodyLength:i,beforeRedirect:i,transport:i,httpAgent:i,httpsAgent:i,cancelToken:i,socketPath:i,responseEncoding:i,validateStatus:a,headers:(e,t)=>o(Ie(e),Ie(t),!0)};return X.forEach(Object.keys(Object.assign({},e,t)),(function(r){const s=c[r]||o,i=s(e[r],t[r],r);X.isUndefined(i)&&s!==a||(n[r]=i)})),n}const ze=e=>{const t=qe({},e);let n,{data:r,withXSRFToken:o,xsrfHeaderName:s,xsrfCookieName:i,headers:a,auth:c}=t;if(t.headers=a=Ce.from(a),t.url=de(Me(t.baseURL,t.url),e.params,e.paramsSerializer),c&&a.set("Authorization","Basic "+btoa((c.username||"")+":"+(c.password?unescape(encodeURIComponent(c.password)):""))),X.isFormData(r))if(Ee.hasStandardBrowserEnv||Ee.hasStandardBrowserWebWorkerEnv)a.setContentType(void 0);else if(!1!==(n=a.getContentType())){const[e,...t]=n?n.split(";").map((e=>e.trim())).filter(Boolean):[];a.setContentType([e||"multipart/form-data",...t].join("; "))}if(Ee.hasStandardBrowserEnv&&(o&&X.isFunction(o)&&(o=o(t)),o||!1!==o&&De(t.url))){const e=s&&i&&ke.read(i);e&&a.set(s,e)}return t},He="undefined"!=typeof XMLHttpRequest&&function(e){return new Promise((function(t,n){const r=ze(e);let o=r.data;const s=Ce.from(r.headers).normalize();let i,{responseType:a}=r;function c(){r.cancelToken&&r.cancelToken.unsubscribe(i),r.signal&&r.signal.removeEventListener("abort",i)}let u=new XMLHttpRequest;function l(){if(!u)return;const r=Ce.from("getAllResponseHeaders"in u&&u.getAllResponseHeaders());Le((function(e){t(e),c()}),(function(e){n(e),c()}),{data:a&&"text"!==a&&"json"!==a?u.response:u.responseText,status:u.status,statusText:u.statusText,headers:r,config:e,request:u}),u=null}u.open(r.method.toUpperCase(),r.url,!0),u.timeout=r.timeout,"onloadend"in u?u.onloadend=l:u.onreadystatechange=function(){u&&4===u.readyState&&(0!==u.status||u.responseURL&&0===u.responseURL.indexOf("file:"))&&setTimeout(l)},u.onabort=function(){u&&(n(new ee("Request aborted",ee.ECONNABORTED,r,u)),u=null)},u.onerror=function(){n(new ee("Network Error",ee.ERR_NETWORK,r,u)),u=null},u.ontimeout=function(){let e=r.timeout?"timeout of "+r.timeout+"ms exceeded":"timeout exceeded";const t=r.transitional||pe;r.timeoutErrorMessage&&(e=r.timeoutErrorMessage),n(new ee(e,t.clarifyTimeoutError?ee.ETIMEDOUT:ee.ECONNABORTED,r,u)),u=null},void 0===o&&s.setContentType(null),"setRequestHeader"in u&&X.forEach(s.toJSON(),(function(e,t){u.setRequestHeader(t,e)})),X.isUndefined(r.withCredentials)||(u.withCredentials=!!r.withCredentials),a&&"json"!==a&&(u.responseType=r.responseType),"function"==typeof r.onDownloadProgress&&u.addEventListener("progress",Ue(r.onDownloadProgress,!0)),"function"==typeof r.onUploadProgress&&u.upload&&u.upload.addEventListener("progress",Ue(r.onUploadProgress)),(r.cancelToken||r.signal)&&(i=t=>{u&&(n(!t||t.type?new Be(null,e,u):t),u.abort(),u=null)},r.cancelToken&&r.cancelToken.subscribe(i),r.signal&&(r.signal.aborted?i():r.signal.addEventListener("abort",i)));const d=function(e){const t=/^([-+\w]{1,25})(:?\/\/|:)/.exec(e);return t&&t[1]||""}(r.url);d&&-1===Ee.protocols.indexOf(d)?n(new ee("Unsupported protocol "+d+":",ee.ERR_BAD_REQUEST,e)):u.send(o||null)}))},Je=(e,t)=>{let n,r=new AbortController;const o=function(e){if(!n){n=!0,i();const t=e instanceof Error?e:this.reason;r.abort(t instanceof ee?t:new Be(t instanceof Error?t.message:t))}};let s=t&&setTimeout((()=>{o(new ee(`timeout ${t} of ms exceeded`,ee.ETIMEDOUT))}),t);const i=()=>{e&&(s&&clearTimeout(s),s=null,e.forEach((e=>{e&&(e.removeEventListener?e.removeEventListener("abort",o):e.unsubscribe(o))})),e=null)};e.forEach((e=>e&&e.addEventListener&&e.addEventListener("abort",o)));const{signal:a}=r;return a.unsubscribe=i,[a,()=>{s&&clearTimeout(s),s=null}]},Ve=function*(e,t){let n=e.byteLength;if(!t||n<t)return void(yield e);let r,o=0;for(;o<n;)r=o+t,yield e.slice(o,r),o=r},We=(e,t,n,r,o)=>{const s=async function*(e,t,n){for await(const r of e)yield*Ve(ArrayBuffer.isView(r)?r:await n(String(r)),t)}(e,t,o);let i=0;return new ReadableStream({type:"bytes",async pull(e){const{done:t,value:o}=await s.next();if(t)return e.close(),void r();let a=o.byteLength;n&&n(i+=a),e.enqueue(new Uint8Array(o))},cancel:e=>(r(e),s.return())},{highWaterMark:2})},Ke=(e,t)=>{const n=null!=e;return r=>setTimeout((()=>t({lengthComputable:n,total:e,loaded:r})))},$e="function"==typeof fetch&&"function"==typeof Request&&"function"==typeof Response,Ge=$e&&"function"==typeof ReadableStream,Xe=$e&&("function"==typeof TextEncoder?(Qe=new TextEncoder,e=>Qe.encode(e)):async e=>new Uint8Array(await new Response(e).arrayBuffer()));var Qe;const Ze=Ge&&(()=>{let e=!1;const t=new Request(Ee.origin,{body:new ReadableStream,method:"POST",get duplex(){return e=!0,"half"}}).headers.has("Content-Type");return e&&!t})(),Ye=Ge&&!!(()=>{try{return X.isReadableStream(new Response("").body)}catch(e){}})(),et={stream:Ye&&(e=>e.body)};var tt;$e&&(tt=new Response,["text","arrayBuffer","blob","formData","stream"].forEach((e=>{!et[e]&&(et[e]=X.isFunction(tt[e])?t=>t[e]():(t,n)=>{throw new ee(`Response type '${e}' is not supported`,ee.ERR_NOT_SUPPORT,n)})})));const nt={http:null,xhr:He,fetch:$e&&(async e=>{let{url:t,method:n,data:r,signal:o,cancelToken:s,timeout:i,onDownloadProgress:a,onUploadProgress:c,responseType:u,headers:l,withCredentials:d="same-origin",fetchOptions:f}=ze(e);u=u?(u+"").toLowerCase():"text";let p,h,[m,y]=o||s||i?Je([o,s],i):[];const b=()=>{!p&&setTimeout((()=>{m&&m.unsubscribe()})),p=!0};let g;try{if(c&&Ze&&"get"!==n&&"head"!==n&&0!==(g=await(async(e,t)=>{const n=X.toFiniteNumber(e.getContentLength());return null==n?(async e=>null==e?0:X.isBlob(e)?e.size:X.isSpecCompliantForm(e)?(await new Request(e).arrayBuffer()).byteLength:X.isArrayBufferView(e)?e.byteLength:(X.isURLSearchParams(e)&&(e+=""),X.isString(e)?(await Xe(e)).byteLength:void 0))(t):n})(l,r))){let e,n=new Request(t,{method:"POST",body:r,duplex:"half"});X.isFormData(r)&&(e=n.headers.get("content-type"))&&l.setContentType(e),n.body&&(r=We(n.body,65536,Ke(g,Ue(c)),null,Xe))}X.isString(d)||(d=d?"cors":"omit"),h=new Request(t,{...f,signal:m,method:n.toUpperCase(),headers:l.normalize().toJSON(),body:r,duplex:"half",withCredentials:d});let o=await fetch(h);const s=Ye&&("stream"===u||"response"===u);if(Ye&&(a||s)){const e={};["status","statusText","headers"].forEach((t=>{e[t]=o[t]}));const t=X.toFiniteNumber(o.headers.get("content-length"));o=new Response(We(o.body,65536,a&&Ke(t,Ue(a,!0)),s&&b,Xe),e)}u=u||"text";let i=await et[X.findKey(et,u)||"text"](o,e);return!s&&b(),y&&y(),await new Promise(((t,n)=>{Le(t,n,{data:i,headers:Ce.from(o.headers),status:o.status,statusText:o.statusText,config:e,request:h})}))}catch(t){if(b(),t&&"TypeError"===t.name&&/fetch/i.test(t.message))throw Object.assign(new ee("Network Error",ee.ERR_NETWORK,e,h),{cause:t.cause||t});throw ee.from(t,t&&t.code,e,h)}})};X.forEach(nt,((e,t)=>{if(e){try{Object.defineProperty(e,"name",{value:t})}catch(e){}Object.defineProperty(e,"adapterName",{value:t})}}));const rt=e=>`- ${e}`,ot=e=>X.isFunction(e)||null===e||!1===e,st=e=>{e=X.isArray(e)?e:[e];const{length:t}=e;let n,r;const o={};for(let s=0;s<t;s++){let t;if(n=e[s],r=n,!ot(n)&&(r=nt[(t=String(n)).toLowerCase()],void 0===r))throw new ee(`Unknown adapter '${t}'`);if(r)break;o[t||"#"+s]=r}if(!r){const e=Object.entries(o).map((([e,t])=>`adapter ${e} `+(!1===t?"is not supported by the environment":"is not available in the build")));let n=t?e.length>1?"since :\n"+e.map(rt).join("\n"):" "+rt(e[0]):"as no adapter specified";throw new ee("There is no suitable adapter to dispatch the request "+n,"ERR_NOT_SUPPORT")}return r};function it(e){if(e.cancelToken&&e.cancelToken.throwIfRequested(),e.signal&&e.signal.aborted)throw new Be(null,e)}function at(e){return it(e),e.headers=Ce.from(e.headers),e.data=Fe.call(e,e.transformRequest),-1!==["post","put","patch"].indexOf(e.method)&&e.headers.setContentType("application/x-www-form-urlencoded",!1),st(e.adapter||Oe.adapter)(e).then((function(t){return it(e),t.data=Fe.call(e,e.transformResponse,t),t.headers=Ce.from(t.headers),t}),(function(t){return Ne(t)||(it(e),t&&t.response&&(t.response.data=Fe.call(e,e.transformResponse,t.response),t.response.headers=Ce.from(t.response.headers))),Promise.reject(t)}))}const ct={};["object","boolean","number","function","string","symbol"].forEach(((e,t)=>{ct[e]=function(n){return typeof n===e||"a"+(t<1?"n ":" ")+e}}));const ut={};ct.transitional=function(e,t,n){function r(e,t){return"[Axios v1.7.2] Transitional option '"+e+"'"+t+(n?". "+n:"")}return(n,o,s)=>{if(!1===e)throw new ee(r(o," has been removed"+(t?" in "+t:"")),ee.ERR_DEPRECATED);return t&&!ut[o]&&(ut[o]=!0,console.warn(r(o," has been deprecated since v"+t+" and will be removed in the near future"))),!e||e(n,o,s)}};const lt={assertOptions:function(e,t,n){if("object"!=typeof e)throw new ee("options must be an object",ee.ERR_BAD_OPTION_VALUE);const r=Object.keys(e);let o=r.length;for(;o-- >0;){const s=r[o],i=t[s];if(i){const t=e[s],n=void 0===t||i(t,s,e);if(!0!==n)throw new ee("option "+s+" must be "+n,ee.ERR_BAD_OPTION_VALUE)}else if(!0!==n)throw new ee("Unknown option "+s,ee.ERR_BAD_OPTION)}},validators:ct},dt=lt.validators;class ft{constructor(e){this.defaults=e,this.interceptors={request:new fe,response:new fe}}async request(e,t){try{return await this._request(e,t)}catch(e){if(e instanceof Error){let t;Error.captureStackTrace?Error.captureStackTrace(t={}):t=new Error;const n=t.stack?t.stack.replace(/^.+\n/,""):"";try{e.stack?n&&!String(e.stack).endsWith(n.replace(/^.+\n.+\n/,""))&&(e.stack+="\n"+n):e.stack=n}catch(e){}}throw e}}_request(e,t){"string"==typeof e?(t=t||{}).url=e:t=e||{},t=qe(this.defaults,t);const{transitional:n,paramsSerializer:r,headers:o}=t;void 0!==n&&lt.assertOptions(n,{silentJSONParsing:dt.transitional(dt.boolean),forcedJSONParsing:dt.transitional(dt.boolean),clarifyTimeoutError:dt.transitional(dt.boolean)},!1),null!=r&&(X.isFunction(r)?t.paramsSerializer={serialize:r}:lt.assertOptions(r,{encode:dt.function,serialize:dt.function},!0)),t.method=(t.method||this.defaults.method||"get").toLowerCase();let s=o&&X.merge(o.common,o[t.method]);o&&X.forEach(["delete","get","head","post","put","patch","common"],(e=>{delete o[e]})),t.headers=Ce.concat(s,o);const i=[];let a=!0;this.interceptors.request.forEach((function(e){"function"==typeof e.runWhen&&!1===e.runWhen(t)||(a=a&&e.synchronous,i.unshift(e.fulfilled,e.rejected))}));const c=[];let u;this.interceptors.response.forEach((function(e){c.push(e.fulfilled,e.rejected)}));let l,d=0;if(!a){const e=[at.bind(this),void 0];for(e.unshift.apply(e,i),e.push.apply(e,c),l=e.length,u=Promise.resolve(t);d<l;)u=u.then(e[d++],e[d++]);return u}l=i.length;let f=t;for(d=0;d<l;){const e=i[d++],t=i[d++];try{f=e(f)}catch(e){t.call(this,e);break}}try{u=at.call(this,f)}catch(e){return Promise.reject(e)}for(d=0,l=c.length;d<l;)u=u.then(c[d++],c[d++]);return u}getUri(e){return de(Me((e=qe(this.defaults,e)).baseURL,e.url),e.params,e.paramsSerializer)}}X.forEach(["delete","get","head","options"],(function(e){ft.prototype[e]=function(t,n){return this.request(qe(n||{},{method:e,url:t,data:(n||{}).data}))}})),X.forEach(["post","put","patch"],(function(e){function t(t){return function(n,r,o){return this.request(qe(o||{},{method:e,headers:t?{"Content-Type":"multipart/form-data"}:{},url:n,data:r}))}}ft.prototype[e]=t(),ft.prototype[e+"Form"]=t(!0)}));const pt=ft;class ht{constructor(e){if("function"!=typeof e)throw new TypeError("executor must be a function.");let t;this.promise=new Promise((function(e){t=e}));const n=this;this.promise.then((e=>{if(!n._listeners)return;let t=n._listeners.length;for(;t-- >0;)n._listeners[t](e);n._listeners=null})),this.promise.then=e=>{let t;const r=new Promise((e=>{n.subscribe(e),t=e})).then(e);return r.cancel=function(){n.unsubscribe(t)},r},e((function(e,r,o){n.reason||(n.reason=new Be(e,r,o),t(n.reason))}))}throwIfRequested(){if(this.reason)throw this.reason}subscribe(e){this.reason?e(this.reason):this._listeners?this._listeners.push(e):this._listeners=[e]}unsubscribe(e){if(!this._listeners)return;const t=this._listeners.indexOf(e);-1!==t&&this._listeners.splice(t,1)}static source(){let e;return{token:new ht((function(t){e=t})),cancel:e}}}const mt=ht,yt={Continue:100,SwitchingProtocols:101,Processing:102,EarlyHints:103,Ok:200,Created:201,Accepted:202,NonAuthoritativeInformation:203,NoContent:204,ResetContent:205,PartialContent:206,MultiStatus:207,AlreadyReported:208,ImUsed:226,MultipleChoices:300,MovedPermanently:301,Found:302,SeeOther:303,NotModified:304,UseProxy:305,Unused:306,TemporaryRedirect:307,PermanentRedirect:308,BadRequest:400,Unauthorized:401,PaymentRequired:402,Forbidden:403,NotFound:404,MethodNotAllowed:405,NotAcceptable:406,ProxyAuthenticationRequired:407,RequestTimeout:408,Conflict:409,Gone:410,LengthRequired:411,PreconditionFailed:412,PayloadTooLarge:413,UriTooLong:414,UnsupportedMediaType:415,RangeNotSatisfiable:416,ExpectationFailed:417,ImATeapot:418,MisdirectedRequest:421,UnprocessableEntity:422,Locked:423,FailedDependency:424,TooEarly:425,UpgradeRequired:426,PreconditionRequired:428,TooManyRequests:429,RequestHeaderFieldsTooLarge:431,UnavailableForLegalReasons:451,InternalServerError:500,NotImplemented:501,BadGateway:502,ServiceUnavailable:503,GatewayTimeout:504,HttpVersionNotSupported:505,VariantAlsoNegotiates:506,InsufficientStorage:507,LoopDetected:508,NotExtended:510,NetworkAuthenticationRequired:511};Object.entries(yt).forEach((([e,t])=>{yt[t]=e}));const bt=yt,gt=function e(t){const n=new pt(t),r=d(pt.prototype.request,n);return X.extend(r,pt.prototype,n,{allOwnKeys:!0}),X.extend(r,n,null,{allOwnKeys:!0}),r.create=function(n){return e(qe(t,n))},r}(Oe);gt.Axios=pt,gt.CanceledError=Be,gt.CancelToken=mt,gt.isCancel=Ne,gt.VERSION="1.7.2",gt.toFormData=se,gt.AxiosError=ee,gt.Cancel=gt.CanceledError,gt.all=function(e){return Promise.all(e)},gt.spread=function(e){return function(t){return e.apply(null,t)}},gt.isAxiosError=function(e){return X.isObject(e)&&!0===e.isAxiosError},gt.mergeConfig=qe,gt.AxiosHeaders=Ce,gt.formToJSON=e=>Se(X.isHTMLForm(e)?new FormData(e):e),gt.getAdapter=st,gt.HttpStatusCode=bt,gt.default=gt;const wt=gt,Et=(window.wp.notices,window.wp.apiFetch,window.wp.data,()=>{const[e,t]=(0,o.useState)(null),[n,r]=(0,o.useState)([]),[s,i]=(0,o.useState)(!1),[a,c]=(0,o.useState)(!1),u=(e,t,n)=>{const r=cne_museusbr_fetcher.instituicoes_collection_id?cne_museusbr_fetcher.instituicoes_collection_id:14;wt.post(cne_museusbr_fetcher.ajax_url,{item:e,itemDocumentURL:n,itemMetadata:t},{params:{_ajax_nonce:cne_museusbr_fetcher.nonce,action:"create_instituicao"}}).then((e=>{e.data.success&&e.data.data.itemId&&window.location.replace("/wp-admin/?page=tainacan_admin#/collections/"+r+"/items/"+e.data.data.itemId+"/edit"),c(!1)})).catch((e=>{c(!1)}))};return{museus:n,setMuseus:r,museuSelecionado:e,setMuseuSelecionado:t,fetchMuseusFromMuseusBR:e=>{i(!0),wt("https://cadastro.museus.gov.br/wp-json/tainacan/v2/collection/208/items/?perpage=5&paged=1&fetch_only=thumbnail,document,author_name,title,description&search="+e).then((e=>{r(e.data.items?e.data.items.map((e=>({value:e.id,label:e.title,description:e.description,author:e.author_name,thumbnail:e.thumbnail&&e.thumbnail.thumbnail&&e.thumbnail.thumbnail[0]?e.thumbnail.thumbnail[0]:null,document:e.document}))):[]),i(!1)})).catch((e=>{i(!1)}))},createInstituicaoFromMuseu:u,prepareItemToCreateInstituicao:()=>{const t="https://cadastro.museus.gov.br/wp-json/tainacan/v2/item/"+e.value+"/metadata";c(!0),wt.get(t).then((t=>{const n=t.data.map((e=>{if("Tainacan\\Metadata_Types\\Compound"===e.metadatum.metadata_type)return{metadatumId:e.metadatum.id,metadatumValue:e.value.map((e=>({metadatumId:e.metadatum_id,metadatumValue:e.value})))};if("Tainacan\\Metadata_Types\\Taxonomy"===e.metadatum.metadata_type){let t=e.value;return Array.isArray(t)?t=t.map((e=>e.name?e.name:e)):t.name&&(t=t.name),{metadatumId:e.metadatum.id,metadatumValue:t}}return{metadatumId:e.metadatum.id,metadatumValue:e.value}}));e.document&&!isNaN(e.document)?wt.get("https://cadastro.museus.gov.br/wp-json/wp/v2/media/"+e.document).then((t=>{u(e,n,t.data.source_url?t.data.source_url:"")})).catch((t=>{u(e,n,"")})):u(e,n,"")})).catch((e=>{c(!1)}))},isFetchingMuseus:s,setIsFetchingMuseus:i,isCreatingInstituicao:a,setIsCreatingInstituicao:c}}),St=()=>{const[e,t]=(0,o.useState)(!1),{museus:n,setMuseus:r,museuSelecionado:d,setMuseuSelecionado:f,fetchMuseusFromMuseusBR:p,prepareItemToCreateInstituicao:h,isFetchingMuseus:m,isCreatingInstituicao:y}=Et();return(0,a.jsxs)(a.Fragment,{children:[(0,a.jsx)(s.Button,{size:"compact",__next40pxDefaultSize:!0,variant:"primary",onClick:()=>t(!0),children:(0,i.__)("Importar instituição do MuseusBR","cne")}),e&&(0,a.jsx)(s.Modal,{title:(0,i.__)("Crie uma instituição a partir de dados existentes do MuseusBR","cne"),icon:(0,a.jsx)(s.Icon,{icon:"bank"}),onRequestClose:()=>t(!1),size:"large",style:{minHeight:"320px"},children:(0,a.jsxs)(s.Flex,{gap:6,align:"top",children:[(0,a.jsx)(s.FlexBlock,{children:(0,a.jsx)(u,{museuSelecionado:d,setMuseuSelecionado:e=>f(e),museus:n,setMuseus:r,fetchMuseus:_.debounce((e=>{p(e)}),500)})}),(0,a.jsx)(s.FlexItem,{children:m?(0,a.jsx)(s.Spinner,{}):(0,a.jsx)("span",{style:{width:"45px",display:"block"}})}),(0,a.jsx)(s.FlexBlock,{children:d&&(0,a.jsxs)(a.Fragment,{children:[(0,a.jsx)(c,{item:d}),(0,a.jsx)("br",{}),(0,a.jsx)(l,{isCreatingInstituicao:y,onClick:()=>h()})]})})]})})]})},Rt=()=>(0,a.jsx)(St,{});r()((()=>{const e=document.createElement("span");e.classList.add("museusbr-fetcher-button-container");const t=document.getElementsByClassName("wp-header-end")[0];t.parentNode.insertBefore(e,t),(0,o.createRoot)(e).render((0,a.jsx)(Rt,{}))}))})();