// JavaScript Document
//---------------------------------------------------	
function XMLHttp(){
var Object;
if (typeof XMLHttpRequest == "undefined" )
{
if(navigator.userAgent.indexOf("MSIE 5") >= 0)
{
Object= new ActiveXObject("Microsoft.XMLHTTP");
}
else{ 
Object=new ActiveXObject("Msxml2.XMLHTTP");
}}
else{ 
Object=new XMLHttpRequest();
}return Object;
}