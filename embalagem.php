<script type="text/javascript" charset="UTF-8"></script>
<script type="text/javascript" src="./js/BrowserPrint-3.0.216.min.js"></script>
<?php

session_start();

if((!isset ($_SESSION['user']) == true) and (!isset ($_SESSION['pass']) == true))
{
  unset($_SESSION['user']);
  unset($_SESSION['pass']);
  header('location:index.php');
  }

//$logged = $_SESSION['name'];

include 'menu.php';
require_once 'db_connect.php';

$query = "SELECT cod_cliente, razao_social FROM cd_clientes";
mysqli_set_charset($connect,"utf8");
$resultQuery = mysqli_query($connect, $query);

/* $queryAparelhos = "SELECT cod, modelo FROM db_sgr.cd_aparelhos";
$resultqueryAparelhos = mysqli_query($connect, $queryAparelhos); */

?>

<script src="./js/embalagem.js"></script>

<div class="alert alert-danger text-center" id="errosmartcard">
    <strong>INFORME Sim ou Não na opção SMART CARD.</strong>
</div>

<div class="alert alert-danger text-center" id="errocliente">
    <strong>CLIENTE NÃO POSSUI EQUIPAMENTO A SER EMBALADO.</strong>
</div>

<div class="alert alert-success text-center" id="embalagemOK">
    <strong>EMBALAGEM REALIZADA.</strong>
</div>

<!-- <script type="text/javascript">(window.NREUM||(NREUM={})).loader_config={licenseKey:"aece2c08f5",applicationID:"22912202"};window.NREUM||(NREUM={}),__nr_require=function(e,t,n){function r(n){if(!t[n]){var i=t[n]={exports:{}};e[n][0].call(i.exports,function(t){var i=e[n][1][t];return r(i||t)},i,i.exports)}return t[n].exports}if("function"==typeof __nr_require)return __nr_require;for(var i=0;i<n.length;i++)r(n[i]);return r}({1:[function(e,t,n){function r(){}function i(e,t,n){return function(){return o(e,[u.now()].concat(c(arguments)),t?null:this,n),t?void 0:this}}var o=e("handle"),a=e(7),c=e(8),f=e("ee").get("tracer"),u=e("loader"),s=NREUM;"undefined"==typeof window.newrelic&&(newrelic=s);var d=["setPageViewName","setCustomAttribute","setErrorHandler","finished","addToTrace","inlineHit","addRelease"],p="api-",l=p+"ixn-";a(d,function(e,t){s[t]=i(p+t,!0,"api")}),s.addPageAction=i(p+"addPageAction",!0),s.setCurrentRouteName=i(p+"routeName",!0),t.exports=newrelic,s.interaction=function(){return(new r).get()};var m=r.prototype={createTracer:function(e,t){var n={},r=this,i="function"==typeof t;return o(l+"tracer",[u.now(),e,n],r),function(){if(f.emit((i?"":"no-")+"fn-start",[u.now(),r,i],n),i)try{return t.apply(this,arguments)}catch(e){throw f.emit("fn-err",[arguments,this,e],n),e}finally{f.emit("fn-end",[u.now()],n)}}}};a("actionText,setName,setAttribute,save,ignore,onEnd,getContext,end,get".split(","),function(e,t){m[t]=i(l+t)}),newrelic.noticeError=function(e,t){"string"==typeof e&&(e=new Error(e)),o("err",[e,u.now(),!1,t])}},{}],2:[function(e,t,n){function r(){return c.exists&&performance.now?Math.round(performance.now()):(o=Math.max((new Date).getTime(),o))-a}function i(){return o}var o=(new Date).getTime(),a=o,c=e(9);t.exports=r,t.exports.offset=a,t.exports.getLastTimestamp=i},{}],3:[function(e,t,n){function r(e){return!(!e||!e.protocol||"file:"===e.protocol)}t.exports=r},{}],4:[function(e,t,n){function r(e,t){var n=e.getEntries();n.forEach(function(e){"first-paint"===e.name?d("timing",["fp",Math.floor(e.startTime)]):"first-contentful-paint"===e.name&&d("timing",["fcp",Math.floor(e.startTime)])})}function i(e,t){var n=e.getEntries();n.length>0&&d("lcp",[n[n.length-1]])}function o(e){e.getEntries().forEach(function(e){e.hadRecentInput||d("cls",[e])})}function a(e){if(e instanceof m&&!g){var t=Math.round(e.timeStamp),n={type:e.type};t<=p.now()?n.fid=p.now()-t:t>p.offset&&t<=Date.now()?(t-=p.offset,n.fid=p.now()-t):t=p.now(),g=!0,d("timing",["fi",t,n])}}function c(e){d("pageHide",[p.now(),e])}if(!("init"in NREUM&&"page_view_timing"in NREUM.init&&"enabled"in NREUM.init.page_view_timing&&NREUM.init.page_view_timing.enabled===!1)){var f,u,s,d=e("handle"),p=e("loader"),l=e(6),m=NREUM.o.EV;if("PerformanceObserver"in window&&"function"==typeof window.PerformanceObserver){f=new PerformanceObserver(r);try{f.observe({entryTypes:["paint"]})}catch(v){}u=new PerformanceObserver(i);try{u.observe({entryTypes:["largest-contentful-paint"]})}catch(v){}s=new PerformanceObserver(o);try{s.observe({type:"layout-shift",buffered:!0})}catch(v){}}if("addEventListener"in document){var g=!1,w=["click","keydown","mousedown","pointerdown","touchstart"];w.forEach(function(e){document.addEventListener(e,a,!1)})}l(c)}},{}],5:[function(e,t,n){function r(e,t){if(!i)return!1;if(e!==i)return!1;if(!t)return!0;if(!o)return!1;for(var n=o.split("."),r=t.split("."),a=0;a<r.length;a++)if(r[a]!==n[a])return!1;return!0}var i=null,o=null,a=/Version\/(\S+)\s+Safari/;if(navigator.userAgent){var c=navigator.userAgent,f=c.match(a);f&&c.indexOf("Chrome")===-1&&c.indexOf("Chromium")===-1&&(i="Safari",o=f[1])}t.exports={agent:i,version:o,match:r}},{}],6:[function(e,t,n){function r(e){function t(){e(a&&document[a]?document[a]:document[i]?"hidden":"visible")}"addEventListener"in document&&o&&document.addEventListener(o,t,!1)}t.exports=r;var i,o,a;"undefined"!=typeof document.hidden?(i="hidden",o="visibilitychange",a="visibilityState"):"undefined"!=typeof document.msHidden?(i="msHidden",o="msvisibilitychange"):"undefined"!=typeof document.webkitHidden&&(i="webkitHidden",o="webkitvisibilitychange",a="webkitVisibilityState")},{}],7:[function(e,t,n){function r(e,t){var n=[],r="",o=0;for(r in e)i.call(e,r)&&(n[o]=t(r,e[r]),o+=1);return n}var i=Object.prototype.hasOwnProperty;t.exports=r},{}],8:[function(e,t,n){function r(e,t,n){t||(t=0),"undefined"==typeof n&&(n=e?e.length:0);for(var r=-1,i=n-t||0,o=Array(i<0?0:i);++r<i;)o[r]=e[t+r];return o}t.exports=r},{}],9:[function(e,t,n){t.exports={exists:"undefined"!=typeof window.performance&&window.performance.timing&&"undefined"!=typeof window.performance.timing.navigationStart}},{}],ee:[function(e,t,n){function r(){}function i(e){function t(e){return e&&e instanceof r?e:e?u(e,f,a):a()}function n(n,r,i,o,a){if(a!==!1&&(a=!0),!l.aborted||o){e&&a&&e(n,r,i);for(var c=t(i),f=v(n),u=f.length,s=0;s<u;s++)f[s].apply(c,r);var p=d[h[n]];return p&&p.push([b,n,r,c]),c}}function o(e,t){y[e]=v(e).concat(t)}function m(e,t){var n=y[e];if(n)for(var r=0;r<n.length;r++)n[r]===t&&n.splice(r,1)}function v(e){return y[e]||[]}function g(e){return p[e]=p[e]||i(n)}function w(e,t){s(e,function(e,n){t=t||"feature",h[n]=t,t in d||(d[t]=[])})}var y={},h={},b={on:o,addEventListener:o,removeEventListener:m,emit:n,get:g,listeners:v,context:t,buffer:w,abort:c,aborted:!1};return b}function o(e){return u(e,f,a)}function a(){return new r}function c(){(d.api||d.feature)&&(l.aborted=!0,d=l.backlog={})}var f="nr@context",u=e("gos"),s=e(7),d={},p={},l=t.exports=i();t.exports.getOrSetContext=o,l.backlog=d},{}],gos:[function(e,t,n){function r(e,t,n){if(i.call(e,t))return e[t];var r=n();if(Object.defineProperty&&Object.keys)try{return Object.defineProperty(e,t,{value:r,writable:!0,enumerable:!1}),r}catch(o){}return e[t]=r,r}var i=Object.prototype.hasOwnProperty;t.exports=r},{}],handle:[function(e,t,n){function r(e,t,n,r){i.buffer([e],r),i.emit(e,t,n)}var i=e("ee").get("handle");t.exports=r,r.ee=i},{}],id:[function(e,t,n){function r(e){var t=typeof e;return!e||"object"!==t&&"function"!==t?-1:e===window?0:a(e,o,function(){return i++})}var i=1,o="nr@id",a=e("gos");t.exports=r},{}],loader:[function(e,t,n){function r(){if(!E++){var e=x.info=NREUM.info,t=l.getElementsByTagName("script")[0];if(setTimeout(u.abort,3e4),!(e&&e.licenseKey&&e.applicationID&&t))return u.abort();f(h,function(t,n){e[t]||(e[t]=n)});var n=a();c("mark",["onload",n+x.offset],null,"api"),c("timing",["load",n]);var r=l.createElement("script");r.src="https://"+e.agent,t.parentNode.insertBefore(r,t)}}function i(){"complete"===l.readyState&&o()}function o(){c("mark",["domContent",a()+x.offset],null,"api")}var a=e(2),c=e("handle"),f=e(7),u=e("ee"),s=e(5),d=e(3),p=window,l=p.document,m="addEventListener",v="attachEvent",g=p.XMLHttpRequest,w=g&&g.prototype;if(d(p.location)){NREUM.o={ST:setTimeout,SI:p.setImmediate,CT:clearTimeout,XHR:g,REQ:p.Request,EV:p.Event,PR:p.Promise,MO:p.MutationObserver};var y=""+location,h={beacon:"bam.nr-data.net",errorBeacon:"bam.nr-data.net",agent:"js-agent.newrelic.com/nr-1208.min.js"},b=g&&w&&w[m]&&!/CriOS/.test(navigator.userAgent),x=t.exports={offset:a.getLastTimestamp(),now:a,origin:y,features:{},xhrWrappable:b,userAgent:s};e(1),e(4),l[m]?(l[m]("DOMContentLoaded",o,!1),p[m]("load",r,!1)):(l[v]("onreadystatechange",i),p[v]("onload",r)),c("mark",["firstbyte",a.getLastTimestamp()],null,"api");var E=0}},{}],"wrap-function":[function(e,t,n){function r(e,t){function n(t,n,r,f,u){function nrWrapper(){var o,a,s,p;try{a=this,o=d(arguments),s="function"==typeof r?r(o,a):r||{}}catch(l){i([l,"",[o,a,f],s],e)}c(n+"start",[o,a,f],s,u);try{return p=t.apply(a,o)}catch(m){throw c(n+"err",[o,a,m],s,u),m}finally{c(n+"end",[o,a,p],s,u)}}return a(t)?t:(n||(n=""),nrWrapper[p]=t,o(t,nrWrapper,e),nrWrapper)}function r(e,t,r,i,o){r||(r="");var c,f,u,s="-"===r.charAt(0);for(u=0;u<t.length;u++)f=t[u],c=e[f],a(c)||(e[f]=n(c,s?f+r:r,i,f,o))}function c(n,r,o,a){if(!m||t){var c=m;m=!0;try{e.emit(n,r,o,t,a)}catch(f){i([f,n,r,o],e)}m=c}}return e||(e=s),n.inPlace=r,n.flag=p,n}function i(e,t){t||(t=s);try{t.emit("internal-error",e)}catch(n){}}function o(e,t,n){if(Object.defineProperty&&Object.keys)try{var r=Object.keys(e);return r.forEach(function(n){Object.defineProperty(t,n,{get:function(){return e[n]},set:function(t){return e[n]=t,t}})}),t}catch(o){i([o],n)}for(var a in e)l.call(e,a)&&(t[a]=e[a]);return t}function a(e){return!(e&&e instanceof Function&&e.apply&&!e[p])}function c(e,t){var n=t(e);return n[p]=e,o(e,n,s),n}function f(e,t,n){var r=e[t];e[t]=c(r,n)}function u(){for(var e=arguments.length,t=new Array(e),n=0;n<e;++n)t[n]=arguments[n];return t}var s=e("ee"),d=e(8),p="nr@original",l=Object.prototype.hasOwnProperty,m=!1;t.exports=r,t.exports.wrapFunction=c,t.exports.wrapInPlace=f,t.exports.argsToArray=u},{}]},{},["loader"]);</script><body> -->

    <div class="container-fluid mt-5 ml-4">
        <div class="row">
            <div class="col-sm-3">

            <!-- <div id="caixa"></div> -->
            <!-- style='display: block' -->
                <!-- none -->
                <div class="form-group mt-4">
                    <label>Cliente</label>
                    <select id="cliente" class="form-control">
                        <option value = "0" disabled selected>Digite o código ou Selecione...</option>
                        <?php while ($row = mysqli_fetch_assoc($resultQuery)) { ?>
                            <option><?php echo $row["cod_cliente"] . " - " . $row["razao_social"] ?></option>
                        <?php }
                        mysqli_close($connect);
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Modelo</label>
                    <select id="modelo" class="form-control">
                        <option value = "0" disabled selected>Digite o código ou Selecione...</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Quant. na caixa</label>
                    <input class="form-control col-sm-3" id="quant" maxlength="3">
                </div>
                <div class="form-group">
                    <label>Smart Card</label>
                    <div >
                        <input type="radio" name="radio" id="radio_s"><label class="ml-2">Sim</label></input>
                        <input type="radio" name="radio" id="radio_n" class="ml-3"><label class="ml-2">Não</label></input>
                    </div>
                </div>
                <button id="criar_caixa" class="btn btn-primary" type="button">Criar caixa</button>
            </div>

            <div class="ml-1 col-sm-3">
                <strong id = "serial1" hidden>Serial 1:</strong> 
                <div class="d-flex flex-row-reverse mt-5">
                    <button id="btn_imp_etiquetas" class="btn btn-primary" type="button" data-toggle="tooltip" data-placement="bottom" title="Uma etiqueta p cada equipamento" hidden>Imp. Etiquetas</button>
                </div>
            </div>
            

            <div class="ml-2 col-sm-3">
                <strong id = "serial2" hidden>Serial 2:</strong>
                <div class="d-flex flex-row-reverse mt-5 justify-content-between">
                    <button id="finalizar" class="btn btn-primary" type="button" data-toggle="tooltip" data-placement="bottom" title="Gera um nº de caixa" hidden>Finalizar</button>
                    <button id="btn_imp_etiqueta_caixa" class="btn btn-primary" type="button" data-toggle="tooltip" data-placement="bottom" title="Etiqueta com Modelo e quantidade de equipamentos" hidden>Imp. Etiqueta da Caixa</button>
                </div>
            </div>

            <div class="col-sm-2">
                <strong id = "smartcard" hidden>Smart Card:</strong>
            </div>

        </div>

<!-- <script type="text/javascript">window.NREUM||(NREUM={});NREUM.info={"beacon":"bam-cell.nr-data.net","licenseKey":"aece2c08f5","applicationID":"22912202","transactionName":"ZgMBMkBYDRcCARVQC19JNhRbFgoKBwcZFxRZFg==","queueTime":0,"applicationTime":231,"atts":"SkQCRAhCHhk=","errorBeacon":"bam-cell.nr-data.net","agent":""}</script></body> -->

</html>

<div class="modal fade" id="ModalSerialDuplicado" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><strong>NÃO</strong> continue</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Existe serial duplicado!</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <!-- <button type="button" class="btn btn-primary">Salvar mudanças</button> -->
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="ModalSerialInvalido" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><strong>ERRO !</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Existe serial inválido! Verifique.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <!-- <button type="button" class="btn btn-primary">Salvar mudanças</button> -->
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="ModalSerial2" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><strong>Tente novamente !</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Existe "Serial 2" vazio! Verifique.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <!-- <button type="button" class="btn btn-primary">Salvar mudanças</button> -->
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="ModalSmartCard" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><strong>ERRO Smart Card !</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Existe Smart Card não preenchido! Verifique.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <!-- <button type="button" class="btn btn-primary">Salvar mudanças</button> -->
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="ModalFinalizar" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><strong>Atenção ⚠️</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><strong>CONFIRMA QUE JÁ IMPRIMIU TODAS AS ETIQUETAS ?</strong></p>
      </div>
      <div class="modal-footer">
        <button type="button" id="btn_ModalNao" class="btn btn-secondary" data-dismiss="modal">Não</button>
        <button type="button" id="btn_Confirmo" class="btn btn-primary">Confirmo</button>
        <!-- <button type="button" class="btn btn-primary">Salvar mudanças</button> -->
      </div>
    </div>
  </div>
</div>