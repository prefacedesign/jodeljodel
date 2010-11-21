var BuroForm = Class.create({
	initialize: function()
	{
		this.url = arguments[0];

		this.form = $(arguments[1]);
		this.form.reset = this.resetForm.bind(this);
		this.form.lock = this.lockForm.bind(this);
		this.form.unlock = this.unlockForm.bind(this);
		
		this.form.observe('keypress', function(ev){
			var element = ev.findElement().nodeName.toLowerCase();
			var key = ev.keyCode;
			if(key == 13 && element == 'input')
				this.submits();
		}.bind(this));

		this.submit = $(arguments[2]);
		this.submit.observe('click', this.submits.bind(this));
		
		this.inputs = Form.getElements(this.form);
	},
	lockForm: function()
	{
		this.form.setOpacity(0.5);
		this.inputs.each(Form.Element.disable);
	},
	unlockForm: function()
	{
		this.form.setOpacity(1);
		this.inputs.each(Form.Element.enable);
	},
	resetForm: function()
	{
		
	},
	submits: function(ev)
	{
		var data = Form.serializeElements(this.inputs);
		this.trigger('onStart');
		new Ajax.Request(this.url, {
			parameters: data,
			onComplete: function (response) { this.trigger('onComplete'); }.bind(this),
			onFailure: function (response) { this.trigger('onFailure'); }.bind(this),
			onSuccess: function (response) {
				if(response.responseJSON) this.json = response.responseJSON;
				if(this.json && this.json.saved === true)	
					this.trigger('onSave');
				else if(this.json && this.json.saved === false)
					this.trigger('onReject');
				this.trigger('onSuccess');
			}.bind(this)
		});
	},
	addCallbacks: function(callbacks)
	{
		this.callbacks = $H(callbacks); 
		return this;
	},
	trigger: function(callback)
	{
		var callback_function = this.callbacks.get(callback);
		if(!callback_function)
			return false;

		switch(callback)
		{
			case 'onStart':
				callback_function(this.form);
				break;
			
			case 'onSave': 
			case 'onReject': 
				callback_function(this.form, this.response, this.json, this.json.saved);
				break;
				
			case 'onSuccess':
				callback_function(this.form, this.response, this.json);
				break;
				
			case 'onComplete':
			case 'onFailure':
				callback_function(this.form, this.response);
				break;
			
			default:
				return false;
			break;
		}
		return true;
	}
});

// Callbacks graph:
//
//         start
//       ____|___
//	    |http ok?|
//         /  \
// 		  /    \
// failure    success
//     |    ____|______
//     |   |data saved?|
//     |        /\
//     \    save  reject
//      \     |     /
// 	     \    |    /
//         complete