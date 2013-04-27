

/**
 *
 * Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */


var Dashboard = Class.create({
	initialize: function()
	{
	}
});

/**
 * Manages the "Add content" list (opening and closing the list)
 * 
 * @access public
 * @param string list_id The ID for the hidden div wrapping the list
 * @param string link_to_add The ID for the div containing the close link
 */
var ItemList = Class.create({
	initialize: function(list_id, link_to_add)
	{
		this.list = $(list_id);
		this.list.down('span>a').observe('click', this.close.bind(this));
		
		this.link_to_add = $(link_to_add);
		this.link_to_add.down('a').observe('click', this.open.bind(this));
	},
	open: function(ev)
	{
		ev.stop();
		this.link_to_add.removeClassName('expanded');
		this.list.addClassName('expanded');
	},
	close: function(ev)
	{
		ev.stop();
		this.link_to_add.addClassName('expanded');
		this.list.removeClassName('expanded');
	}
});


/**
 * 
 * 
 * @access 
 */
var SearchInput = Class.create({
	initialize: function(input_id)
	{
		this.input = $(input_id);
		this.input.observe('focus', this.hideLabel.bind(this));
		this.input.observe('blur', this.showLabel.bind(this));
		
		this.label = this.input.previous('label');
		
		if (!this.input.value.blank())
			this.hideLabel();
	},
	hideLabel: function(ev)
	{
		this.label.setStyle({visibility: 'hidden'});
	},
	showLabel: function(ev)
	{
		if (this.input.value.blank())
			this.label.setStyle({visibility: ''});
	}
});



/**
 * 
 * 
 * @access 
 */
var ExpandedRow = false;
var TableRow = Class.create({
	initialize: function(row_id)
	{
		this.row = $(row_id);
		this.arrow = $(row_id).down('.arrow > a');
		this.arrow.observe('click', this.toggleRow.bind(this));
	},
	toggleRow: function(ev)
	{
		ev.stop();
		var sameRow = ExpandedRow == this;
		
		if (ExpandedRow !== false)
			ExpandedRow.close();
		if (!sameRow)
			this.open();
	},
	close: function()
	{
		[this.row, this.row.next(),this.row.next().next()].invoke('removeClassName', 'expanded');
		ExpandedRow = false;
	},
	open: function()
	{
		[this.row, this.row.next(),this.row.next().next()].invoke('addClassName', 'expanded');
		ExpandedRow = this;
	}
});

/**
 * Toogles the filter link on and off
 */
var FilterLink = Class.create({
	initialize: function(link_id, selected, filter_all)
	{
		this.link = $(link_id).observe('click',this.linkClick.bind(this)).observe('mouseout', this.linkMouseOut.bind(this)).observe('mouseover', this.linkMouseOver.bind(this));
		this.filter_all = filter_all ? $(filter_all) : this.link;
		if (selected)
			this.select();
	},
	linkMouseOver: function(ev)
	{
		this.mouseOver = true;
	},
	linkMouseOut: function(ev)
	{
		this.link.removeClassName('force_unselected');
		this.mouseOver = false;
	},
	linkClick: function(ev)
	{
		if (this.link.hasClassName('selected'))
			this.unselect();
		else
			this.select();
	},
	select: function()
	{
		this.link.up().select('a').invoke('removeClassName', 'selected');
		this.link.addClassName('selected').removeClassName('force_unselected');
	},
	unselect: function()
	{
		this.link.removeClassName('selected');
		if (this.mouseOver)
			this.link.addClassName('force_unselected');
		if (this.filter_all);
			this.filter_all.addClassName('selected').removeClassName('force_unselected');
	}
});
