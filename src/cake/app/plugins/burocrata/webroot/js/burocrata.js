var BuroForm = Class.create({
	initialize: function()
	{
		this.url = arguments[0];

		this.form = $(arguments[1]);
		this.form.reset = this.resetForm.bind(this);

		this.submit = $(arguments[2]);
		this.submit.observe('click', this.submits.bind(this));
	},
	resetForm: function()
	{
		
	},
	submits: function(ev)
	{
		var data = Form.serializeElements(Form.getElements(this.form));
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
	},
	trigger: function(callback)
	{
		if(!this.callbacks.get(callback))
			return;

		switch(callback)
		{
			case 'onStart':
				this.callbacks.get(callback)(this.form);
				break;
			
			case 'onSave': 
			case 'onReject': 
				this.callbacks.get(callback)(this.form, this.response, this.json, this.json.saved);
				break;
				
			case 'onSuccess':
				this.callbacks.get(callback)(this.form, this.response, this.json);
				break;
				
			case 'onComplete':
			case 'onFailure':
				this.callbacks.get(callback)(this.form, this.response);
				break;
			
			default:
			break;
		}
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