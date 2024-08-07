(()=>{"use strict";var e={n:t=>{var n=t&&t.__esModule?()=>t.default:()=>t;return e.d(n,{a:n}),n},d:(t,n)=>{for(var r in n)e.o(n,r)&&!e.o(t,r)&&Object.defineProperty(t,r,{enumerable:!0,get:n[r]})},o:(e,t)=>Object.prototype.hasOwnProperty.call(e,t),r:e=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})}},t={};e.r(t),e.d(t,{hasBrowserEnv:()=>pe,hasStandardBrowserEnv:()=>me,hasStandardBrowserWebWorkerEnv:()=>ye,origin:()=>ge});const n=window.wp.domReady;var r=e.n(n);const o=window.wp.element,s=window.wp.components,i=window.ReactJSXRuntime;function a({item:e}){const{label:t,author:n,thumbnail:r,description:o}=e;return(0,i.jsxs)(s.Flex,{gap:3,children:[(0,i.jsx)(s.FlexItem,{children:r?(0,i.jsx)("img",{src:r,alt:t,width:"68px",height:"68px"}):(0,i.jsx)(s.Icon,{icon:"bank",size:"68"})}),(0,i.jsxs)(s.FlexBlock,{children:[(0,i.jsx)("strong",{children:t||(0,i.jsx)("em",{children:"Museu sem título"})}),n?(0,i.jsxs)(i.Fragment,{children:[(0,i.jsx)("br",{}),(0,i.jsxs)("small",{children:["por"," ",(0,i.jsx)("em",{children:n})]})]}):null,o?(0,i.jsxs)(i.Fragment,{children:[(0,i.jsx)("br",{}),(0,i.jsx)("small",{children:(0,i.jsx)(s.__experimentalTruncate,{numberOfLines:2,children:o})})]}):null]})]})}const c=({museus:e,setMuseus:t,fetchMuseus:n,museuSelecionado:r,setMuseuSelecionado:o})=>(0,i.jsx)(i.Fragment,{children:(0,i.jsx)(s.ComboboxControl,{__next40pxDefaultSize:!0,__experimentalRenderItem:({item:e})=>(0,i.jsx)(a,{item:e}),label:"Pesquise pelo nome do museu como está no MuseusBR",options:e,onFilterValueChange:e=>n(e),value:r?r.label:"",expandOnFocus:!1,onChange:n=>{o(e.find((e=>e.value===n))),t([])}})}),u=({onClick:e,isCreatingInstituicao:t})=>(0,i.jsx)(s.Button,{variant:"primary",__next40pxDefaultSize:!0,onClick:e,__next40pxDefaultSize:!0,disabled:t,children:t?(0,i.jsx)(s.Spinner,{}):"Criar instituição"});function l(e,t){return function(){return e.apply(t,arguments)}}const{toString:d}=Object.prototype,{getPrototypeOf:f}=Object,h=(p=Object.create(null),e=>{const t=d.call(e);return p[t]||(p[t]=t.slice(8,-1).toLowerCase())});var p;const m=e=>(e=e.toLowerCase(),t=>h(t)===e),b=e=>t=>typeof t===e,{isArray:y}=Array,g=b("undefined"),w=m("ArrayBuffer"),E=b("string"),S=b("function"),R=b("number"),O=e=>null!==e&&"object"==typeof e,x=e=>{if("object"!==h(e))return!1;const t=f(e);return!(null!==t&&t!==Object.prototype&&null!==Object.getPrototypeOf(t)||Symbol.toStringTag in e||Symbol.iterator in e)},T=m("Date"),j=m("File"),v=m("Blob"),A=m("FileList"),C=m("URLSearchParams"),[F,N,P,B]=["ReadableStream","Request","Response","Headers"].map(m);function L(e,t,{allOwnKeys:n=!1}={}){if(null==e)return;let r,o;if("object"!=typeof e&&(e=[e]),y(e))for(r=0,o=e.length;r<o;r++)t.call(null,e[r],r,e);else{const o=n?Object.getOwnPropertyNames(e):Object.keys(e),s=o.length;let i;for(r=0;r<s;r++)i=o[r],t.call(null,e[i],i,e)}}function U(e,t){t=t.toLowerCase();const n=Object.keys(e);let r,o=n.length;for(;o-- >0;)if(r=n[o],t===r.toLowerCase())return r;return null}const D="undefined"!=typeof globalThis?globalThis:"undefined"!=typeof self?self:"undefined"!=typeof window?window:global,k=e=>!g(e)&&e!==D,M=(I="undefined"!=typeof Uint8Array&&f(Uint8Array),e=>I&&e instanceof I);var I;const q=m("HTMLFormElement"),z=(({hasOwnProperty:e})=>(t,n)=>e.call(t,n))(Object.prototype),H=m("RegExp"),J=(e,t)=>{const n=Object.getOwnPropertyDescriptors(e),r={};L(n,((n,o)=>{let s;!1!==(s=t(n,o,e))&&(r[o]=s||n)})),Object.defineProperties(e,r)},V="abcdefghijklmnopqrstuvwxyz",W="0123456789",K={DIGIT:W,ALPHA:V,ALPHA_DIGIT:V+V.toUpperCase()+W},$=m("AsyncFunction"),G={isArray:y,isArrayBuffer:w,isBuffer:function(e){return null!==e&&!g(e)&&null!==e.constructor&&!g(e.constructor)&&S(e.constructor.isBuffer)&&e.constructor.isBuffer(e)},isFormData:e=>{let t;return e&&("function"==typeof FormData&&e instanceof FormData||S(e.append)&&("formdata"===(t=h(e))||"object"===t&&S(e.toString)&&"[object FormData]"===e.toString()))},isArrayBufferView:function(e){let t;return t="undefined"!=typeof ArrayBuffer&&ArrayBuffer.isView?ArrayBuffer.isView(e):e&&e.buffer&&w(e.buffer),t},isString:E,isNumber:R,isBoolean:e=>!0===e||!1===e,isObject:O,isPlainObject:x,isReadableStream:F,isRequest:N,isResponse:P,isHeaders:B,isUndefined:g,isDate:T,isFile:j,isBlob:v,isRegExp:H,isFunction:S,isStream:e=>O(e)&&S(e.pipe),isURLSearchParams:C,isTypedArray:M,isFileList:A,forEach:L,merge:function e(){const{caseless:t}=k(this)&&this||{},n={},r=(r,o)=>{const s=t&&U(n,o)||o;x(n[s])&&x(r)?n[s]=e(n[s],r):x(r)?n[s]=e({},r):y(r)?n[s]=r.slice():n[s]=r};for(let e=0,t=arguments.length;e<t;e++)arguments[e]&&L(arguments[e],r);return n},extend:(e,t,n,{allOwnKeys:r}={})=>(L(t,((t,r)=>{n&&S(t)?e[r]=l(t,n):e[r]=t}),{allOwnKeys:r}),e),trim:e=>e.trim?e.trim():e.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,""),stripBOM:e=>(65279===e.charCodeAt(0)&&(e=e.slice(1)),e),inherits:(e,t,n,r)=>{e.prototype=Object.create(t.prototype,r),e.prototype.constructor=e,Object.defineProperty(e,"super",{value:t.prototype}),n&&Object.assign(e.prototype,n)},toFlatObject:(e,t,n,r)=>{let o,s,i;const a={};if(t=t||{},null==e)return t;do{for(o=Object.getOwnPropertyNames(e),s=o.length;s-- >0;)i=o[s],r&&!r(i,e,t)||a[i]||(t[i]=e[i],a[i]=!0);e=!1!==n&&f(e)}while(e&&(!n||n(e,t))&&e!==Object.prototype);return t},kindOf:h,kindOfTest:m,endsWith:(e,t,n)=>{e=String(e),(void 0===n||n>e.length)&&(n=e.length),n-=t.length;const r=e.indexOf(t,n);return-1!==r&&r===n},toArray:e=>{if(!e)return null;if(y(e))return e;let t=e.length;if(!R(t))return null;const n=new Array(t);for(;t-- >0;)n[t]=e[t];return n},forEachEntry:(e,t)=>{const n=(e&&e[Symbol.iterator]).call(e);let r;for(;(r=n.next())&&!r.done;){const n=r.value;t.call(e,n[0],n[1])}},matchAll:(e,t)=>{let n;const r=[];for(;null!==(n=e.exec(t));)r.push(n);return r},isHTMLForm:q,hasOwnProperty:z,hasOwnProp:z,reduceDescriptors:J,freezeMethods:e=>{J(e,((t,n)=>{if(S(e)&&-1!==["arguments","caller","callee"].indexOf(n))return!1;const r=e[n];S(r)&&(t.enumerable=!1,"writable"in t?t.writable=!1:t.set||(t.set=()=>{throw Error("Can not rewrite read-only method '"+n+"'")}))}))},toObjectSet:(e,t)=>{const n={},r=e=>{e.forEach((e=>{n[e]=!0}))};return y(e)?r(e):r(String(e).split(t)),n},toCamelCase:e=>e.toLowerCase().replace(/[-_\s]([a-z\d])(\w*)/g,(function(e,t,n){return t.toUpperCase()+n})),noop:()=>{},toFiniteNumber:(e,t)=>null!=e&&Number.isFinite(e=+e)?e:t,findKey:U,global:D,isContextDefined:k,ALPHABET:K,generateString:(e=16,t=K.ALPHA_DIGIT)=>{let n="";const{length:r}=t;for(;e--;)n+=t[Math.random()*r|0];return n},isSpecCompliantForm:function(e){return!!(e&&S(e.append)&&"FormData"===e[Symbol.toStringTag]&&e[Symbol.iterator])},toJSONObject:e=>{const t=new Array(10),n=(e,r)=>{if(O(e)){if(t.indexOf(e)>=0)return;if(!("toJSON"in e)){t[r]=e;const o=y(e)?[]:{};return L(e,((e,t)=>{const s=n(e,r+1);!g(s)&&(o[t]=s)})),t[r]=void 0,o}}return e};return n(e,0)},isAsyncFn:$,isThenable:e=>e&&(O(e)||S(e))&&S(e.then)&&S(e.catch)};function X(e,t,n,r,o){Error.call(this),Error.captureStackTrace?Error.captureStackTrace(this,this.constructor):this.stack=(new Error).stack,this.message=e,this.name="AxiosError",t&&(this.code=t),n&&(this.config=n),r&&(this.request=r),o&&(this.response=o)}G.inherits(X,Error,{toJSON:function(){return{message:this.message,name:this.name,description:this.description,number:this.number,fileName:this.fileName,lineNumber:this.lineNumber,columnNumber:this.columnNumber,stack:this.stack,config:G.toJSONObject(this.config),code:this.code,status:this.response&&this.response.status?this.response.status:null}}});const Q=X.prototype,Z={};["ERR_BAD_OPTION_VALUE","ERR_BAD_OPTION","ECONNABORTED","ETIMEDOUT","ERR_NETWORK","ERR_FR_TOO_MANY_REDIRECTS","ERR_DEPRECATED","ERR_BAD_RESPONSE","ERR_BAD_REQUEST","ERR_CANCELED","ERR_NOT_SUPPORT","ERR_INVALID_URL"].forEach((e=>{Z[e]={value:e}})),Object.defineProperties(X,Z),Object.defineProperty(Q,"isAxiosError",{value:!0}),X.from=(e,t,n,r,o,s)=>{const i=Object.create(Q);return G.toFlatObject(e,i,(function(e){return e!==Error.prototype}),(e=>"isAxiosError"!==e)),X.call(i,e.message,t,n,r,o),i.cause=e,i.name=e.name,s&&Object.assign(i,s),i};const Y=X;function ee(e){return G.isPlainObject(e)||G.isArray(e)}function te(e){return G.endsWith(e,"[]")?e.slice(0,-2):e}function ne(e,t,n){return e?e.concat(t).map((function(e,t){return e=te(e),!n&&t?"["+e+"]":e})).join(n?".":""):t}const re=G.toFlatObject(G,{},null,(function(e){return/^is[A-Z]/.test(e)})),oe=function(e,t,n){if(!G.isObject(e))throw new TypeError("target must be an object");t=t||new FormData;const r=(n=G.toFlatObject(n,{metaTokens:!0,dots:!1,indexes:!1},!1,(function(e,t){return!G.isUndefined(t[e])}))).metaTokens,o=n.visitor||u,s=n.dots,i=n.indexes,a=(n.Blob||"undefined"!=typeof Blob&&Blob)&&G.isSpecCompliantForm(t);if(!G.isFunction(o))throw new TypeError("visitor must be a function");function c(e){if(null===e)return"";if(G.isDate(e))return e.toISOString();if(!a&&G.isBlob(e))throw new Y("Blob is not supported. Use a Buffer instead.");return G.isArrayBuffer(e)||G.isTypedArray(e)?a&&"function"==typeof Blob?new Blob([e]):Buffer.from(e):e}function u(e,n,o){let a=e;if(e&&!o&&"object"==typeof e)if(G.endsWith(n,"{}"))n=r?n:n.slice(0,-2),e=JSON.stringify(e);else if(G.isArray(e)&&function(e){return G.isArray(e)&&!e.some(ee)}(e)||(G.isFileList(e)||G.endsWith(n,"[]"))&&(a=G.toArray(e)))return n=te(n),a.forEach((function(e,r){!G.isUndefined(e)&&null!==e&&t.append(!0===i?ne([n],r,s):null===i?n:n+"[]",c(e))})),!1;return!!ee(e)||(t.append(ne(o,n,s),c(e)),!1)}const l=[],d=Object.assign(re,{defaultVisitor:u,convertValue:c,isVisitable:ee});if(!G.isObject(e))throw new TypeError("data must be an object");return function e(n,r){if(!G.isUndefined(n)){if(-1!==l.indexOf(n))throw Error("Circular reference detected in "+r.join("."));l.push(n),G.forEach(n,(function(n,s){!0===(!(G.isUndefined(n)||null===n)&&o.call(t,n,G.isString(s)?s.trim():s,r,d))&&e(n,r?r.concat(s):[s])})),l.pop()}}(e),t};function se(e){const t={"!":"%21","'":"%27","(":"%28",")":"%29","~":"%7E","%20":"+","%00":"\0"};return encodeURIComponent(e).replace(/[!'()~]|%20|%00/g,(function(e){return t[e]}))}function ie(e,t){this._pairs=[],e&&oe(e,this,t)}const ae=ie.prototype;ae.append=function(e,t){this._pairs.push([e,t])},ae.toString=function(e){const t=e?function(t){return e.call(this,t,se)}:se;return this._pairs.map((function(e){return t(e[0])+"="+t(e[1])}),"").join("&")};const ce=ie;function ue(e){return encodeURIComponent(e).replace(/%3A/gi,":").replace(/%24/g,"$").replace(/%2C/gi,",").replace(/%20/g,"+").replace(/%5B/gi,"[").replace(/%5D/gi,"]")}function le(e,t,n){if(!t)return e;const r=n&&n.encode||ue,o=n&&n.serialize;let s;if(s=o?o(t,n):G.isURLSearchParams(t)?t.toString():new ce(t,n).toString(r),s){const t=e.indexOf("#");-1!==t&&(e=e.slice(0,t)),e+=(-1===e.indexOf("?")?"?":"&")+s}return e}const de=class{constructor(){this.handlers=[]}use(e,t,n){return this.handlers.push({fulfilled:e,rejected:t,synchronous:!!n&&n.synchronous,runWhen:n?n.runWhen:null}),this.handlers.length-1}eject(e){this.handlers[e]&&(this.handlers[e]=null)}clear(){this.handlers&&(this.handlers=[])}forEach(e){G.forEach(this.handlers,(function(t){null!==t&&e(t)}))}},fe={silentJSONParsing:!0,forcedJSONParsing:!0,clarifyTimeoutError:!1},he={isBrowser:!0,classes:{URLSearchParams:"undefined"!=typeof URLSearchParams?URLSearchParams:ce,FormData:"undefined"!=typeof FormData?FormData:null,Blob:"undefined"!=typeof Blob?Blob:null},protocols:["http","https","file","blob","url","data"]},pe="undefined"!=typeof window&&"undefined"!=typeof document,me=(be="undefined"!=typeof navigator&&navigator.product,pe&&["ReactNative","NativeScript","NS"].indexOf(be)<0);var be;const ye="undefined"!=typeof WorkerGlobalScope&&self instanceof WorkerGlobalScope&&"function"==typeof self.importScripts,ge=pe&&window.location.href||"http://localhost",we={...t,...he},Ee=function(e){function t(e,n,r,o){let s=e[o++];if("__proto__"===s)return!0;const i=Number.isFinite(+s),a=o>=e.length;return s=!s&&G.isArray(r)?r.length:s,a?(G.hasOwnProp(r,s)?r[s]=[r[s],n]:r[s]=n,!i):(r[s]&&G.isObject(r[s])||(r[s]=[]),t(e,n,r[s],o)&&G.isArray(r[s])&&(r[s]=function(e){const t={},n=Object.keys(e);let r;const o=n.length;let s;for(r=0;r<o;r++)s=n[r],t[s]=e[s];return t}(r[s])),!i)}if(G.isFormData(e)&&G.isFunction(e.entries)){const n={};return G.forEachEntry(e,((e,r)=>{t(function(e){return G.matchAll(/\w+|\[(\w*)]/g,e).map((e=>"[]"===e[0]?"":e[1]||e[0]))}(e),r,n,0)})),n}return null},Se={transitional:fe,adapter:["xhr","http","fetch"],transformRequest:[function(e,t){const n=t.getContentType()||"",r=n.indexOf("application/json")>-1,o=G.isObject(e);if(o&&G.isHTMLForm(e)&&(e=new FormData(e)),G.isFormData(e))return r?JSON.stringify(Ee(e)):e;if(G.isArrayBuffer(e)||G.isBuffer(e)||G.isStream(e)||G.isFile(e)||G.isBlob(e)||G.isReadableStream(e))return e;if(G.isArrayBufferView(e))return e.buffer;if(G.isURLSearchParams(e))return t.setContentType("application/x-www-form-urlencoded;charset=utf-8",!1),e.toString();let s;if(o){if(n.indexOf("application/x-www-form-urlencoded")>-1)return function(e,t){return oe(e,new we.classes.URLSearchParams,Object.assign({visitor:function(e,t,n,r){return we.isNode&&G.isBuffer(e)?(this.append(t,e.toString("base64")),!1):r.defaultVisitor.apply(this,arguments)}},t))}(e,this.formSerializer).toString();if((s=G.isFileList(e))||n.indexOf("multipart/form-data")>-1){const t=this.env&&this.env.FormData;return oe(s?{"files[]":e}:e,t&&new t,this.formSerializer)}}return o||r?(t.setContentType("application/json",!1),function(e,t,n){if(G.isString(e))try{return(0,JSON.parse)(e),G.trim(e)}catch(e){if("SyntaxError"!==e.name)throw e}return(0,JSON.stringify)(e)}(e)):e}],transformResponse:[function(e){const t=this.transitional||Se.transitional,n=t&&t.forcedJSONParsing,r="json"===this.responseType;if(G.isResponse(e)||G.isReadableStream(e))return e;if(e&&G.isString(e)&&(n&&!this.responseType||r)){const n=!(t&&t.silentJSONParsing)&&r;try{return JSON.parse(e)}catch(e){if(n){if("SyntaxError"===e.name)throw Y.from(e,Y.ERR_BAD_RESPONSE,this,null,this.response);throw e}}}return e}],timeout:0,xsrfCookieName:"XSRF-TOKEN",xsrfHeaderName:"X-XSRF-TOKEN",maxContentLength:-1,maxBodyLength:-1,env:{FormData:we.classes.FormData,Blob:we.classes.Blob},validateStatus:function(e){return e>=200&&e<300},headers:{common:{Accept:"application/json, text/plain, */*","Content-Type":void 0}}};G.forEach(["delete","get","head","post","put","patch"],(e=>{Se.headers[e]={}}));const Re=Se,Oe=G.toObjectSet(["age","authorization","content-length","content-type","etag","expires","from","host","if-modified-since","if-unmodified-since","last-modified","location","max-forwards","proxy-authorization","referer","retry-after","user-agent"]),xe=Symbol("internals");function Te(e){return e&&String(e).trim().toLowerCase()}function je(e){return!1===e||null==e?e:G.isArray(e)?e.map(je):String(e)}function ve(e,t,n,r,o){return G.isFunction(r)?r.call(this,t,n):(o&&(t=n),G.isString(t)?G.isString(r)?-1!==t.indexOf(r):G.isRegExp(r)?r.test(t):void 0:void 0)}class _e{constructor(e){e&&this.set(e)}set(e,t,n){const r=this;function o(e,t,n){const o=Te(t);if(!o)throw new Error("header name must be a non-empty string");const s=G.findKey(r,o);(!s||void 0===r[s]||!0===n||void 0===n&&!1!==r[s])&&(r[s||t]=je(e))}const s=(e,t)=>G.forEach(e,((e,n)=>o(e,n,t)));if(G.isPlainObject(e)||e instanceof this.constructor)s(e,t);else if(G.isString(e)&&(e=e.trim())&&!/^[-_a-zA-Z0-9^`|~,!#$%&'*+.]+$/.test(e.trim()))s((e=>{const t={};let n,r,o;return e&&e.split("\n").forEach((function(e){o=e.indexOf(":"),n=e.substring(0,o).trim().toLowerCase(),r=e.substring(o+1).trim(),!n||t[n]&&Oe[n]||("set-cookie"===n?t[n]?t[n].push(r):t[n]=[r]:t[n]=t[n]?t[n]+", "+r:r)})),t})(e),t);else if(G.isHeaders(e))for(const[t,r]of e.entries())o(r,t,n);else null!=e&&o(t,e,n);return this}get(e,t){if(e=Te(e)){const n=G.findKey(this,e);if(n){const e=this[n];if(!t)return e;if(!0===t)return function(e){const t=Object.create(null),n=/([^\s,;=]+)\s*(?:=\s*([^,;]+))?/g;let r;for(;r=n.exec(e);)t[r[1]]=r[2];return t}(e);if(G.isFunction(t))return t.call(this,e,n);if(G.isRegExp(t))return t.exec(e);throw new TypeError("parser must be boolean|regexp|function")}}}has(e,t){if(e=Te(e)){const n=G.findKey(this,e);return!(!n||void 0===this[n]||t&&!ve(0,this[n],n,t))}return!1}delete(e,t){const n=this;let r=!1;function o(e){if(e=Te(e)){const o=G.findKey(n,e);!o||t&&!ve(0,n[o],o,t)||(delete n[o],r=!0)}}return G.isArray(e)?e.forEach(o):o(e),r}clear(e){const t=Object.keys(this);let n=t.length,r=!1;for(;n--;){const o=t[n];e&&!ve(0,this[o],o,e,!0)||(delete this[o],r=!0)}return r}normalize(e){const t=this,n={};return G.forEach(this,((r,o)=>{const s=G.findKey(n,o);if(s)return t[s]=je(r),void delete t[o];const i=e?function(e){return e.trim().toLowerCase().replace(/([a-z\d])(\w*)/g,((e,t,n)=>t.toUpperCase()+n))}(o):String(o).trim();i!==o&&delete t[o],t[i]=je(r),n[i]=!0})),this}concat(...e){return this.constructor.concat(this,...e)}toJSON(e){const t=Object.create(null);return G.forEach(this,((n,r)=>{null!=n&&!1!==n&&(t[r]=e&&G.isArray(n)?n.join(", "):n)})),t}[Symbol.iterator](){return Object.entries(this.toJSON())[Symbol.iterator]()}toString(){return Object.entries(this.toJSON()).map((([e,t])=>e+": "+t)).join("\n")}get[Symbol.toStringTag](){return"AxiosHeaders"}static from(e){return e instanceof this?e:new this(e)}static concat(e,...t){const n=new this(e);return t.forEach((e=>n.set(e))),n}static accessor(e){const t=(this[xe]=this[xe]={accessors:{}}).accessors,n=this.prototype;function r(e){const r=Te(e);t[r]||(function(e,t){const n=G.toCamelCase(" "+t);["get","set","has"].forEach((r=>{Object.defineProperty(e,r+n,{value:function(e,n,o){return this[r].call(this,t,e,n,o)},configurable:!0})}))}(n,e),t[r]=!0)}return G.isArray(e)?e.forEach(r):r(e),this}}_e.accessor(["Content-Type","Content-Length","Accept","Accept-Encoding","User-Agent","Authorization"]),G.reduceDescriptors(_e.prototype,(({value:e},t)=>{let n=t[0].toUpperCase()+t.slice(1);return{get:()=>e,set(e){this[n]=e}}})),G.freezeMethods(_e);const Ae=_e;function Ce(e,t){const n=this||Re,r=t||n,o=Ae.from(r.headers);let s=r.data;return G.forEach(e,(function(e){s=e.call(n,s,o.normalize(),t?t.status:void 0)})),o.normalize(),s}function Fe(e){return!(!e||!e.__CANCEL__)}function Ne(e,t,n){Y.call(this,null==e?"canceled":e,Y.ERR_CANCELED,t,n),this.name="CanceledError"}G.inherits(Ne,Y,{__CANCEL__:!0});const Pe=Ne;function Be(e,t,n){const r=n.config.validateStatus;n.status&&r&&!r(n.status)?t(new Y("Request failed with status code "+n.status,[Y.ERR_BAD_REQUEST,Y.ERR_BAD_RESPONSE][Math.floor(n.status/100)-4],n.config,n.request,n)):e(n)}const Le=(e,t,n=3)=>{let r=0;const o=function(e,t){e=e||10;const n=new Array(e),r=new Array(e);let o,s=0,i=0;return t=void 0!==t?t:1e3,function(a){const c=Date.now(),u=r[i];o||(o=c),n[s]=a,r[s]=c;let l=i,d=0;for(;l!==s;)d+=n[l++],l%=e;if(s=(s+1)%e,s===i&&(i=(i+1)%e),c-o<t)return;const f=u&&c-u;return f?Math.round(1e3*d/f):void 0}}(50,250);return function(e,t){let n=0;const r=1e3/t;let o=null;return function(){const t=!0===this,s=Date.now();if(t||s-n>r)return o&&(clearTimeout(o),o=null),n=s,e.apply(null,arguments);o||(o=setTimeout((()=>(o=null,n=Date.now(),e.apply(null,arguments))),r-(s-n)))}}((n=>{const s=n.loaded,i=n.lengthComputable?n.total:void 0,a=s-r,c=o(a);r=s;const u={loaded:s,total:i,progress:i?s/i:void 0,bytes:a,rate:c||void 0,estimated:c&&i&&s<=i?(i-s)/c:void 0,event:n,lengthComputable:null!=i};u[t?"download":"upload"]=!0,e(u)}),n)},Ue=we.hasStandardBrowserEnv?function(){const e=/(msie|trident)/i.test(navigator.userAgent),t=document.createElement("a");let n;function r(n){let r=n;return e&&(t.setAttribute("href",r),r=t.href),t.setAttribute("href",r),{href:t.href,protocol:t.protocol?t.protocol.replace(/:$/,""):"",host:t.host,search:t.search?t.search.replace(/^\?/,""):"",hash:t.hash?t.hash.replace(/^#/,""):"",hostname:t.hostname,port:t.port,pathname:"/"===t.pathname.charAt(0)?t.pathname:"/"+t.pathname}}return n=r(window.location.href),function(e){const t=G.isString(e)?r(e):e;return t.protocol===n.protocol&&t.host===n.host}}():function(){return!0},De=we.hasStandardBrowserEnv?{write(e,t,n,r,o,s){const i=[e+"="+encodeURIComponent(t)];G.isNumber(n)&&i.push("expires="+new Date(n).toGMTString()),G.isString(r)&&i.push("path="+r),G.isString(o)&&i.push("domain="+o),!0===s&&i.push("secure"),document.cookie=i.join("; ")},read(e){const t=document.cookie.match(new RegExp("(^|;\\s*)("+e+")=([^;]*)"));return t?decodeURIComponent(t[3]):null},remove(e){this.write(e,"",Date.now()-864e5)}}:{write(){},read:()=>null,remove(){}};function ke(e,t){return e&&!/^([a-z][a-z\d+\-.]*:)?\/\//i.test(t)?function(e,t){return t?e.replace(/\/?\/$/,"")+"/"+t.replace(/^\/+/,""):e}(e,t):t}const Me=e=>e instanceof Ae?{...e}:e;function Ie(e,t){t=t||{};const n={};function r(e,t,n){return G.isPlainObject(e)&&G.isPlainObject(t)?G.merge.call({caseless:n},e,t):G.isPlainObject(t)?G.merge({},t):G.isArray(t)?t.slice():t}function o(e,t,n){return G.isUndefined(t)?G.isUndefined(e)?void 0:r(void 0,e,n):r(e,t,n)}function s(e,t){if(!G.isUndefined(t))return r(void 0,t)}function i(e,t){return G.isUndefined(t)?G.isUndefined(e)?void 0:r(void 0,e):r(void 0,t)}function a(n,o,s){return s in t?r(n,o):s in e?r(void 0,n):void 0}const c={url:s,method:s,data:s,baseURL:i,transformRequest:i,transformResponse:i,paramsSerializer:i,timeout:i,timeoutMessage:i,withCredentials:i,withXSRFToken:i,adapter:i,responseType:i,xsrfCookieName:i,xsrfHeaderName:i,onUploadProgress:i,onDownloadProgress:i,decompress:i,maxContentLength:i,maxBodyLength:i,beforeRedirect:i,transport:i,httpAgent:i,httpsAgent:i,cancelToken:i,socketPath:i,responseEncoding:i,validateStatus:a,headers:(e,t)=>o(Me(e),Me(t),!0)};return G.forEach(Object.keys(Object.assign({},e,t)),(function(r){const s=c[r]||o,i=s(e[r],t[r],r);G.isUndefined(i)&&s!==a||(n[r]=i)})),n}const qe=e=>{const t=Ie({},e);let n,{data:r,withXSRFToken:o,xsrfHeaderName:s,xsrfCookieName:i,headers:a,auth:c}=t;if(t.headers=a=Ae.from(a),t.url=le(ke(t.baseURL,t.url),e.params,e.paramsSerializer),c&&a.set("Authorization","Basic "+btoa((c.username||"")+":"+(c.password?unescape(encodeURIComponent(c.password)):""))),G.isFormData(r))if(we.hasStandardBrowserEnv||we.hasStandardBrowserWebWorkerEnv)a.setContentType(void 0);else if(!1!==(n=a.getContentType())){const[e,...t]=n?n.split(";").map((e=>e.trim())).filter(Boolean):[];a.setContentType([e||"multipart/form-data",...t].join("; "))}if(we.hasStandardBrowserEnv&&(o&&G.isFunction(o)&&(o=o(t)),o||!1!==o&&Ue(t.url))){const e=s&&i&&De.read(i);e&&a.set(s,e)}return t},ze="undefined"!=typeof XMLHttpRequest&&function(e){return new Promise((function(t,n){const r=qe(e);let o=r.data;const s=Ae.from(r.headers).normalize();let i,{responseType:a}=r;function c(){r.cancelToken&&r.cancelToken.unsubscribe(i),r.signal&&r.signal.removeEventListener("abort",i)}let u=new XMLHttpRequest;function l(){if(!u)return;const r=Ae.from("getAllResponseHeaders"in u&&u.getAllResponseHeaders());Be((function(e){t(e),c()}),(function(e){n(e),c()}),{data:a&&"text"!==a&&"json"!==a?u.response:u.responseText,status:u.status,statusText:u.statusText,headers:r,config:e,request:u}),u=null}u.open(r.method.toUpperCase(),r.url,!0),u.timeout=r.timeout,"onloadend"in u?u.onloadend=l:u.onreadystatechange=function(){u&&4===u.readyState&&(0!==u.status||u.responseURL&&0===u.responseURL.indexOf("file:"))&&setTimeout(l)},u.onabort=function(){u&&(n(new Y("Request aborted",Y.ECONNABORTED,r,u)),u=null)},u.onerror=function(){n(new Y("Network Error",Y.ERR_NETWORK,r,u)),u=null},u.ontimeout=function(){let e=r.timeout?"timeout of "+r.timeout+"ms exceeded":"timeout exceeded";const t=r.transitional||fe;r.timeoutErrorMessage&&(e=r.timeoutErrorMessage),n(new Y(e,t.clarifyTimeoutError?Y.ETIMEDOUT:Y.ECONNABORTED,r,u)),u=null},void 0===o&&s.setContentType(null),"setRequestHeader"in u&&G.forEach(s.toJSON(),(function(e,t){u.setRequestHeader(t,e)})),G.isUndefined(r.withCredentials)||(u.withCredentials=!!r.withCredentials),a&&"json"!==a&&(u.responseType=r.responseType),"function"==typeof r.onDownloadProgress&&u.addEventListener("progress",Le(r.onDownloadProgress,!0)),"function"==typeof r.onUploadProgress&&u.upload&&u.upload.addEventListener("progress",Le(r.onUploadProgress)),(r.cancelToken||r.signal)&&(i=t=>{u&&(n(!t||t.type?new Pe(null,e,u):t),u.abort(),u=null)},r.cancelToken&&r.cancelToken.subscribe(i),r.signal&&(r.signal.aborted?i():r.signal.addEventListener("abort",i)));const d=function(e){const t=/^([-+\w]{1,25})(:?\/\/|:)/.exec(e);return t&&t[1]||""}(r.url);d&&-1===we.protocols.indexOf(d)?n(new Y("Unsupported protocol "+d+":",Y.ERR_BAD_REQUEST,e)):u.send(o||null)}))},He=(e,t)=>{let n,r=new AbortController;const o=function(e){if(!n){n=!0,i();const t=e instanceof Error?e:this.reason;r.abort(t instanceof Y?t:new Pe(t instanceof Error?t.message:t))}};let s=t&&setTimeout((()=>{o(new Y(`timeout ${t} of ms exceeded`,Y.ETIMEDOUT))}),t);const i=()=>{e&&(s&&clearTimeout(s),s=null,e.forEach((e=>{e&&(e.removeEventListener?e.removeEventListener("abort",o):e.unsubscribe(o))})),e=null)};e.forEach((e=>e&&e.addEventListener&&e.addEventListener("abort",o)));const{signal:a}=r;return a.unsubscribe=i,[a,()=>{s&&clearTimeout(s),s=null}]},Je=function*(e,t){let n=e.byteLength;if(!t||n<t)return void(yield e);let r,o=0;for(;o<n;)r=o+t,yield e.slice(o,r),o=r},Ve=(e,t,n,r,o)=>{const s=async function*(e,t,n){for await(const r of e)yield*Je(ArrayBuffer.isView(r)?r:await n(String(r)),t)}(e,t,o);let i=0;return new ReadableStream({type:"bytes",async pull(e){const{done:t,value:o}=await s.next();if(t)return e.close(),void r();let a=o.byteLength;n&&n(i+=a),e.enqueue(new Uint8Array(o))},cancel:e=>(r(e),s.return())},{highWaterMark:2})},We=(e,t)=>{const n=null!=e;return r=>setTimeout((()=>t({lengthComputable:n,total:e,loaded:r})))},Ke="function"==typeof fetch&&"function"==typeof Request&&"function"==typeof Response,$e=Ke&&"function"==typeof ReadableStream,Ge=Ke&&("function"==typeof TextEncoder?(Xe=new TextEncoder,e=>Xe.encode(e)):async e=>new Uint8Array(await new Response(e).arrayBuffer()));var Xe;const Qe=$e&&(()=>{let e=!1;const t=new Request(we.origin,{body:new ReadableStream,method:"POST",get duplex(){return e=!0,"half"}}).headers.has("Content-Type");return e&&!t})(),Ze=$e&&!!(()=>{try{return G.isReadableStream(new Response("").body)}catch(e){}})(),Ye={stream:Ze&&(e=>e.body)};var et;Ke&&(et=new Response,["text","arrayBuffer","blob","formData","stream"].forEach((e=>{!Ye[e]&&(Ye[e]=G.isFunction(et[e])?t=>t[e]():(t,n)=>{throw new Y(`Response type '${e}' is not supported`,Y.ERR_NOT_SUPPORT,n)})})));const tt={http:null,xhr:ze,fetch:Ke&&(async e=>{let{url:t,method:n,data:r,signal:o,cancelToken:s,timeout:i,onDownloadProgress:a,onUploadProgress:c,responseType:u,headers:l,withCredentials:d="same-origin",fetchOptions:f}=qe(e);u=u?(u+"").toLowerCase():"text";let h,p,[m,b]=o||s||i?He([o,s],i):[];const y=()=>{!h&&setTimeout((()=>{m&&m.unsubscribe()})),h=!0};let g;try{if(c&&Qe&&"get"!==n&&"head"!==n&&0!==(g=await(async(e,t)=>{const n=G.toFiniteNumber(e.getContentLength());return null==n?(async e=>null==e?0:G.isBlob(e)?e.size:G.isSpecCompliantForm(e)?(await new Request(e).arrayBuffer()).byteLength:G.isArrayBufferView(e)?e.byteLength:(G.isURLSearchParams(e)&&(e+=""),G.isString(e)?(await Ge(e)).byteLength:void 0))(t):n})(l,r))){let e,n=new Request(t,{method:"POST",body:r,duplex:"half"});G.isFormData(r)&&(e=n.headers.get("content-type"))&&l.setContentType(e),n.body&&(r=Ve(n.body,65536,We(g,Le(c)),null,Ge))}G.isString(d)||(d=d?"cors":"omit"),p=new Request(t,{...f,signal:m,method:n.toUpperCase(),headers:l.normalize().toJSON(),body:r,duplex:"half",withCredentials:d});let o=await fetch(p);const s=Ze&&("stream"===u||"response"===u);if(Ze&&(a||s)){const e={};["status","statusText","headers"].forEach((t=>{e[t]=o[t]}));const t=G.toFiniteNumber(o.headers.get("content-length"));o=new Response(Ve(o.body,65536,a&&We(t,Le(a,!0)),s&&y,Ge),e)}u=u||"text";let i=await Ye[G.findKey(Ye,u)||"text"](o,e);return!s&&y(),b&&b(),await new Promise(((t,n)=>{Be(t,n,{data:i,headers:Ae.from(o.headers),status:o.status,statusText:o.statusText,config:e,request:p})}))}catch(t){if(y(),t&&"TypeError"===t.name&&/fetch/i.test(t.message))throw Object.assign(new Y("Network Error",Y.ERR_NETWORK,e,p),{cause:t.cause||t});throw Y.from(t,t&&t.code,e,p)}})};G.forEach(tt,((e,t)=>{if(e){try{Object.defineProperty(e,"name",{value:t})}catch(e){}Object.defineProperty(e,"adapterName",{value:t})}}));const nt=e=>`- ${e}`,rt=e=>G.isFunction(e)||null===e||!1===e,ot=e=>{e=G.isArray(e)?e:[e];const{length:t}=e;let n,r;const o={};for(let s=0;s<t;s++){let t;if(n=e[s],r=n,!rt(n)&&(r=tt[(t=String(n)).toLowerCase()],void 0===r))throw new Y(`Unknown adapter '${t}'`);if(r)break;o[t||"#"+s]=r}if(!r){const e=Object.entries(o).map((([e,t])=>`adapter ${e} `+(!1===t?"is not supported by the environment":"is not available in the build")));let n=t?e.length>1?"since :\n"+e.map(nt).join("\n"):" "+nt(e[0]):"as no adapter specified";throw new Y("There is no suitable adapter to dispatch the request "+n,"ERR_NOT_SUPPORT")}return r};function st(e){if(e.cancelToken&&e.cancelToken.throwIfRequested(),e.signal&&e.signal.aborted)throw new Pe(null,e)}function it(e){return st(e),e.headers=Ae.from(e.headers),e.data=Ce.call(e,e.transformRequest),-1!==["post","put","patch"].indexOf(e.method)&&e.headers.setContentType("application/x-www-form-urlencoded",!1),ot(e.adapter||Re.adapter)(e).then((function(t){return st(e),t.data=Ce.call(e,e.transformResponse,t),t.headers=Ae.from(t.headers),t}),(function(t){return Fe(t)||(st(e),t&&t.response&&(t.response.data=Ce.call(e,e.transformResponse,t.response),t.response.headers=Ae.from(t.response.headers))),Promise.reject(t)}))}const at={};["object","boolean","number","function","string","symbol"].forEach(((e,t)=>{at[e]=function(n){return typeof n===e||"a"+(t<1?"n ":" ")+e}}));const ct={};at.transitional=function(e,t,n){function r(e,t){return"[Axios v1.7.2] Transitional option '"+e+"'"+t+(n?". "+n:"")}return(n,o,s)=>{if(!1===e)throw new Y(r(o," has been removed"+(t?" in "+t:"")),Y.ERR_DEPRECATED);return t&&!ct[o]&&(ct[o]=!0,console.warn(r(o," has been deprecated since v"+t+" and will be removed in the near future"))),!e||e(n,o,s)}};const ut={assertOptions:function(e,t,n){if("object"!=typeof e)throw new Y("options must be an object",Y.ERR_BAD_OPTION_VALUE);const r=Object.keys(e);let o=r.length;for(;o-- >0;){const s=r[o],i=t[s];if(i){const t=e[s],n=void 0===t||i(t,s,e);if(!0!==n)throw new Y("option "+s+" must be "+n,Y.ERR_BAD_OPTION_VALUE)}else if(!0!==n)throw new Y("Unknown option "+s,Y.ERR_BAD_OPTION)}},validators:at},lt=ut.validators;class dt{constructor(e){this.defaults=e,this.interceptors={request:new de,response:new de}}async request(e,t){try{return await this._request(e,t)}catch(e){if(e instanceof Error){let t;Error.captureStackTrace?Error.captureStackTrace(t={}):t=new Error;const n=t.stack?t.stack.replace(/^.+\n/,""):"";try{e.stack?n&&!String(e.stack).endsWith(n.replace(/^.+\n.+\n/,""))&&(e.stack+="\n"+n):e.stack=n}catch(e){}}throw e}}_request(e,t){"string"==typeof e?(t=t||{}).url=e:t=e||{},t=Ie(this.defaults,t);const{transitional:n,paramsSerializer:r,headers:o}=t;void 0!==n&&ut.assertOptions(n,{silentJSONParsing:lt.transitional(lt.boolean),forcedJSONParsing:lt.transitional(lt.boolean),clarifyTimeoutError:lt.transitional(lt.boolean)},!1),null!=r&&(G.isFunction(r)?t.paramsSerializer={serialize:r}:ut.assertOptions(r,{encode:lt.function,serialize:lt.function},!0)),t.method=(t.method||this.defaults.method||"get").toLowerCase();let s=o&&G.merge(o.common,o[t.method]);o&&G.forEach(["delete","get","head","post","put","patch","common"],(e=>{delete o[e]})),t.headers=Ae.concat(s,o);const i=[];let a=!0;this.interceptors.request.forEach((function(e){"function"==typeof e.runWhen&&!1===e.runWhen(t)||(a=a&&e.synchronous,i.unshift(e.fulfilled,e.rejected))}));const c=[];let u;this.interceptors.response.forEach((function(e){c.push(e.fulfilled,e.rejected)}));let l,d=0;if(!a){const e=[it.bind(this),void 0];for(e.unshift.apply(e,i),e.push.apply(e,c),l=e.length,u=Promise.resolve(t);d<l;)u=u.then(e[d++],e[d++]);return u}l=i.length;let f=t;for(d=0;d<l;){const e=i[d++],t=i[d++];try{f=e(f)}catch(e){t.call(this,e);break}}try{u=it.call(this,f)}catch(e){return Promise.reject(e)}for(d=0,l=c.length;d<l;)u=u.then(c[d++],c[d++]);return u}getUri(e){return le(ke((e=Ie(this.defaults,e)).baseURL,e.url),e.params,e.paramsSerializer)}}G.forEach(["delete","get","head","options"],(function(e){dt.prototype[e]=function(t,n){return this.request(Ie(n||{},{method:e,url:t,data:(n||{}).data}))}})),G.forEach(["post","put","patch"],(function(e){function t(t){return function(n,r,o){return this.request(Ie(o||{},{method:e,headers:t?{"Content-Type":"multipart/form-data"}:{},url:n,data:r}))}}dt.prototype[e]=t(),dt.prototype[e+"Form"]=t(!0)}));const ft=dt;class ht{constructor(e){if("function"!=typeof e)throw new TypeError("executor must be a function.");let t;this.promise=new Promise((function(e){t=e}));const n=this;this.promise.then((e=>{if(!n._listeners)return;let t=n._listeners.length;for(;t-- >0;)n._listeners[t](e);n._listeners=null})),this.promise.then=e=>{let t;const r=new Promise((e=>{n.subscribe(e),t=e})).then(e);return r.cancel=function(){n.unsubscribe(t)},r},e((function(e,r,o){n.reason||(n.reason=new Pe(e,r,o),t(n.reason))}))}throwIfRequested(){if(this.reason)throw this.reason}subscribe(e){this.reason?e(this.reason):this._listeners?this._listeners.push(e):this._listeners=[e]}unsubscribe(e){if(!this._listeners)return;const t=this._listeners.indexOf(e);-1!==t&&this._listeners.splice(t,1)}static source(){let e;return{token:new ht((function(t){e=t})),cancel:e}}}const pt=ht,mt={Continue:100,SwitchingProtocols:101,Processing:102,EarlyHints:103,Ok:200,Created:201,Accepted:202,NonAuthoritativeInformation:203,NoContent:204,ResetContent:205,PartialContent:206,MultiStatus:207,AlreadyReported:208,ImUsed:226,MultipleChoices:300,MovedPermanently:301,Found:302,SeeOther:303,NotModified:304,UseProxy:305,Unused:306,TemporaryRedirect:307,PermanentRedirect:308,BadRequest:400,Unauthorized:401,PaymentRequired:402,Forbidden:403,NotFound:404,MethodNotAllowed:405,NotAcceptable:406,ProxyAuthenticationRequired:407,RequestTimeout:408,Conflict:409,Gone:410,LengthRequired:411,PreconditionFailed:412,PayloadTooLarge:413,UriTooLong:414,UnsupportedMediaType:415,RangeNotSatisfiable:416,ExpectationFailed:417,ImATeapot:418,MisdirectedRequest:421,UnprocessableEntity:422,Locked:423,FailedDependency:424,TooEarly:425,UpgradeRequired:426,PreconditionRequired:428,TooManyRequests:429,RequestHeaderFieldsTooLarge:431,UnavailableForLegalReasons:451,InternalServerError:500,NotImplemented:501,BadGateway:502,ServiceUnavailable:503,GatewayTimeout:504,HttpVersionNotSupported:505,VariantAlsoNegotiates:506,InsufficientStorage:507,LoopDetected:508,NotExtended:510,NetworkAuthenticationRequired:511};Object.entries(mt).forEach((([e,t])=>{mt[t]=e}));const bt=mt,yt=function e(t){const n=new ft(t),r=l(ft.prototype.request,n);return G.extend(r,ft.prototype,n,{allOwnKeys:!0}),G.extend(r,n,null,{allOwnKeys:!0}),r.create=function(n){return e(Ie(t,n))},r}(Re);yt.Axios=ft,yt.CanceledError=Pe,yt.CancelToken=pt,yt.isCancel=Fe,yt.VERSION="1.7.2",yt.toFormData=oe,yt.AxiosError=Y,yt.Cancel=yt.CanceledError,yt.all=function(e){return Promise.all(e)},yt.spread=function(e){return function(t){return e.apply(null,t)}},yt.isAxiosError=function(e){return G.isObject(e)&&!0===e.isAxiosError},yt.mergeConfig=Ie,yt.AxiosHeaders=Ae,yt.formToJSON=e=>Ee(G.isHTMLForm(e)?new FormData(e):e),yt.getAdapter=ot,yt.HttpStatusCode=bt,yt.default=yt;const gt=yt,wt=(window.wp.notices,window.wp.apiFetch,window.wp.data,window.React),Et=()=>{const[e,t]=(0,o.useState)(!1),{museus:n,setMuseus:r,museuSelecionado:l,setMuseuSelecionado:d,fetchMuseusFromMuseusBRDebounced:f,prepareItemToCreateInstituicao:h,isFetchingMuseus:p,isCreatingInstituicao:m}=(()=>{const[e,t]=(0,o.useState)(null),[n,r]=(0,o.useState)([]),[s,i]=(0,o.useState)(!1),[a,c]=(0,o.useState)(!1),u=e=>{i(!0),gt("https://cadastro.museus.gov.br/wp-json/tainacan/v2/collection/208/items/?perpage=5&paged=1&fetch_only=thumbnail,document,author_name,title,description&search="+e).then((e=>{r(e.data.items?e.data.items.map((e=>({value:e.id,label:e.title,description:e.description,author:e.author_name,thumbnail:e.thumbnail&&e.thumbnail.thumbnail&&e.thumbnail.thumbnail[0]?e.thumbnail.thumbnail[0]:null,document:e.document}))):[]),i(!1)})).catch((e=>{i(!1)}))},l=(0,wt.useCallback)(_.debounce(u,600),[]),d=(e,t,n)=>{const r=cne_museusbr_fetcher.instituicoes_collection_id?cne_museusbr_fetcher.instituicoes_collection_id:14;gt.post(cne_museusbr_fetcher.ajax_url,{item:e,itemDocumentURL:n,itemMetadata:t},{params:{_ajax_nonce:cne_museusbr_fetcher.nonce,action:"create_instituicao"}}).then((e=>{e.data.success&&e.data.data.itemId&&window.location.replace("/wp-admin/?page=tainacan_admin#/collections/"+r+"/items/"+e.data.data.itemId+"/edit"),c(!1)})).catch((e=>{c(!1)}))};return{museus:n,setMuseus:r,museuSelecionado:e,setMuseuSelecionado:t,fetchMuseusFromMuseusBR:u,fetchMuseusFromMuseusBRDebounced:l,createInstituicaoFromMuseu:d,prepareItemToCreateInstituicao:()=>{const t="https://cadastro.museus.gov.br/wp-json/tainacan/v2/item/"+e.value+"/metadata";c(!0),gt.get(t).then((t=>{const n=t.data.map((e=>{if("Tainacan\\Metadata_Types\\Compound"===e.metadatum.metadata_type)return{metadatumId:e.metadatum.id,metadatumValue:e.value.map((e=>({metadatumId:e.metadatum_id,metadatumValue:e.value})))};if("Tainacan\\Metadata_Types\\Taxonomy"===e.metadatum.metadata_type){let t=e.value;return Array.isArray(t)?t=t.map((e=>e.name?e.name:e)):t.name&&(t=t.name),{metadatumId:e.metadatum.id,metadatumValue:t}}return{metadatumId:e.metadatum.id,metadatumValue:e.value}}));e.document&&!isNaN(e.document)?gt.get("https://cadastro.museus.gov.br/wp-json/wp/v2/media/"+e.document).then((t=>{d(e,n,t.data.source_url?t.data.source_url:"")})).catch((t=>{d(e,n,"")})):d(e,n,"")})).catch((e=>{c(!1)}))},isFetchingMuseus:s,setIsFetchingMuseus:i,isCreatingInstituicao:a,setIsCreatingInstituicao:c}})();return(0,i.jsxs)(i.Fragment,{children:[(0,i.jsx)(s.Button,{size:"compact",__next40pxDefaultSize:!0,variant:"primary",onClick:()=>t(!0),children:"Importar instituição do MuseusBR"}),e&&(0,i.jsx)(s.Modal,{title:"Crie uma instituição a partir de dados existentes do MuseusBR",icon:(0,i.jsx)(s.Icon,{icon:"bank"}),onRequestClose:()=>t(!1),size:"large",style:{minHeight:"320px"},children:(0,i.jsxs)(s.Flex,{gap:6,align:"top",children:[(0,i.jsx)(s.FlexBlock,{children:(0,i.jsx)(c,{museuSelecionado:l,setMuseuSelecionado:e=>d(e),museus:n,setMuseus:r,fetchMuseus:_.debounce((e=>{f(e)}),300)})}),(0,i.jsx)(s.FlexItem,{children:p?(0,i.jsx)(s.Spinner,{}):(0,i.jsx)("span",{style:{width:"45px",display:"block"}})}),(0,i.jsx)(s.FlexBlock,{children:l&&(0,i.jsxs)(i.Fragment,{children:[(0,i.jsx)(a,{item:l}),(0,i.jsx)("br",{}),(0,i.jsx)(u,{isCreatingInstituicao:m,onClick:()=>h()})]})})]})})]})},St=()=>(0,i.jsx)(Et,{});r()((()=>{const e=document.createElement("span");e.classList.add("museusbr-fetcher-button-container");const t=document.getElementsByClassName("wp-header-end")[0];t.parentNode.insertBefore(e,t),(0,o.createRoot)(e).render((0,i.jsx)(St,{}))}))})();