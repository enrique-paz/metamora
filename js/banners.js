// JavaScript Document

function business(){
	 document.getElementById('banner').classList.remove('metamora-banners');
	 document.getElementById('banner').classList.add('metamora-business');
  }
  
  function cards(){
document.getElementById('banner').classList.remove('metamora-banners');
document.getElementById('banner').classList.remove('metamora-business');
	 document.getElementById('banner').classList.add('metamora-cards');
  }
  
  function metamora(){
document.getElementById('banner').classList.remove('metamora-cards');
document.getElementById('banner').classList.remove('metamora-business');
	 document.getElementById('banner').classList.add('metamora-banners');
  }
  
  
  function webmsg(){
	  alert("You are leaving metamorabank.com and will be redirected to another site.  Metamora State Bank makes no endorsements or claims about the accuracy or content of the information contained in these sites. The security and privacy policies on these sites may be different than those of Metamora State Bank.");
  }