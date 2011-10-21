
/*

 */

Library.loadUtils();

var Action = {
	add: function(type, obj, expression) {
		if (window.addEventListener)
			obj.addEventListener(type, expression, true);
		else if (window.attachEvent)
			obj.attachEvent('on' + type, expression);
	},
	onblur: function(obj, expression) {
		this.add('blur', obj, expression);
	},
	onclick: function(obj, expression) {
		this.add('click', obj, expression);
	},
	onfocus: function(obj, expression) {
		this.add('focus', obj, expression);
	},
	onkeypress: function(obj, expression) {
		this.add('keypress', obj, expression);
	},
	onkeyup: function(obj, expression) {
		this.add('keyup', obj, expression);
	},
	onload: function(obj, expression) {
		this.add('load', obj, expression);
	},
	onmouseout: function(obj, expression) {
		this.add('mouseout', obj, expression);
	},
	onmouseover: function(obj, expression) {
		this.add('mouseover', obj, expression);
	},
	moveTo: function(obj, x, y) {
		obj.style.position = 'absolute';
		obj.style.left = x + 'px';
		obj.style.top = y + 'px';
	},
	moveBy: function(obj, x, y) {
		pos = Utils.getElementPosition(obj);
		this.moveTo(obj, pos.x + x, pos.y + y);
	},
	moveToCenter: function(obj) {
		pos = Utils.getCenterPosition(obj.clientWidth, obj.clientHeight);
		this.moveTo(obj, pos.x, pos.y);
	},
	opaque: function(obj, alpha) {
		alpha = parseFloat(alpha).toFixed(1);
		obj.style.opacity = alpha;
		//for IE
		obj.style.filter = 'alpha(opacity=' + (alpha * 100) + ')';
		obj.style.zoom = 1;
	},
	resize: function(obj, width, height) {
		if (!width || !height) return;
		obj.width = width;
		obj.height = height;
		obj.style.width = width + 'px';
		obj.style.height = height + 'px';
	},
	resizeByPercent: function(obj, width, height) {
		obj.style.width = width + '%';
		obj.style.height = height + '%';
	},
	show: function(obj, display) {
		if (!display) display = 'block'; 
		obj.style.display = display;
	},
	hide: function(obj) {
		obj.style.display = 'none';
	},
	focus: function(obj) {
		obj.focus();
	}
}

Library.onActionLoad();

