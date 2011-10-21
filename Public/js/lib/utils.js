
var Utils = {
	getElementPosition: function(obj) {
		//http://www.quirksmode.org/js/findpos.html
		var curleft = curtop = 0;

		if (obj.offsetParent) {
			do {
				curleft += obj.offsetLeft;
				curtop += obj.offsetTop;
			} while (obj = obj.offsetParent);
		}

		return {x: curleft, y: curtop};
	},
	getClientSize: function() {
		if (self.innerWidth) {
			frameWidth = self.innerWidth;
			frameHeight = self.innerHeight;
		}
		else if (document.documentElement && document.documentElement.clientWidth) {
			frameWidth = document.documentElement.clientWidth;
			frameHeight = document.documentElement.clientHeight;
		}
		else if (document.body) {
			frameWidth = document.body.clientWidth;
			frameHeight = document.body.clientHeight;
		}
		else {
			alert('cannot retrieve client size');
			return;
		}

		return { width: frameWidth, height: frameHeight };
	},
	getCenterPosition: function(width, height) {
		if (!width) width = 0;
		if (!height) height = 0;

		frame = this.getClientSize();

		if (width.toString().indexOf('%') >= 0) {
			width = parseInt(width);
			width = frame.width * width / 100;
		}
		else {
			width = parseInt( width );
		}

		if (height.toString().indexOf('%') >= 0) {
			height = frame.height * height / 100;
		}
		else {
			height = parseInt(height);
		}

		posX = Math.round(frame.width / 2) - Math.round(width / 2);
		posY = Math.round(frame.height / 2) - Math.round(height / 2);

		if (typeof(window.pageXOffset) == 'number') {
			posX += parseInt(window.pageXOffset);
			posY += parseInt(window.pageYOffset);
		}
		else if (document.body && (document.body.scrollLeft || document.body.scrollTop)) {
			posX += document.body.scrollLeft;
			posY += document.body.scrollTop;
		}
		else if (document.documentElement && (document.documentElement.scrollLeft || document.documentElement.scrollTop)) {
			posX += document.documentElement.scrollLeft;
			posY += document.documentElement.scrollTop;
		}

		if (posX < 0) posX = 0;
		if (posY < 0) posY = 0;

		return {x: posX, y: posY};
	},
	getResizeSize: function(width, height, max_width, max_height) {
		new_width = width;
		new_height = height;
		prop = (width / height).toFixed(2);

		if (max_width > 0 && width > max_width) {
			new_width = max_width;
			new_height = Math.round(new_width / prop);
			prop = (new_width / new_height).toFixed(2);
		}

		if (max_height > 0 && new_height > max_height) {
			new_height = max_height;
			new_width = Math.round(new_height * prop);
		}

		return {width: new_width, height: new_height};
	},
	escapeHtml: function(string) {
		patterns = [' ', '&', '\t', '\r', '\b', '\n', '\f', '\\'];
		to = ['%20', '%38', '\\t', '\\r', '\\b', '\\n', '\\f', '\\\\'];

		for (i = 0; i < patterns.length; i++) {
			string.replace(patterns[i], to[i]);
		}

		return string;
	},
	nl2br: function(string) {
		return string.replace(/\n/g, '<br />');
	},
	number_format: function(number, decimals) {
		if (!decimals) decimals = 3;

		formatted = '';
		number = number.toString();
		len = number.length;
		lastPos = len - 1;
		clen = decimals - 1;

		for (i = (len - 1); i >= 0; i -= decimals) {
			if (i < 0) break;

			startPos = ((i - clen) > 0) ? (i - clen) : 0;
			lastPos = i;
			chrlen = lastPos - startPos + 1;
			formatted = number.substr(startPos, chrlen) + (formatted != '' ? ',' : '') + formatted;
		}

		return formatted;
	}
}

Library.onUtilsLoad();

