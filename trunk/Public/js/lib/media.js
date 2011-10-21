
/*

 */

var Media = {
	Flash: {
		targetId: null,
		id: null,
		type: 'application/x-shockwave-flash',
		src: null,
		quality: 'high',
		allowfullscreen: true,
		allowscriptaccess: 'always',
		flashvars: null,
		width: 0,
		height: 0,
		insert: function() {
			embed = document.createElement('embed');
			if (this.id) embed.setAttribute('id', this.id);
			embed.setAttribute('type', this.type);
			embed.setAttribute('src', this.src);
			embed.setAttribute('quality', this.quality);
			embed.setAttribute('allowfullscreen', this.allowfullscreen);
			embed.setAttribute('allowscriptaccess', this.allowscriptaccess);
			if (this.flashvars) embed.setAttribute('flashvars', this.flashvars);
			embed.setAttribute('width', this.width);
			embed.setAttribute('height', this.height);
			$(this.targetId).appendChild(embed);
		}
	},
	Picture: {
	},
	Sound: {
	},
	Video: {
	}
}

Library.onMediaLoad();

