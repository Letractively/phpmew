
/*
	MewLibrary - Simple Cross-browser Javascript Library
	v0.1a by t3RRa
	license: BSD

	library base
 */

if (typeof document.getElementsByClassName == 'undefined') {
	document.getElementsByClassName = function(name, tag, node) {
		classElements = [];
		if (!node) node = document;
		if (!tag) tag = '*';
		var e = node.getElementsByTagName(tag);

		for (i = 0, j = 0; i < e.length; i++)
			if (e[i].getAttribute('className') == name)
				classElements[ j++ ] = e[i];

		return classElements;
	}
}

function $(id) {
	return document.getElementById(id);
}

function $$(name, node) {
	if (!node) node = document;
	return node.getElementsByTagName(name);
}

function _(name) {
	return document.getElementsByClassName(name);
}

/* to be used */
var LIBRARY_STATUS_UNLOADED = 0;
var LIBRARY_STATUS_LOADING  = 1;
var LIBRARY_STATUS_LOADED   = 2;

var Library = {
	base: null,
	Action: false,
	Ajax: false,
	Animation: false,
	FadeAnimation: false,
	MoveAnimation: false,
	ResizeAnimation: false,
	Dialog: false,
	Element: false,
	Media: false,
	Picture: false,
	Utils: false,
	setLibraryBase: function(base) {
		var s;

		if (base)
		{
			this.base = base;
			return;
		}

		script = $$('script');

		for (i = 0; i < script.length; i++)
		{
			s = script[i];
			if (s.src && s.src.match(/mlibrary\.js(\?.*)?$/)) break;
		}

		this.base = s.src.replace(/mlibrary\.js(\?.*)?$/, '');
	},
	load: function(url, func) {
		var ns = document.createElement('script');
		ns.setAttribute('type', 'text/javascript');
		ns.setAttribute('src', url);

		if (func) {
			ns.setAttribute('onload', func);
			ns.setAttribute('onreadystatechange', function() {
				if (this.readyState == 'complete')
					this.onload();
			});
		}

		document.getElementsByTagName('head')[0].appendChild(ns);
	},
	loadLib: function(filename) {
		this.load(this.base + filename);
	},
	unload: function(filename) {},
	loadAction: function() {
		if (!this.Action) {
			this.loadLib('action.js');
			this.Action = true;
		}
	},
	loadAjax: function() {
		if (!this.Ajax) {
			this.loadLib('ajax.js');
			this.Ajax = true;
		}
	},
	loadAnimation: function() {
		if (!this.Animation) {
			this.loadLib('animation.js');
			this.Animation = true;
		}
	},
	loadFadeAnimation: function() {
		if (!this.FadeAnimation) {
			this.loadLib('animations/fade.js');
			this.FadeAnimation = true;
		}
	},
	loadMoveAnimation: function() {
		if (!this.MoveAnimation) {
			this.loadLib('animations/move.js');
			this.MoveAnimation = true;
		}
	},
	loadResizeAnimation: function() {
		if (!this.ResizeAnimation) {
			this.loadLib('animations/resize.js');
			this.ResizeAnimation = true;
		}
	},
	loadDialog: function() {
		if (!this.Dialog) {
			this.loadLib('dialog.js');
			this.Dialog = true;
		}
	},
	loadElement: function() {
		if (!this.Element) {
			this.loadLib('element.js');
			this.Element = true;
		}
	},
	loadMedia: function() {
		if (!this.Media) {
			this.loadLib('media.js'); 
			this.Media = true;
		}
	},
	loadPicture: function() {
		if (!this.Picture) {
			this.loadLib('picture.js');
			this.Picture = true;
		}
	},
	loadUtils: function() {
		if (!this.Utils) {
			this.loadLib('utils.js');
			this.Utils = true;
		}
	},
	loadAll: function() {
		this.loadAction();
		this.loadAjax();
		this.loadAnimation();
		this.loadDialog();
		this.loadElement();
		this.loadMedia();
		this.loadPicture();
		this.loadUtils();
	},
	onActionLoad: function() {
		this.Action = true;
	},
	onAjaxLoad: function() {
		this.Ajax = true;
	},
	onAnimationLoad: function() {
		this.Animation = true;
	},
	onDialogLoad: function() {
		this.Dialog = true;
	},
	onElementLoad: function() {
		this.Element = true;
	},
	onMediaLoad: function() {
		this.Media = true;
	},
	onPictureLoad: function() {
		this.Picture = true;
	},
	onUtilsLoad: function() {
		this.Utils = true;
	}
};

Library.setLibraryBase();

