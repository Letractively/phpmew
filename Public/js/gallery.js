// example use of included javascript library

function Gallery() {
	this.images = [];
	this.loop = true;
	this.current = 0;
	this.id = 'gallery_image';
	this.desc_id = 'gallery_description';
	this.add = function(imgSrc) {
		this.images.push(imgSrc);
	}
	this.prev = function() {
		if (--this.current < 0) {
			this.current = this.images.length - 1;
		}
		this.show();
		return false;
	}
	this.next = function() {
		if (++this.current >= this.images.length) {
			this.current = 0;
		}
		this.show();
		return false;
	}
	this.show = function() {
		style = "url('"+this.images[this.current][0]+"') 50% 50% no-repeat";
		$(this.id).style.background = style;
		$(this.desc_id).innerHTML = this.images[this.current][1] + '&nbsp;';
		return false;
	}
};

gallery = new Gallery();

function openGallery(num) {
        if (num) {
                gallery.current = num;
        }
        gallery.show();
        Action.show($('gallery'));
        Action.moveToCenter($('gallery'));
        return false;
}

function galleryPrev() {
        gallery.prev();
        Action.moveToCenter($('gallery'));
        return false;
}

function galleryNext() {
        gallery.next();
        Action.moveToCenter($('gallery'));
        return false;
}

