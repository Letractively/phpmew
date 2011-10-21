
/*

 */

var AJAX_STATE_UNINITIALISED = 0;
var AJAX_STATE_OPEN = 1;
var AJAX_STATE_SEND = 2;
var AJAX_STATE_RECEIVING = 3;
var AJAX_STATE_LOADED = 4;

// http://developer.apple.com/internet/webcontent/XMLHttpRequestExample/example.html
function getElementTextNS(prefix, local, parentElem, index) {
	var result = '';

	if (!parentElem) return '';

	if (prefix && isIE) {
		result = parentElem.getElementsByTagName(prefix + ':' + local)[index];
	}
	else {
		result = parentElem.getElementsByTagName(local)[index];
	}

	if (result) {
		if (result.childNodes.length > 1) {
			return result.childNodes[1].nodeValue;
		}
		else if (result.firstChild) {
			return result.firstChild.nodeValue;
		}
	}

	return '';
}

function getElementText(id, parentElem)
{
	return getElementTextNS('', id, parentElem, 0);
}

var Ajax = {
	request: null,
	acceptType: 'text/xml',
	contentType: 'application/x-www-form-urlencoded',
	method: 'get',
	url: null,
	data: null,
	returnType: 'xml',
	errorReturnType: 'text',
	onUninitialised: function() {},
	onOpen: function() {},
	onSend: function() {},
	onReceiving: function() {},
	onLoaded: function() {},
	onSuccess: function(response) {},
	onFail: function(statusCode, error) {},
	onNoAjax: function() { return false; },
	init: function() {
		this.request = null;
		this.acceptType = 'text/xml';
		this.contentType = 'application/x-www-form-urlencoded';
		this.method = 'get';
		this.url = null;
		this.data = null;
		this.returnType = 'xml';
		this.errorReturnType = 'text';
		this.onUninitialised = function() {};
		this.onOpen = function() {};
		this.onSend = function() {};
		this.onReceiving = function() {};
		this.onLoaded = function() {};
		this.onSuccess = function(response) {};
		this.onFail = function(statusCode, error) {};
		this.onNoAjax = function() { return false; };
	},
	run: function() {
		if (window.XMLHttpRequest) {
			this.request = new XMLHttpRequest();
		}
		else {
			//MSXML2.XMLHTTP.3.0, Msxml2.XMLHTTP, Microsoft.XMLHTTP
			this.request = new ActiveXObject('MSXML2.XMLHTTP.3.0');
		}

		if (!this.request) return this.onNoAjax();
		this.request.open(this.method, this.url, true);
		this.request.setRequestHeader('Accept', this.acceptType);
		this.request.setRequestHeader('Content-Type', this.contentType);
		this.request.onreadystatechange = function() {
			request = Ajax.request;

			switch (request.readyState) {
				case AJAX_STATE_UNINITIALISED: {
					Ajax.onUninitialised();
					break;
				}
				case AJAX_STATE_OPEN: {
					Ajax.onOpen();
					break;
				}
				case AJAX_STATE_SEND: {
					Ajax.onSend();
					break;
				}
				case AJAX_STATE_RECEIVING: {
					Ajax.onReceiving();
					break;
				}
			}

			if (request.readyState != AJAX_STATE_LOADED) {
				return false;
			}

			Ajax.onLoaded();

			if (request.status == 200) {
				if (Ajax.returnType == 'xml') {
					Ajax.onSuccess(request.responseXML);
				}
				else if (Ajax.returnType == 'json') {
					json = eval('('+request.responseText+')');
					Ajax.onSuccess(json);
				}
				else {
					Ajax.onSuccess(request.responseText);
				}
			}
			else {
				if (Ajax.errorReturnType == 'xml') {
					Ajax.onFail(request.status, request.responseXML);
				}
				else {
					Ajax.onFail(request.status, request.responseText);
				}
			}
		}

		this.request.send(this.data);
		return true;
	}
}

Library.onAjaxLoad();

