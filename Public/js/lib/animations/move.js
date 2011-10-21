
/*

 */

Library.loadAnimation();
Library.loadAction();
Library.loadUtils();

function Movable() {
	this.id = 0;
	this.element = null;
	this.interval = 50;
	this.step_x = 3;
	this.step_y = 3;
	this.position = 'static';
	this.destination = {x: 0, y: 0};
	this.original = {x: 0, y: 0};
	this.init = function() {
		this.position = this.element.style.position;
		this.original.x = this.element.offsetLeft;
		this.original.y = this.element.offsetTop;
	}
	this.task = function() {
		pos = Utils.getElementPosition(this.element);

		if (pos.x + this.step_x >= this.destination.x)
			next_x = this.destination.x;
		else
			next_x = pos.x + this.step_x;

		if (pos.y + this.step_y >=  this.destination.y)
			next_y = this.destination.y;
		else
			next_y = pos.y + this.step_y;

		Action.moveTo(this.element, next_x, next_y);
		return true;
	}
	this.finished = function() {
		pos = Utils.getElementPosition(this.element);

		if (pos.x == this.destination.x && pos.y == this.destination.y) {
			return true;
		}

		return false;
	}
	this.onfinish = function() {}
	this.reset = function() {
		this.element.style.position = this.position;
		this.element.style.left = this.original.x + 'px';
		this.element.style.top = this.original.y + 'px';
	}
}

