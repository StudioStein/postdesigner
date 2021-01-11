function start() {
 
   colors = "";

   canvasTxt = window.canvasTxt.default;
  
   content = document.getElementById('content');
   menus = document.getElementById('menus');
   elementsContainer = document.getElementById('elementsContainer');
   loadedContent = [false];
   loadedPage = false;
   
   elementoAtual = -1;
   imageValue = "";
   
   c = document.getElementById("myCanvas");
   ctx = c.getContext("2d");
  
  for(i=0;i<template.length;i++) {
  	if (template[i].type == "img") {
			content.innerHTML += '<img id="img'+i+'" src="'+template[i].url+'" crossOrigin="Anonymous" onload="loadedContent['+(i+1)+']=true">';
			loadedContent[i+1]=false;
    }
    if (template[i].type == "txt") {
    	content.innerHTML += '<link href="'+template[i].fontUrl+'" rel="stylesheet">';
		content.innerHTML += '<span style="font-family: '+"'"+template[i].fontName+"'"+';">.</span>';
		
		colors = "";
		for (j=0;j<userColors.length;j++) {
			colors += '<button class="u-circle p-2 m-2" style="color:'+userColors[j]+'" onclick="changeTextColor('+i+',this)"><i class="material-icons">stop_circle</i></button>';
		}
		
		elementsContainer.innerHTML += consElementButton(i, "txt");
		menus.innerHTML += consMenuTxt(i);
		loadedContent[i+1]=true;
    }
    if (template[i].type == "img-upload") {
    	template[i].img = document.getElementById('placeholder');
		elementsContainer.innerHTML += consElementButton(i, "img");
		menus.innerHTML += consMenuImg(i);
		loadedContent[i+1]=true;
	}
  }
  
  loadInterval = setInterval(checkLoad, 100);

}

function checkLoad() {
	var loaded=true;
	for(i=0;i<loadedContent.length;i++) {
		if (loadedContent[i]==false) {loaded=false;}
	}
	if (loaded==true && loadedPage==true) {
		clearInterval(loadInterval);
		drawCanvas();
		c.style.animation = "fadein 0.5s";
		document.getElementById('loader').style.display = "none";
		
	}
}

function drawCanvas() {

	ctx.clearRect(0, 0, c.width, c.height);	
  
  for(i=0;i<template.length;i++) {
  
  ctx.globalCompositeOperation = template[i].blend;
  ctx.globalAlpha = template[i].opacity;
  
  	if (template[i].type == "img") {
    	ctx.drawImage(document.getElementById('img'+i), 0, 0, 1080, 1080);
    }
    if (template[i].type == "img-upload") {
    	ctx.drawImage(template[i].img, template[i].x, template[i].y, template[i].w, template[i].h);
    }
    if (template[i].type == "txt") {
    	ctx.fillStyle = template[i].fontColor;
    	canvasTxt.font = template[i].fontName;
      canvasTxt.fontSize = template[i].fontSize;
      canvasTxt.align = template[i].fontAlign;
      canvasTxt.drawText(ctx,template[i].text,template[i].x,template[i].y,template[i].w,template[i].h);
    }

  }
  
  if (elementoAtual >= 0) {
	ctx.strokeStyle = "#ff3c2e";
	ctx.lineWidth = 5;
	ctx.strokeRect(template[elementoAtual].x, template[elementoAtual].y, template[elementoAtual].w, template[elementoAtual].h);
  }
  
  ctx.restore();
  
  imageValue = c.toDataURL();

}

function cropImage(num) {
	
  c2 = document.createElement('canvas');
  
  c2.width = template[num].w;
  c2.height = template[num].h;
  ctx2 = c2.getContext('2d');
  
  var aspectDest = c2.width/c2.height;
  var aspectImg = img.width/img.height;
  
  if (aspectImg>aspectDest) {
    var scale=c2.height/img.height;
    var sH=img.height*scale;
    var sW=img.width*scale;
    var sX=-((sW-c2.width)/2);
    ctx2.drawImage(img, sX, 0, sW, sH);
   }
   else {
   	var scale=c2.width/img.width;
    var sH=img.height*scale;
    var sW=img.width*scale;
    var sY=-((sH-c2.height)/2);
    ctx2.drawImage(img, 0, sY, sW, sH);
  }
  
  template[num].img = c2;
  drawCanvas();
  
}

function handleFile(el,fileNum) {
	img = new Image();
  img.onload = function() {cropImage(fileNum)};
  img.onerror = function() {console.error("The provided file couldn't be loaded as an Image media");};
  img.src = URL.createObjectURL(el.files[0]);
  img.crossOrigin = 'Anonymous';
}


// Constructors

//Elements Button Constructor
function consElementButton(id, type) {
	if (type == "img") {
		return '<button class="u-circle p-2 m-2" onclick="gotoMenu(this); selectElement('+id+')" data-id1="elements" data-id2="img-editor-'+id+'"><i class="material-icons">image</i></button>';
	}
	else {
		return '<button class="u-circle p-2 m-2" onclick="gotoMenu(this); selectElement('+id+')" data-id1="elements" data-id2="text-editor-'+id+'"><i class="material-icons">text_fields</i></button>';
	}
	
}

//Menu Constructor
function consMenuImg(id) {
	return '<div id="img-editor-'+id+'" class="u-shadow u-round p-2" style="flex-grow:1;display:none"><div class="tile u-items-center"><div class="title__icon"><button class="btn-transparent u-circle m-0 p-2" onclick="gotoMenu(this); selectElement(-1)" data-id1="img-editor-'+id+'" data-id2="elements"><i class="material-icons">arrow_back</i></button></div><div class="tile__container"><p class="tile__title m-0">Imagem</p></div></div><div style="overflow:auto; white-space: nowrap; text-align:center"><button class="u-circle p-2 m-2" onClick="changeImgFile('+id+')"><i class="material-icons">perm_media</i></button></div><div class="tile u-items-center"><div class="title__icon"><button class="btn-transparent m-0 p-2"><i class="material-icons">opacity</i></button></div><div class="tile__container p-2"><input type="range" id="opacity" name="opacity" class="p-0" min="0" max="1" step="0.01" value="'+template[id].opacity+'" onchange="changeImgOpacity('+id+',this)" oninput="changeImgOpacity('+id+',this)"></div></div></div><input type="file" style="display:none" accept="image/*" id="file-'+id+'" onChange="handleFile(this,'+id+')"/>';
}

function consMenuTxt(id) {
	return '<div id="text-editor-'+id+'" class="u-shadow u-round p-2" style="flex-grow:1;display:none"><div class="tile u-items-center"><div class="title__icon"><button class="btn-transparent u-circle m-0 p-2" onclick="gotoMenu(this); selectElement(-1)" data-id1="text-editor-'+id+'" data-id2="elements"><i class="material-icons">arrow_back</i></button></div><div class="tile__container"><p class="tile__title m-0">Texto</p></div></div><div style="overflow:auto; white-space: nowrap; text-align:center"><button class="u-circle p-2 m-2" onclick="gotoMenu(this)" data-id1="text-editor-'+id+'" data-id2="text-editor-'+id+'-text"><i class="material-icons">edit</i></button><button class="u-circle p-2 m-2" onclick="gotoMenu(this)" data-id1="text-editor-'+id+'" data-id2="text-editor-'+id+'-color"><i class="material-icons">palette</i></button><button class="u-circle p-2 m-2" onclick="changeTextVisibility('+id+')"><i class="material-icons" id="text-editor-'+id+'-visible">visibility</i></button></div><div class="tile u-items-center"><div class="title__icon"><button id="text-editor-'+id+'-fontSize" class="btn-transparent m-0 p-2 tile__title">'+template[id].fontSize+'</button></div><div class="tile__container p-2"><input type="range" id="size" name="size" class="p-0" min="15" max="150" value="'+template[id].fontSize+'" onchange="changeFontSize('+id+',this)" oninput="changeFontSize('+id+',this)"></div></div></div><div id="text-editor-'+id+'-text" class="u-shadow u-round p-2" style="flex-grow:1; display:none"><div class="tile u-items-center"><div class="title__icon"><button class="btn-transparent u-circle m-0 p-2" onclick="gotoMenu(this)" data-id1="text-editor-'+id+'-text" data-id2="text-editor-'+id+'"><i class="material-icons">arrow_back</i></button></div><div class="tile__container"><p class="tile__title m-0">Editar Texto</p></div></div><textarea onchange="changeTextValue('+id+',this)" oninput="changeTextValue('+id+',this)" style="resize: none;">'+template[id].text+'</textarea></div><div id="text-editor-'+id+'-color" class="u-shadow u-round p-2" style="flex-grow:1; display:none"><div class="tile u-items-center"><div class="title__icon"><button class="btn-transparent u-circle m-0 p-2" onclick="gotoMenu(this)" data-id1="text-editor-'+id+'-color" data-id2="text-editor-'+id+'"><i class="material-icons">arrow_back</i></button></div><div class="tile__container"><p class="tile__title m-0">Editar Cor</p></div></div><div style="overflow:auto; white-space: nowrap; text-align:center">'+colors+'</div></div>';
}


// Menus Funcions

function gotoMenu(id) { 
	document.getElementById(id.dataset.id1).style.display="none";
	document.getElementById(id.dataset.id2).style.display="block";
}

function selectElement(id) {
	elementoAtual = id;
	drawCanvas();
}

function changeFontSize(id,slider) {
	template[id].fontSize = slider.value;
	document.getElementById('text-editor-'+id+'-fontSize').innerHTML = slider.value;
	drawCanvas();
}

function changeTextVisibility(id) {
	if (template[id].opacity == 1) {
		template[id].opacity = 0;
		document.getElementById('text-editor-'+id+'-visible').innerHTML = "visibility_off";
	}
	else {
		template[id].opacity = 1;
		document.getElementById('text-editor-'+id+'-visible').innerHTML = "visibility";
	}
	drawCanvas();	
}

function changeTextValue(id,el) {
	template[id].text = el.value;
	drawCanvas();
}

function changeTextColor(id, el) {
	template[id].fontColor = el.style.color;
	drawCanvas();
}

function changeImgOpacity(id,slider) {
	template[id].opacity = slider.value;
	drawCanvas();	
}

function changeImgFile(id) {
	document.getElementById('file-'+id).click();
}

// Render Image

function renderImg() {
	elementoAtual = -1;
	drawCanvas();
	document.getElementById('imageSave').src=imageValue;	
	document.getElementById('screen-editor').style.display="none";
	document.getElementById('screen-save').style.display="block";
}