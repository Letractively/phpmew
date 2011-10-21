
/*

 */

Library.loadAction();
Library.loadUtils();

var Picture = {
	Loader: {
		objects: [],
		set: function(obj, realImageSrc) {
			realImage = new Image;
			realImage.setAttribute('src', realImageSrc);
			realImage.objId = this.objects.length;
			this.objects.push(obj);
			Action.onload(realImage, function(e) {
				if (!e) e = window.event;
				obj = (e.target ? e.target : (e.srcElement ? e.srcElement : null));
				img = Picture.Loader.objects[obj.objId];
				obj.removeAttribute('onload');
				obj.removeAttribute('objId');
				img.setAttribute('src', obj.src);
			});
		}
	},
	Resize: {
		width: 0,
		height: 0,
		keepRatio: true,
		idOf: function(id) {
			if (this.keepRatio) {
				size = Utils.getResizeSize($(id).width, $(id).height, this.width, this.width);
			}
			else {
				size = {width: width, height: height};
			}

			Action.resize($(id), size.width, size.height);
		},
		classOf: function(className) {
			images = _(className);

			for (i = 0; i < images.length; i++) {
				if (this.keepRatio) {
					size = Utils.getResizeSize(images[i].width, images[i].height, this.width, this.width);
				}
				else {
					size = {width: width, height: height};
				}

				Action.resize(images[i], size.width, size.height);
			}
		}
	},
	rollOver: function(obj, imageSrc) {
		aImage = new Image;
		aImage.src = imageSrc;
		obj.originalSrc = obj.src;
		obj.rollOverSrc = imageSrc;

		Action.onmouseover(obj, function(e) {
			if (!e) e = window.event;
			img = (e.target ? e.target : (e.srcElement ? e.srcElement : null));
			img.src = img.rollOverSrc;
		});
		Action.onmouseout(obj, function(e) {
			if (!e) e = window.event;
			img = (e.target ? e.target : (e.srcElement ? e.srcElement : null));
			img.src = img.originalSrc;
		});
	}
}

Library.onPictureLoad();

