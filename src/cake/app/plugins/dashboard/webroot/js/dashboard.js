
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


/**
 * 
 * 
 * @access 
 */
var TypeFilter = Class.create({
	lastType: "",
	initialize: function(type_id, selected)
	{
		this.type = $(type_id);
		this.type.observe('click', this.selectType.bind(this));
		
		if(selected != '')
		{
			self.lastType = type_id;
			this.type.addClassName('selected');
		}
	},
	selectType: function(ev)
	{
		ev.stop();

		if (self.lastType)
		{
			$(self.lastType).removeClassName('selected');
		}
		if (self.lastType != this.type.id)
		{
			self.lastType = this.type.id;
			this.type.addClassName('selected');
		}
		else
			self.lastType = false;
	}
});
