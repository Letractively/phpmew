
/*

 */

Library.loadAnimation();
Library.loadAction();

function Fadeable() {
	this.id = 0;
	this.element = null;
	this.interval = 100;
	this.step = 0.1;
	this.original = 1;
	this.destination = 0;
	this.init = function() {
		if (this.element.style.opacity) {
			this.original = this.element.style.opacity;
		}
		else {
			this.original = 1.0;
			Action.opaque(this.element, this.original);
		}
	}
	this.finished = function() {
		if (this.original == this.destination || this.element.style.opacity == this.destination) {
			return true;
		}

		return false;
	}
	this.task = function() {
		currentOpacity = this.element.style.opacity;

		if (this.original > this.destination) {
			currentOpacity -= this.step;

			if (currentOpacity < this.destination) {
				currentOpacity = this.destination;
			}
		}
		else if (this.original < this.destination) {
			currentOpacity += this.step;

			if (currentOpacity > this.destination) {
				currentOpacity = this.destination;
			}
		}

		Action.opaque(this.element, currentOpacity);
		return true;
	}
	this.onfinish = function() {}
	this.reset = function() {
		Action.opaque(this.element, this.original);
	}
}

