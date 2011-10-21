
var Element = {
	create: function(tag, id) {
		_element = document.createElement(tag);
		if (id) _element.setAttribute('id', id);
		return _element;
	},
	createDiv: function(id) {
		_element = document.createElement('div');
		if (id) _element.setAttribute('id', id);
		return _element;
	},
	createText: function(text) {
		return document.createTextNode(text);
	},
	createButton: function(value, id) {
		_element = document.createElement('input');
		_element.setAttribute('type', 'button');
		_element.setAttribute('value', value);
		if (id) _element.setAttribute('id', id);
		return _element;
	},
	createTextInput: function(name, id, value, maxlen) {
		_element = document.createElement('input');
		_element.setAttribute('type', 'text');
		_element.setAttribute('name', name);
		if (id) _element.setAttribute('id', id);
		if (value) _element.setAttribute('value', value);
		if (maxlen) _element.setAttribute('maxlength', maxlen);
		return _element;
	},
	createTextArea: function(name, id, value, cols, rows) {
		_element = document.createElement('textarea');
		_element.setAttribute('name', name);
		if (id) _element.setAttribute('id', id);
		if (cols) _element.setAttribute('cols', cols);
		if (rows) _element.setAttribute('rows', rows);
		if (value) _element.appendChild(document.createTextNode(value));
		return _element;
	},
	createLink: function(url, name, id) {
		_element = document.createElement('a');
		_element.setAttribute('href', url);
		if (!name) name = url;
		_element.appendChild(document.createTextNode(name));
		if (id) _element.setAttribute('id', id);
		return _element;
	},
	createImage: function(url, alt, id) {
		_element = document.createElement('img');
		_element.setAttribute('src', url);
		if (!alt) _element.setAttribute('alt', alt);
		if (!id) _element.setAttribute('id', id);
		return _element;
	},
	removeAllChildNodes: function(obj) {
		while(obj.firstChild) obj.removeChild(obj.firstChild);
	},
	disable: function(obj) {
		obj.setAttribute('disabled', 'disabled');
	}
}

Library.onElementLoad();

