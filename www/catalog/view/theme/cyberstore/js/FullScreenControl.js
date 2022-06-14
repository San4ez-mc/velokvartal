function FullScreenControl(map,enterFull,exitFull){if(enterFull===void 0){enterFull=null;}if(exitFull===void 0){exitFull=null;}if(enterFull==null){enterFull="Full screen";}if(exitFull==null){exitFull="Exit full screen";}var controlDiv=document.createElement("div");controlDiv.className="fullScreen";controlDiv.index=1;controlDiv.style.padding="5px";var controlUI=document.createElement("div");controlUI.style.backgroundColor="white";controlUI.style.borderStyle="solid";controlUI.style.borderWidth="1px";controlUI.style.borderColor="#717b87";controlUI.style.cursor="pointer";controlUI.style.textAlign="center";controlUI.style.boxShadow="rgba(0, 0, 0, 0.298039) 0px 1px 4px -1px";controlDiv.appendChild(controlUI);var controlText=document.createElement("div");controlText.style.fontFamily="Roboto,Arial,sans-serif";controlText.style.fontSize="11px";controlText.style.fontWeight="400";controlText.style.paddingTop="1px";controlText.style.paddingBottom="1px";controlText.style.paddingLeft="6px";controlText.style.paddingRight="6px";controlText.innerHTML="<strong>"+enterFull+"</strong>";controlUI.appendChild(controlText);var head=document.getElementsByTagName("head")[0];var newStyle=document.createElement("style");newStyle.setAttribute("type","text/css");newStyle.setAttribute("media","print");var cssText=".fullScreen { display: none;}";var texNode=document.createTextNode(cssText);try{newStyle.appendChild(texNode);}catch(e){newStyle.styleSheet.cssText=cssText;}head.appendChild(newStyle);var fullScreen=false;var interval;var mapDiv=map.getDiv();var divStyle=mapDiv.style;if(mapDiv.runtimeStyle){divStyle=mapDiv.runtimeStyle;}var originalPos=divStyle.position;var originalWidth=divStyle.width;var originalHeight=divStyle.height;if(originalWidth===""){originalWidth=mapDiv.style.width;}if(originalHeight===""){originalHeight=mapDiv.style.height;}var originalTop=divStyle.top;var originalLeft=divStyle.left;var originalZIndex=divStyle.zIndex;var bodyStyle=document.body.style;if(document.body.runtimeStyle){bodyStyle=document.body.runtimeStyle;}var originalOverflow=bodyStyle.overflow;controlDiv.goFullScreen=function(){var center=map.getCenter();mapDiv.style.position="fixed";mapDiv.style.width="100%";mapDiv.style.height="100%";mapDiv.style.top="0";mapDiv.style.left="0";mapDiv.style.zIndex="100";document.body.style.overflow="hidden";controlText.innerHTML="<strong>"+exitFull+"</strong>";fullScreen=true;google.maps.event.trigger(map,"resize");map.setCenter(center);interval=setInterval(function(){if(mapDiv.style.position!=="fixed"){mapDiv.style.position="fixed";google.maps.event.trigger(map,"resize");}},100);};controlDiv.exitFullScreen=function(){var center=map.getCenter();if(originalPos===""){mapDiv.style.position="relative";}else{mapDiv.style.position=originalPos;}mapDiv.style.width=originalWidth;mapDiv.style.height=originalHeight;mapDiv.style.top=originalTop;mapDiv.style.left=originalLeft;mapDiv.style.zIndex=originalZIndex;document.body.style.overflow=originalOverflow;controlText.innerHTML="<strong>"+enterFull+"</strong>";fullScreen=false;google.maps.event.trigger(map,"resize");map.setCenter(center);clearInterval(interval);};google.maps.event.addDomListener(controlUI,"click",function(){if(!fullScreen){controlDiv.goFullScreen();}else{controlDiv.exitFullScreen();}});return controlDiv;}