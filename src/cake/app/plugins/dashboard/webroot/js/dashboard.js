/**
 * Class that creates the interaction for the dashboard table.
 * 
 * @access public
 */
var Dashboard = Class.create({
	initialize: function(table_container)
	{
		this.table_container = $(table_container);
		
		this.toogleRowBinded = this.toogleRow.bind(this);
		this.table_container.select('.arrow>a').invoke('observe', 'click', this.toogleRowBinded);
		
		this.currentExpandedRow = false;
	},
	toogleRow: function(ev)
	{
		ev.stop();
		var row = ev.findElement('a').up('tr.main_info');
		if (row == this.currentExpandedRow)
		{
			this.contract(row);
			return;
		}
		
		if (this.currentExpandedRow)
			this.contract(this.currentExpandedRow);
		this.expand(row);
	},
	expand: function (row)
	{
		row.addClassName('expanded');
		row.next(0).addClassName('expanded');
		row.next(1).addClassName('expanded');
		this.currentExpandedRow = row;
	},
	contract: function (row)
	{
		row.removeClassName('expanded');
		row.next(0).removeClassName('expanded');
		row.next(1).removeClassName('expanded');
		this.currentExpandedRow = false;
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