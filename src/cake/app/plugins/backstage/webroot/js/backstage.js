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
var TableRow = Class.create({
	theExpandedRow: "",
	initialize: function(row_id)
	{
		this.row = $(row_id);
		this.arrow = $(row_id).down('.last_col').down('a');
		this.arrow.observe('click', this.dashToggleExpandableRow.bind(this));
	},
	dashToggleExpandableRow: function(ev)
	{
		ev.stop();

		if ($(self.theExpandedRow))
		{
			$(self.theExpandedRow).removeClassName('expanded');
			$(self.theExpandedRow).next().removeClassName('expanded');
			$(self.theExpandedRow).next().next().removeClassName('expanded');
		}
		if (self.theExpandedRow != this.row.id)
		{
			self.theExpandedRow = this.row.id;
			this.row.addClassName('expanded');
			this.row.next().addClassName('expanded');
			this.row.next().next().addClassName('expanded');
		}
		else
			self.theExpandedRow = false;
	}
});


/**
 * 
 * 
 * @access 
 */
var StatusFilter = Class.create({
	lastStatus: "",
	initialize: function(status_id, selected)
	{
		this.status = $(status_id);
		this.status.observe('click', this.selectStatus.bind(this));
		
		if(selected != '')
		{
			self.lastStatus = status_id;
			this.status.addClassName('selected');
		}
	},
	selectStatus: function(ev)
	{
		ev.stop();

		if (self.lastStatus)
		{
			$(self.lastStatus).removeClassName('selected');
		}
		if (self.lastStatus != this.status.id)
		{
			self.lastStatus = this.status.id;
			this.status.addClassName('selected');
		}
		else
			self.lastStatus = false;
	}
});