
/*

 */

Library.loadAnimation();
Library.loadAction();
Library.loadUtils();

function Resizable() {
	this.id = 0;
	this.element = null;
	this.interval = 50;
	this.step = 2;
	this.keepRatio = true;
	this.original = {width: 0, height: 0};
	this.destination = {width: 0, height: 0};
	this.init = function() {
		this.original.width = this.element.width;
		this.original.height = this.element.height;

		if (this.keepRatio) {
			size = Utils.getResizeSize(
				this.original.width, this.original.height,
				this.destination.width, this.destination.height
			);
			this.destination.width = size.width;
			this.destination.height = size.height;
		}
	}
	this.finished = function() {
		if (this.element.width == this.destination.width
		&& this.element.height == this.destination.height) {
			return true;
		}

		return false;
	}
	this.task = function() {
		width = this.element.width;
		height = this.element.height;
		newWidth = width;
		newHeight = height;

		if (width < this.destination.width) {
			newWidth += this.step;
		}
		else if (width > this.destination.width) {
			newWidth -= this.step;
		}

		if (height < this.destination.height) {
			newHeight += this.step;
		}
		else if (height > this.destination.height) {
			newHeight -= this.step;
		}

		if ((this.destination.width > this.original.width && newWidth > this.destination.width)
		|| (this.destination.width < this.original.width && newWidth < this.destination.width)) {
			newWidth = this.destination.width;
		}

		if ((this.destination.height > this.original.height && newHeight > this.destination.height)
		|| (this.destination.height < this.original.height && newHeight < this.destination.height)) {
			newHeight = this.destination.height;
		}

		if (this.keepRatio) {
			maxWidth = newWidth;
			maxHeight = newHeight;
			size = Utils.getResizeSize(width, height, maxWidth, maxHeight);
			newWidth = size.width;
			newHeight = size.height;
		}

		Action.resize(this.element, newWidth, newHeight);

		if (this.keepRatio && maxWidth == this.destination.width && maxHeight == this.destination.height) {
			return false;
		}

		return true;
	}
	this.onfinish = function() {}
	this.reset = function() {
		Action.resize(this.element, this.original.width, this.original.height);
	}
}

