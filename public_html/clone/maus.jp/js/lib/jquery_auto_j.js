
// jQuery_Auto 0.9
// Automatic functions for webpages (using the wonderful jQuery library)

// Copyright: (c) 2006, Michal Tatarynowicz (tatarynowicz@gmail.com)
// Licenced as Public Domain (http://creativecommons.org/licenses/publicdomain/)
// $Id: jquery_auto.js 426 2006-05-06 19:54:39Z Michał $


// prototype.js use $();
// jQuery       use j$();
jQuery.noConflict();
var j$ = jQuery;


// Initialization

j$.auto = {
	init: function() {
		for (module in j$.auto) {
			if (j$.auto[module].init)
				j$.auto[module].init();
		}
	}
};

j$(document).ready(j$.auto.init);


// Auto-hidden elements

j$.auto.hide = {
	init: function() {
		j$('.Hide').hide();
	}
};


// Mouse hover

j$.auto.hover = {

	init: function() {
		j$('IMG.Hover')
			.bind('mouseover', this.enter)
			.bind('mouseout', this.exit)
			.each(this.preload);
	},

	preload: function() {
		this.preloaded = new Image;
		this.preloaded.src = this.src.replace(/^(.+)(\.[a-z]+)$/, "$1_over$2");
	},

	enter: function() {
		this.src = this.src.replace(/^(.+)(\.[a-z]+)$/, "$1_over$2");
	},

	exit: function() {
		this.src = this.src.replace(/^(.+)_over(\.[a-z]+)$/, "$1$2");
	}
};


// Auto-submitting SELECTs

j$.auto.submit = {
	init: function() {
		j$('SELECT.Submit').bind('change', this.on_change);
	},

	on_change: function() {
		if (this.value) this.form.submit();
	}
};


// Auto-selected text in text fields after a label click

j$.auto.select = {
	init: function() {
		j$('LABEL.Select').each(this.label_action);
		j$('INPUT.Select').bind('click', function(){ this.select(); });
	},

	label_action: function() {
		var field = j$('#'+this.htmlFor).get(0);
		if (field && field.focus && field.select) {
			j$(this).bind('click', function(){ field.focus(); field.select(); });
		}
	}
};


// Switches tabs on click

j$.auto.tabs = {

	init: function() {

		j$('.Tabs').each(function(){
			var f = j$.auto.tabs.click;
			var group = this;
			j$('.Tab', group).each(function(){
				this.group = group;
				j$(this).click(f);
				j$('#'+this.id+'_body').hide();
			}).filter(':first').trigger('click');
		});

	},

	click: function() {
		var tab = j$('#'+this.id+'_body').get(0);
		j$('.Tab', this.group).each(function(){
			j$(this).removeClass('Active');
			j$('#'+this.id+'_body').hide();
		});

		j$(this).addClass('Active');
		j$(tab).show();
		this.blur();

		return false;
	}

};