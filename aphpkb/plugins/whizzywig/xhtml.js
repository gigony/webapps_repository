//Copyright © 2005-2007, John Goodman - john.goodman(at)unverse.net  *date 070107 v3
//Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
//The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
//THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE. 

var nlTag='|div|p|table|tbody|tr|td|th|title|script|comment|li|h1|h2|h3|h4|h5|h6|hr|ul|ol|option|select|'; 
var tagNl='|p|th|style|'; 
var regCmt=new RegExp(); 
regCmt.compile("^<!--(.*)-->$"); 
var regHyph=new RegExp(); 
regHyph.compile("-$"); 
function get_xhtml(node,ndNl,inPre){
 var i; 
 var tx=''; 
 var kids=node.childNodes; 
 var kidsL=kids.length; 
 var tagNm; 
 var doNl=ndNl?true:false; 
 var sz=["small","xx-small","x_small","small","medium","large","x-large","xx-large"];
 for(i=0; i<kidsL; i++){
  var kid=kids[i]; 
  switch(kid.nodeType){
   case 1:{
    var tagNm=String(kid.tagName).toLowerCase(); 
    if(tagNm=='')break; 
    if(tagNm=='font') { 
     if (kid.size) {kid.style.fontSize=sz[kid.size]; kid.removeAttribute('size');} 
     if (kid.face) {kid.style.fontFamily=kid.face; kid.removeAttribute('face');}
     if (kid.color) {kid.style.color=kid.color; kid.removeAttribute('color');}
     tagNm='span'; 
     }
    if(tagNm=='!'){
     var bits=regCmt.exec(kid.tx); 
     if(bits){
      var innerTx=bits[1]; 
      tx+=tidyCmt(innerTx); 
     }
    }else{
     if(nlTag.indexOf('|'+tagNm+'|')!=-1){
      if((doNl||tx!='')&&!inPre)tx+='\n'; 
      else doNl=true; 
     }
     tx+='<'+tagNm; 
     var attr=kid.attributes; 
     var atLn=attr.length; 
     var atVal; 
     var atLang=false; 
     var atXml=false; 
     var atXmlns=false; 
     var isAlt=false; 
     for(j=0; j<atLn; j++){
      var atNm=attr[j].nodeName.toLowerCase(); 
      if(!attr[j].specified&&(atNm!='selected'||!kid.selected)
         && (atNm!='style'||kid.style.cssText=='')
         && atNm!='value')
       continue; 
      if(atNm=='_moz_dirty'||atNm=='_moz_resizing'||tagNm=='br'&&atNm=='type'&&kid.getAttribute('type')=='_moz')
       continue; 
      var valid_attr=true;
      switch(atNm){
       case "color":atNm="style"; 
        tVal="color:"+kid.color+";";
        if (window.atVal){atVal+=tVal ;}else{atVal=tVal;}
        break;
       case "style":atVal=kid.style.cssText.toLowerCase(); 
        break; 
       case "class":atVal=kid.className; 
        break; 
       case "noshade":
       case "checked":
       case "selected":
       case "multiple":
       case "nowrap":
       case "disabled":atVal=atNm;
        break; 
       default:try{
        atVal=kid.getAttribute(atNm,2); 
       }catch(e){ valid_attr=false; }
      }
      if(valid_attr){
       if(!(tagNm=='li'&&atNm=='value')){
        tx+=' '+atNm+'="'+tidyAt(atVal)+'"';  
       }
      }
      if(atNm=='alt')isAlt=true; 
     }
     if(tagNm=='img'&&!isAlt) tx+=' alt=""';
    if(kid.canHaveChildren||kid.hasChildNodes()){
     tx+='>'; 
     if(tagNl.indexOf('|'+tagNm+'|')!=-1){}
     tx+=get_xhtml(kid,true,inPre||tagNm=='pre'?true:false); 
     tx+='</'+tagNm+'>'; 
    }else{ 
     if(tagNm=='style'||tagNm=='title'||tagNm=='script'){
      tx+='>';  
      var innerTx; 
      if(tagNm=='script'){
       innerTx=kid.tx; 
      }else innerTx=kid.innerHTML; 
      if(tagNm=='style'){
       innerTx=String(innerTx).replace(/[\n]+/g,'\n'); 
      }
      tx+=innerTx+'</'+tagNm+'>'; 
     }else{ tx+=' />'; }
    }
   }
   break; 
  }
  case 3:{
   if(!inPre){
    if(kid.nodeValue!='\n'){ tx+=tidyTxt(kid.nodeValue); }
   }
   else tx+=kid.nodeValue; 
   break; 
  }
  case 8:{
   tx+=tidyCmt(kid.nodeValue); 
   break; 
  }
  default: break; 
  }
 }
 return tx; 
}
function tidyCmt(tx){
 tx=tx.replace(/--/g,"__"); 
 if(regHyph.exec(tx)){
  tx+=" "; 
 }return "<!--"+tx+"-->"; 
}
function tidyTxt(tx){
 return String(tx).replace(/\n{2,}/g,"\n").replace(/\&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/\u00A0/g,"&nbsp;");
}
function tidyAt(tx){
 return String(tx).replace(/\&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/\"/g,"&quot;");
}
