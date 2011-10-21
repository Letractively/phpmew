
/*

 */

var Animation = {
	objects: [],
	add: function(actor, autorun) {
		if (autorun == null) autorun = true;

		actor.id = this.objects.length;
		actor.init();
		this.objects.push(actor);

		if (autorun == true) {
			this.run(actor.id);
		}

		return actor.id;
	},
	run: function(id) {
		actor = this.objects[id];

		if (actor.finished() || !this.objects[id].task()) {
			actor.onfinish();
			return;
		}

		setTimeout('Animation.run('+id+')', this.objects[id].interval);
	}
}

Library.onAnimationLoad();

