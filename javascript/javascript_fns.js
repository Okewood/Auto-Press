<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_nbGroup(event, grpName) { //v6.0
  var i,img,nbArr,args=MM_nbGroup.arguments;
  if (event == "init" && args.length > 2) {
    if ((img = MM_findObj(args[2])) != null && !img.MM_init) {
      img.MM_init = true; img.MM_up = args[3]; img.MM_dn = img.src;
      if ((nbArr = document[grpName]) == null) nbArr = document[grpName] = new Array();
      nbArr[nbArr.length] = img;
      for (i=4; i < args.length-1; i+=2) if ((img = MM_findObj(args[i])) != null) {
        if (!img.MM_up) img.MM_up = img.src;
        img.src = img.MM_dn = args[i+1];
        nbArr[nbArr.length] = img;
    } }
  } else if (event == "over") {
    document.MM_nbOver = nbArr = new Array();
    for (i=1; i < args.length-1; i+=3) if ((img = MM_findObj(args[i])) != null) {
      if (!img.MM_up) img.MM_up = img.src;
      img.src = (img.MM_dn && args[i+2]) ? args[i+2] : ((args[i+1])? args[i+1] : img.MM_up);
      nbArr[nbArr.length] = img;
    }
  } else if (event == "out" ) {
    for (i=0; i < document.MM_nbOver.length; i++) {
      img = document.MM_nbOver[i]; img.src = (img.MM_dn) ? img.MM_dn : img.MM_up; }
  } else if (event == "down") {
    nbArr = document[grpName];
    if (nbArr)
      for (i=0; i < nbArr.length; i++) { img=nbArr[i]; img.src = img.MM_up; img.MM_dn = 0; }
    document[grpName] = nbArr = new Array();
    for (i=2; i < args.length-1; i+=2) if ((img = MM_findObj(args[i])) != null) {
      if (!img.MM_up) img.MM_up = img.src;
      img.src = img.MM_dn = (args[i+1])? args[i+1] : img.MM_up;
      nbArr[nbArr.length] = img;
  } }
}

function flvFTSS4(){//v1.02
this.style.filter="";}

function flvFTSS3(){//v1.02
var v1=arguments,v2=v1[0],v3=MM_findObj(v2);if (v3&&v3.TSS2!=null){clearTimeout(v3.TSS2);}}

function flvFTSS2(){//v1.02
var v1=arguments,v2=v1[0],v3=MM_findObj(v2),v4=v1[1],v5=v1[2],v6,v7,v8,v9,v10,v11,v12=document;if (v3&&v3.TSS7){flvFTSS3(v2);v9="flvFTSS2('"+v2+"',"+v4+","+v5+")";if (v4==1){if (!v3.TSS5.complete){v3.TSS2=setTimeout(v9,50);return;}v6=v3.TSS9+1;if (v6>v3.TSS7.length-1){if (v3.TSS10==0){return;}else {v6=0;}}else if (v6+1<v3.TSS7.length){v3.TSS5.src=v3.TSS7[v6+1][0];}}else {if (!v3.TSS3.complete){v3.TSS2=setTimeout(v9,50);return;}v6=v3.TSS9-1;if (v6<0){if (v3.TSS10==0){return;}else {v6=v3.TSS7.length-1;}}else if (v6-1>0){v3.TSS3.src=v3.TSS7[v6-1][0];}}v3.TSS9=v6;v10=v3.TSS7[v6][0];v11=v3.TSS7[v6][1];v7=(v3.filters&&!v12.TSS6&&v11<25);if (v7){if (v3.filters[0]&&v3.filters[0].status==2){v3.filters[0].Stop();}if (v11==0){v8="blendTrans(Duration="+v3.TSS8+")";}else {v8="revealTrans(Duration="+v3.TSS8+",Transition="+(v11-1)+")";}v3.style.filter=v8;v3.onfilterchange=flvFTSS4;v3.filters[0].Apply();}v3.src=v10;if (v7){v3.filters[0].Play();}if (v5==1){v3.TSS2=setTimeout(v9,v3.TSS4);}}}

function flvFTSS1(){//v1.02
// Copyright 2003, Marja Ribbers-de Vroed, FlevOOware (www.TSS1.nl/dreamweaver/)
var v1=arguments,v2=document,v3=v1[0],v4=MM_findObj(v3),v5,v6;if (v4){v2.TSS6=(navigator.userAgent.toLowerCase().indexOf("mac")!=-1);v4.TSS8=v1[1]/1000;v4.TSS4=v1[2]+v1[1];v6=v1[3];v4.TSS10=v1[4];v4.TSS7=new Array();for (var v7=5;v7<v1.length;v7+=2){v4.TSS7[v4.TSS7.length]=new Array(v1[v7],v1[v7+1]);}v4.TSS9=0;v4.TSS5=new Image();v4.TSS5.src=v1[7];v4.TSS3=new Image();v4.TSS3.src=v1[v1.length-2];if (v6==1){v5="flvFTSS2('"+v3+"',1,"+v6+")";v4.TSS2=setTimeout(v5,v4.TSS4);}}}

function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
function checkEnter(e){
	var characterCode;
	if(e && e.which) {
		e = e;
		characterCode = e.which;
	} else {
		e = event;
		characterCode = e.keyCode;
	}
	if(characterCode == 13 && document.getElementById('search_field').value!='') {
		document.form1.submit()
		return false;
	}
	return true;
}
function picturesearch() {
	var s = document.getElementById('search_field').value;
	s = s.replace(/\s\,\s/g,",");
	s = s.replace(/\,\s/g,",");
	if(document.form1.search_type[0].checked) {
		var t = 'inc';
	} else {
		var t = 'exc';
	}
	window.location='search_thumb.php?&search_field='+s+'&t='+t;
	return true;
}

//-->
