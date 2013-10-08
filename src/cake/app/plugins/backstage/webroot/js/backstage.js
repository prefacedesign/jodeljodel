

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
	initialize: function(row_id, rows_number)
	{
		this.row = $(row_id);
		this.rows_number = rows_number;
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
		this.row.removeClassName('expanded');
		for (a=0; a<this.rows_number-1; a++)
			this.row.next(a).removeClassName('expanded');
		ExpandedRow = false;
	},
	open: function()
	{
		this.row.addClassName('expanded');
		for (a=0; a<this.rows_number-1; a++)
			this.row.next(a).addClassName('expanded');
		ExpandedRow = this;
	}
});


/**
 * 
 * 
 * @access 
 */
var StatusFilter = Class.create({
	initialize: function(status_id, selected)
	{
		this.status = $(status_id);
		this.status.observe('click', this.selectStatus.bind(this));
		this.parent = this.status.up();
		
		if(selected != '')
		{
			this.status.addClassName('selected');
		}
	},
	selectStatus: function(ev)
	{
		ev.stop();
		this.parent.select('a').invoke("removeClassName", "selected");
		this.status.addClassName('selected');		
	}
});
