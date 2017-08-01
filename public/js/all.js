var config;
maxsize = 5;
$.ajaxSetup({'async': false});
$.getJSON('main.json', function(data) {
      config = data;

});
maxsize = config.stars;

mainy = new Array();
var x = new Array();


if  ((document.getElementById) && 
window.addEventListener || window.attachEvent){

(function(){
	  

var dx=new Array();
var dy=new Array();

/*for(var x1=0;x1<maxsize;x1++)
{
	dx[x1]=x1*10+10;
	dy[x1]=x1*10+100;
	//console.log(dy[x1]);
}
*/
var rm_img = new Image();
rm_img.src = "images/p2.png"; 

var imgh = 163;  
var imgw = 156; 
var timer = 30; //setTimeout speed.
var min = 1;    //slowest speed.
var max = 5;    //fastest speed.

var idx = 0;

idx = parseInt(document.images.length);
if (document.getElementById("pic"+idx)) idx++;

var particles = new Array();
for(var j=0;j<maxsize;j++)
{
if(j%2==0)
	rm_img.src = "images/p2.png";
else
	rm_img.src = "images/p1.png";
particles[j]= "<div id='pic"+j+"' style='position:absolute;"
+"top:2px;left:2px;z-index:2;height:"+imgh+"px;width:"+imgw+"px;"
+"overflow:hidden'><img src='"+rm_img.src+"' width="+(j+3)+" alt=''/><\/div>";
}
var i;
for(i=0;i<maxsize;i++)
{
var name=particles[i];
document.write(name);
}

var h,w,r;
var temp=new Array();

var d = document;


for(var x1=0;x1<maxsize;x1++)
{
	x[x1]=Math.floor((Math.random()*1000)+1);;
	mainy[x1]=Math.floor((Math.random()*1000)+1);;
	
}

//var dir = 45;   //direction.
var dir=new Array();
for(var c1=0;c1<maxsize;c1++)
{
	dir[c1] = 45; 
}
//var acc = 1;    //acceleration.
var acc=new Array();
for(var c1=0;c1<maxsize;c1++)
{
	acc[c1] = 1; 
}
var newacc = new Array(1,0,1);
//var vel = 1;    //initial speed.
var vel=new Array();
for(var c1=0;c1<maxsize;c1++)
{
	vel[c1] = 1; 
}
//var sev = 0;

var sev=new Array();
for(var c1=0;c1<maxsize;c1++)
{
	sev[c1] = 0; 
}
var newsev = new Array(1,-1,2,-2,0,0,1,-1,2,-2);

//counters.
//var cc1 = 0;    //time between changes.
var cc1=new Array();
for(var c1=0;c1<maxsize;c1++)
{
	cc1[c1] = 0; 
}
//var cc2 = 0;    //new time between changes.

var cc2=new Array();
for(var c1=0;c1<maxsize;c1++)
{
	cc2[c1] = 0; 
}
var pix = "px";
var domWw = (typeof window.innerWidth == "number");
var domSy = (typeof window.pageYOffset == "number");

if (domWw) r = window;
else{ 
  if (d.documentElement && 
  typeof d.documentElement.clientWidth == "number" && 
  d.documentElement.clientWidth != 0)
  r = d.documentElement;
 else{ 
  if (d.body && 
  typeof d.body.clientWidth == "number")
  r = d.body;
 }
}



function winsize(){
var oh,sy,ow,sx,rh,rw;
if (domWw){
  if (d.documentElement && d.defaultView && 
  typeof d.defaultView.scrollMaxY == "number"){
  oh = d.documentElement.offsetHeight;
  sy = d.defaultView.scrollMaxY;
  ow = d.documentElement.offsetWidth;
  sx = d.defaultView.scrollMaxX;
  rh = oh-sy;
  rw = ow-sx;
 }
 else{
  rh = r.innerHeight;
  rw = r.innerWidth;
 }
h = rh - 34; 
w = rw - 34;
}
else{
h = r.clientHeight - imgh; 
w = r.clientWidth - imgw;
}
}


function newpath(c1){

sev[c1] = newsev[Math.floor(Math.random()*newsev.length)];
acc[c1] = newacc[Math.floor(Math.random()*newacc.length)];
cc2[c1] = Math.floor(20+Math.random()*50);
}


function moveit(){
//var vb,hb,curr;
var curr=new Array();
var vb=new Array();
var hb=new Array();

for(var c1=0;c1<maxsize;c1++)
{

if (acc[c1] == 1) vel[c1] +=0.05;
if (acc[c1] == 0) vel[c1] -=0.05;
if (vel[c1] >= max) vel[c1] = max;
if (vel[c1] <= min) vel[c1] = min;
cc1[c1]++;

if (cc1[c1] >= cc2[c1]){
 newpath(c1);
 cc1[c1]=0;
}
}
for(var c1=0;c1<maxsize;c1++)
{
curr[c1] = dir[c1]+=sev[c1];
}
for(var c1=0;c1<maxsize;c1++)
{
//commented to remove
dy[c1] = vel[c1] * Math.sin(curr[c1]*Math.PI/180);
dx[c1] = vel[c1] * Math.cos(curr[c1]*Math.PI/180);
}
for(var c1=0;c1<maxsize;c1++)
{
//console.log(dy[c1]);
mainy[c1]+=dy[c1];
//console.log(dy[c1]+" "+c1);
x[c1]+=dx[c1];
}
//horizontal-vertical bounce.
for(var c1=0;c1<maxsize;c1++)
{
vb[c1] = 180-dir[c1];
hb[c1] = 0-dir[c1];
}
//Corner rebounds?
for(var c1=0;c1<maxsize;c1++)
{

if ((mainy[c1] <= 1) && (x[c1] <= 1)){mainy[c1] = 1; x[c1] = 1; dir[c1] = 45;}
if ((mainy[c1] <= 1) && (x[c1] >= w)){mainy[c1] = 1; x[c1] = w; dir[c1] = 135;}
if ((mainy[c1] >= h) && (x[c1] <= 1)){mainy[c1] = h; x[c1] = 1; dir[c1] = 315;}
if ((mainy[c1] >= h) && (x[c1] >=w)){mainy[c1] = h; x[c1] = w; dir[c1] = 225;}
//edge rebounds.
//console.log(mainy);
if (mainy[c1] <= 1) {mainy[c1] = 1; dir[c1] = hb[c1];}  
if (mainy[c1] >= h) {mainy[c1] = h; dir[c1] = hb[c1];}  
if (x[c1] <= 1) {x[c1] = 1; dir[c1] = vb[c1];} 
if (x[c1] >= w) {x[c1] = w; dir[c1] = vb[c1];} 
}
//Assign it all to image.
for(var c1=0;c1<maxsize;c1++)
{

temp[c1].style.top = mainy[c1] + pix;
//console.log(dy[c1]);
temp[c1].style.left = x[c1] + pix;
}
//Console.write(y);
setTimeout(moveit,timer);
}

function init(){



for(var x1=0;x1<maxsize;x1++)
{
	temp[x1]= document.getElementById("pic"+x1);
}

winsize();
moveit();
}


if (window.addEventListener){
 window.addEventListener("resize",winsize,false);
 window.addEventListener("load",init,false);
}  
else if (window.attachEvent){
 window.attachEvent("onresize",winsize);
 window.attachEvent("onload",init);
} 

})();
}//End.
 // });
 
