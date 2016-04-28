
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

var E_NOT_JSON = 1; // Not a JSON response
var E_JSON = 2; // JSON tells me the error
var E_NOT_AUTH = 3; // Server sended a 403 (Not Authorized) code


document.observe('dom:loaded', function(ev){
	Element.addMethods({
		getForm: function(element)
		{
			if (!(element = $(element))) return;
			if (!BuroCR) return;
			if (!(id = element.readAttribute('buro:form'))) return;
			
			return BuroCR.get('frm'+id);
		}
	})
})


/**
 * A instance of a Hash-like class, without overwriting of values, to keep
 * a list of instace objects used to keep all created classes
 * during the script.
 *
 * @access public
 * @todo An garbage colletor to free all not instanciated objects
 */
var BuroCR = new (Class.create(Hash, {
	set: function($super, id, obj)
	{
		if (this.get(id))
			return false;
		
		return $super(id, obj);
	}
}))();


/**
 * Caption manager
 *
 * BuroCaption is an instace at window scope that is used to retrieve
 * a caption given a namespace and a key.
 *
 * If either do not exists at the calling time, than it issues an error
 *
 * @access public
 */
var BuroCaption = new (Class.create({
	initialize: function()
	{
	},
	get: function(space, key, interpolateData)
	{
		if (!this.isSet(space, key))
			throw "BuroCaption::get() - Pair space/key given ("+space+"/"+key+") is not set.";

		var caption = buroCaptions[space][key];
		if (typeof interpolateData == 'object')
			caption = caption.interpolate(interpolateData);

		return caption;
	},
	isSet: function(space, key)
	{
		if (Object.isUndefined(buroCaptions[space]))
			return false;
		if (Object.isUndefined(buroCaptions[space][key]))
			return false;
		return true;
	},
	merge: function(data)
	{
		if (typeof data != 'object')
			throw "BuroCaption::merge() - Data must be an object";

		for (space in data)
		{
			if (typeof data[space] != 'object')
				throw "BuroCaption::merge() - Data inside each space must be object";

			for (key in data[space])
			{
				if (!buroCaptions[space])
					buroCaptions[space] = {};
				buroCaptions[space][key] = data[space][key];
			}
		}
	}
}))();


/**
 * Abstract class that implements the behaviour of callbacks
 * with the methods `addCallbacks` and `trigger`
 * It works like Events
 * 
 * @access protected
 */
var BuroCallbackable = Class.create({
	addCallbacks: function(callbacks)
	{
		if (!Object.isHash(this.callbacks))
			this.callbacks = $H({});
		
		callbacks = $H(callbacks);
		if (callbacks.size())
			callbacks.each(this.mergeCallback.bind(this));
		
		return this;
	},
	removeCallback: function(name, _function)
	{
		if (Object.isUndefined(name))
		{
			this.callbacks.keys().each(function(key) {
				this.callbacks.unset(key);
			}.bind(this));
		}
		else
		{
			var callbacks = this.callbacks.get(name);
			if (Object.isFunction(_function) && (index = callbacks.indexOf(_function)) != -1)
				callbacks.splice(index,1);
			else if (Object.isUndefined(_function))
				callbacks = [];
			
			this.callbacks.set(name, callbacks);
		}
		return this;
	},
	mergeCallback: function(pair)
	{
		var name = pair.key,
			_function = pair.value;
			
		var callback = this.callbacks.get(name);
		if (!Object.isArray(callback))
			callback = [];
		
		callback.push(_function);
		this.callbacks.set(name, callback);
	},
	isRegistred: function(callback)
	{
		return Object.isArray(this.callbacks.get(callback));
	},
	trigger: function()
	{
		if (Object.isUndefined(this.callbacks))
			this.callbacks = $H({});
		
		var name = arguments[0];
		if (!this.isRegistred(name))
			return false;
		
		var i,args = new Array();
		for(i = 1; i < arguments.length; i++)
			args.push(arguments[i]);
		
		try {
			this.callbacks.get(name).invoke('apply', this, args);
		} catch(e)
		{
			if (debug && console && console.error)
				console.error(e);
		}
		
		return true;
	}
});


/**
 * Adds all javascript functionality to the form.
 *
 * Callbacks:
 * - `onStart` function (form){}
 * - `onComplete` function (form, response){}
 * - `onFailure` function (form, response){}
 * - `onError` function (code, error){}
 * - `onSave` function (form, response, json, saved){}
 * - `onReject` function (form, response, json, saved){}
 * - `onSuccess` function (form, response, json){}
 *
 * @access public
 */
var BuroForm = Class.create(BuroCallbackable, {
	initialize: function()
	{
		this.params = $H({});
		var n_args = arguments.length;
		
		if (n_args > 0)
			this.url = arguments[0];

		if (n_args > 1)
		{
			this.id_base = arguments[1];
			this.form = $('frm' + this.id_base);
			
			if (!this.form)
				return;
			
			this.form.lock = this.lockForm.bind(this);
			this.form.unlock = this.unlockForm.bind(this);
			this.form.observe('keypress', this.keyPress.bind(this));

			BuroCR.set(this.form.id, this);
			
			this.submit = $('sbmt' + this.id_base);
			if (this.submit)
				this.submit.observe('click', this.submits.bind(this));
			
			this.cancel = $('cncl' + this.id_base);
			if (this.cancel)
				this.cancel.observe('click', this.cancels.bind(this));
		}
		
		if (n_args > 2)
		{
			this.addCallbacks(arguments[3]);
		}
		
		if (n_args > 3)
		{
			this.addParameters(arguments[4]);
		}
		
		(function(){
			this.lastSavedData = this.serialize();
		}).bind(this).defer(1);
	},
	reset: function()
	{
		this.inputs.each(this.resetInput.bind(this));
		this.trigger('onReset', this.form);
		return this;
	},
	resetInput: function(input)
	{
		switch (input.nodeName.toLowerCase())
		{
			case 'textarea':
				input.value = input.innerHTML;
				break;

			case 'input':
				switch (input.type)
				{
					case 'text':
					case 'file':
					case 'password':
						input.value = input.readAttribute('value');
						break;

					case 'radio':
					case 'checkbox':
						input.checked = input.readAttribute('checked');
						break;
				}
				break;

			case 'select':
				$A(input.options).each(function(option)
				{
					option.selected = option.readAttribute('selected');
				});
				break;
		}
	},
	addParameters: function(params, pattern)
	{
		if (Object.isString(params) || Object.isArray(params))
		{
			throw new Error('Form.addParameters method accepts only objects or Hashes.');
			return;
		}
		
		params = $H(params);
		
		if (pattern) 
		{
			params.each(function(pattern, pair) {
				this.set(pair.key, pair.value.interpolate(pattern));
			}.bind(params, pattern));
		}
		
		this.params = this.params.merge(params);

		return this;
	},
	lockForm: function()
	{
		this.inputs.each(Form.Element.disable);
		return this;
	},
	unlockForm: function()
	{
		this.inputs.each(Form.Element.enable);
		return this;
	},
	keyPress: function(ev){
		var element = ev.findElement().nodeName.toLowerCase();
		var key = ev.keyCode;
		if (ev.ctrlKey && key == Event.KEY_RETURN && element == 'input' && confirm('Deseja enviar os dados do formulário?'))
		{
			ev.stop();
			this.submits();
		}
	},
	submits: function(ev)
	{
		if (this.ajax && !this.ajax.done())
			return;
		
		this.updateLastSavedData();
		
		this.trigger('onStart', this.form);
		this.ajax = new BuroAjax(
			this.url,
			{parameters: this.lastSavedData},
			{
				onError: function(code, error) {
					this.trigger('onError', code, error);
				}.bind(this),
				
				onComplete: function (response) {
					this.trigger('onComplete', this.form, response);
				}.bind(this),
				
				onFailure: function (response) {
					this.trigger('onFailure', this.form, response); // Page not found
				}.bind(this),
				
				onSuccess: function (response, json) {
					this.json = json;
					if (!Object.isUndefined(this.json.saved))
					{
						if (json.saved)
							this.trigger('onSave', this.form, response, this.json, this.json.saved);
						else
							this.trigger('onReject', this.form, response, this.json, this.json.saved);
					}
					this.trigger('onSuccess', this.form, response, this.json);
				}.bind(this)
			}
		);
		return this;
	},
	cancels: function(ev)
	{
		ev.stop();
		this.trigger('onCancel', this.form);
		return this;
	},
	purge: function()
	{
		BuroCR.unset(this.id_base);
		this.form.stopObserving('keypress');
		if (this.submit)
			this.submit.stopObserving('click');
		if (this.cancel)
			this.cancel.stopObserving('click');
		if (this.form.up('body'))
			this.form.remove();
		this.removeCallback();
		this.cancel = this.submit = this.form = null;
	},
	updateLastSavedData: function()
	{
		this.lastSavedData = this.serialize();
	},
	serialize: function()
	{
		this.inputs = $$('[buro\\:form="'+this.id_base+'"]');
		
		var data = Form.serializeElements(this.inputs, {hash:true});
		data = $H(data).merge(this.params);
		return data;
	},
	changed: function()
	{
		return this.lastSavedData.toQueryString() != this.serialize().toQueryString();
	}
});

// Callbacks graph:
//
//         start
//       ____|___
//     |http ok?|
//         /  \
//        /    \
// failure    success
//     |    ____|______
//     |   |data saved?|
//     |        /\
//     \    save  reject
//      \     |     /
//       \    |    /
//         complete

/**
 * Extends the default Autocomplete built in Scriptaculous.
 *
 * Callbacks:
 * - `onStart` function (input){}
 * - `onComplete` function (input, response){}
 * - `onFailure` function (input, response){}
 * - `onError` function (code, error){}
 * - `onSuccess` function (input, response, json){}
 * - `onSelect` function (input, response, json){}
 * 
 * @access public
 */
var BuroAutocomplete = Class.create(BuroCallbackable, {
	initialize: function(url, id_base, options)
	{
		BuroCR.set(id_base, this);
		
		var id_of_text_field = 'input'+id_base,
			id_of_div_to_populate = 'div'+id_base;
		options.updateElement = this.alternateUpdateElement.bind(this);
		options.onHide = this.onHide.bind(this);
		
		
		Ajax.Autocompleter.addMethods({
			markPrevious: function() {
				if (this.index > 0) this.index--;
				else this.index = this.entryCount-1;
				if (this.getEntry(this.index).cumulativeOffset().top < document.viewport.getScrollOffsets().top)
					this.getEntry(this.index).scrollIntoView(true);
			},
			markNext: function() {
				if (this.index < this.entryCount-1) this.index++;
				else this.index = 0;
				if (this.getEntry(this.index).cumulativeOffset().top+this.getEntry(this.index).getHeight() > document.viewport.getScrollOffsets().top+document.viewport.getHeight())
					this.getEntry(this.index).scrollIntoView(false);
			}
		});
		
		
		this.autocompleter = new Ajax.Autocompleter(id_of_text_field, id_of_div_to_populate, url, options);
		this.autocompleter.options.onComplete = this.onComplete.bind(this);
		this.autocompleter.options.onFailure = this.onFailure.bind(this);
		this.autocompleter.options.onSuccess = this.onSuccess.bind(this);
		this.autocompleter.options.onCreate = this.onCreate.bind(this);
		
		this.onShow = this.autocompleter.options.onShow;
		this.autocompleter.options.onShow = this.onShowTrap.bind(this);
		
		this.input = this.autocompleter.element;
		this.pair = {};
		
		while(tmp = this.autocompleter.update.next('.message'))
			this.autocompleter.update.insert(tmp);
	},
	
	onHide: function(element, update)
	{
		new Effect.Fade(update,{duration:0.15});
		this.trigger('onHide');
	},
	
	onShowTrap: function(element, update)
	{
		this.autocomplete.update.setOpacity(1);
		this.onShow(element, update);
		this.trigger('onShow');
	},
	
	onSuccess: function(response)
	{
		if (response && response.responseJSON)
			this.trigger('onSuccess', this.input, response, response.responseJSON);
	},
	
	onFailure: function(response)
	{
		this.trigger('onFailure', this.input, response);
	},
	
	onCreate: function()
	{
		if (!this.autocompleter.update.visible()) {
			this.autocompleter.update.show().setLoading();
			this.autocompleter.update.select('div.message').each(Element.hide);
		}
		this.trigger('onStart', this.input);
	},
	
	onComplete: function(response)
	{
		if (!response.getAllHeaders())
			this.trigger('onFailure', this.form, response); // No server response
		
		if (!response.responseJSON) {
			this.trigger('onError', E_NOT_JSON);
			return;
		}
		
		this.json = response.responseJSON;
		if (this.json.error != false)
		{
			this.trigger('onError', E_JSON, this.json.error);
			return;
		}
		if (Object.isArray(this.json.content))
			this.json.content = {};
		this.foundContent = $H(this.json.content);
		
		var ac = this.autocompleter;
		
		ac.update.unsetLoading();
		if (!ac.update.down('ul'))
			ac.update.insert({top: new Element('ul')});
		ac.update.down('ul').replace(this.createChoices());
		
		if (!ac.changed && ac.hasFocus)
		{
			Element.cleanWhitespace(ac.update);
			Element.cleanWhitespace(ac.update.down());

			if (ac.update.firstChild && ac.update.down().childNodes) {
				ac.entryCount =
					ac.update.down('ul').childNodes.length;
				for (var i = 0; i < ac.entryCount; i++) {
					var entry = ac.getEntry(i);
					entry.autocompleteIndex = i;
					ac.addObservers(entry);
				}
			} else {
				ac.entryCount = 0;
			}

			ac.stopIndicator();
			ac.index = 0;

			if (ac.entryCount==1 && ac.options.autoSelect) {
				ac.selectEntry();
				ac.hide();
			} else {
				ac.render();
			}
		}
		ac.update.setOpacity(1);
		if (ac.entryCount != 1)
			ac.update.down('.nothing_found').hide();
		else
			ac.update.down('.nothing_found').show();
		
		this.trigger('onUpdate', this.input, response);
	},
	
	createChoices: function()
	{
		var i, ul = new Element('ul');
		var keys = this.foundContent.keys();
		for(i = 0; i < keys.length; i++)
			ul.insert(new Element('li').update(this.foundContent.get(keys[i])));
		ul.insert(new Element('li').hide());
		return ul;
	},
	
	alternateUpdateElement: function(selectedElement)
	{
		var keys = this.foundContent.keys();
		if (!keys.length)
			return false;
		
		this.pair.id = keys[this.autocompleter.index];
		this.pair.value = this.foundContent.get(this.pair.id);
		this.trigger('onSelect', this.input, this.pair, selectedElement);
	}
});


/**
 * Extends the default Ajax.Request built in Prototype.
 *
 * It is possible to create a ajax dump for each request, just letting the debug
 * config from cake != 0 and setting window.ajax_dump = true (on JS console)
 * Also, if an request didnt return ajax and it debug != 0, it asks if you want a dump.
 *
 * Callbacks:
 * - `onStart` function (){}
 * - `onComplete` function (response){}
 * - `onFailure` function (response){}
 * - `onError` function (code, error, json){}
 * - `onSuccess` function (response, json){}
 * 
 * @access public
 */
var BuroAjax = Class.create(BuroCallbackable, {
	initialize: function(url, options, callbacks)
	{
		this.addCallbacks(callbacks);
		
		this.url = url;
		this.fulldebug = debug != 0 && !Object.isUndefined(window.ajax_dump) && window.ajax_dump == true;
		
		this.ajax_options = {};
		this.ajax_options.parameters = options.parameters;
		this.ajax_options.onComplete = this.requestOnComplete.bind(this);
		this.ajax_options.onSuccess = this.requestOnSuccess.bind(this);
		this.ajax_options.onFailure = this.requestOnFailure.bind(this);
		
		this.trigger('onStart');
		
		this.request = new Ajax.Request(this.url, this.ajax_options);
	},
	done: function()
	{
		return this.request._complete;
	},
	requestOnComplete: function (re) {
		this.trigger('onComplete', re);
		if (this.fulldebug)
			this.dumpResquest(re);
	},
	requestOnSuccess: function(re)
	{
		var json = false;
		if (re.responseJSON) json = re.responseJSON;
		
		if (!re.getAllHeaders()) {
			this.trigger('onFailure', re); // No server response
		} else if (!json) {
			this.trigger('onError', E_NOT_JSON);
			if (debug != 0 && !this.fulldebug)
				this.dumpResquest(re);
		} else {
			if (json.extraCaptions) {
				BuroCaption.merge(json.extraCaptions);
				delete json.extraCaptions;
			}
			
			if (json.error != false) {
				this.trigger('onError', E_JSON, json.error, json);
			} else {
				this.trigger('onSuccess', re, json);
			}
		}
	},
	requestOnFailure: function(re)
	{
		switch (re.status)
		{
			case 403: // Not Authorized
				if (this.isRegistred('onError'))
				{
					this.trigger('onError', E_NOT_AUTH); 
					break;
				}
			
			default:
				this.trigger('onFailure', re); // Page not found
		}
	},
	dumpResquest: function(re)
	{
		if (!confirm('This last request didn\'t return a valid JSON.\nDo you want to create a dump of this request?\n\nNote: to close the created dump, just double click on it.'))
			return;
		
		var div = new Element('div', {className: 'dump_ajax'})
			.insert(new Element('div', {className: 'dump_config'})
				.insert('<h1>Call config</h1>')
				.insert(new Element('div', {className: 'dump_content'})
					.insert(new Element('pre')
						.insert('URL: '+this.url+'<br />')
						.insert(Object.toJSON(this.ajax_options))
					)
				)
			)
			.insert(new Element('div', {className: 'dump_code'})
				.insert('<h1>Response status</h1>')
				.insert(new Element('div', {className: 'dump_content'})
					.insert('HTTP status: '+re.status+' ('+re.statusText+')')
				)
			)
			.insert(new Element('div', {className: 'dump_headers'})
				.insert('<h1>Response headers</h1>')
				.insert(new Element('div', {className: 'dump_content'})
					.insert(new Element('pre').update(re.getAllHeaders()))
				)
			)
			.insert(new Element('div', {className: 'dump_content_code'})
				.insert('<h1>Response complete code</h1>')
				.insert(new Element('div', {className: 'dump_content'})
					.insert(new Element('pre').update(re.responseText.unfilterJSON().escapeHTML()))
				)
			)
			.insert(new Element('div', {className: 'dump_code'})
				.insert('<h1>Response content</h1>')
				.insert(new Element('div', {className: 'dump_content'})
					.insert(re.responseText/* .replace(/\{"\w+":.*\}/, '') */)
				)
			)
		;
		
		div.observe('dblclick', function(ev){ev.findElement('div.dump_ajax').remove(); ev.stop();});
		document.body.insert({bottom: div});
		Effect.ScrollTo(div);
	}
});




/**
 * How it works: on load, if passed true on update_on_load, it will try to update the 
 * display div and hide the autocomplete input. Else, it will hide the autocomplete
 * input.
 *
 * Callbacks:
 * - `onInitilize` function (response){}
 * - `onComplete` function (response){}
 * - `onFailure` function (response){}
 * - `onError` function (code, error){}
 * - `onSuccess` function (response, json){}
 * 
 * @access public
 */
var BuroBelongsTo = Class.create(BuroCallbackable, {
	baseFxDuration: 0.3,
	initialize: function(id_base, autocompleter_id_base, update_on_load, callbacks)
	{
		this.form = false;
		this.id_base = id_base;
		BuroCR.set(this.id_base, this);
		
		this.autocomplete = BuroCR.get(autocompleter_id_base);
		
		this.addCallbacks(callbacks);
		
		this.input = $('hii'+id_base);
		this.divBase = $('div'+id_base);
		this.update = $('update'+id_base);
		this.error = $('error'+id_base);
		this.actions = this.update.next('.actions');
		this.actions.select('a').each(this.observeControls.bind(this));
		this.observeControls(this.autocomplete.autocompleter.update.down('.action a'));
		
		if (this.input.value.empty())
		{
			this.reset(false).setActions('');
		}
		else
		{
			if (!update_on_load)
				this.setActions('edit reset').hideAutocomplete();
			else
				this.showPreview();
		}
		this.queue = {position:'end', scope: this.id_base};
	},
	reset: function(animate)
	{
		if (!this.input.value.blank())
			this.backup_id = this.input.value;
		this.input.value = this.autocomplete.input.value = '';
		this.autocomplete.input.show();
		this.autocomplete.input.removeAttribute('disabled');
		
		if (!this.input.value.blank())
			this.setActions('undo_reset');
		
		if (!animate)
		{
			this.update.hide();
		}
		else
		{
			this.update.setStyle({height: (this.update.getHeight()-this.autocomplete.input.getHeight())+'px'});
			new Effect.BlindUp(this.update, {duration: this.baseFxDuration, queue: this.queue});
		}
		
		this.error.show();
		
		return this;
	},
	observeControls: function(element)
	{
		if (Object.isElement(element) || Object.isElement(element = $(element)))
			element.observe('click', this.controlClick.bindAsEventListener(this, element));
		return this;
	},
	controlClick: function(ev, element)
	{
		ev.stop();
		this.setActions('');
		var action = element.readAttribute('buro:action');
		switch (action)
		{
			case 'new':
				this.update.setLoading();
				this.trigger('onAction', action);
			break;
			
			case 'edit':
				this.update.setLoading();
				this.trigger('onAction', action, this.input.value);
			break;
			
			case 'reset':
				this.reset(true);
			break;
			
			case 'undo_reset':
				this.input.value = this.backup_id;
				this.hideAutocomplete().showPreview();
				this.error.show();
			break;
		}
	},
	actionSuccess: function(json)
	{
		if (this.form)
			this.form.purge();
		this.form = false;
		
		var iHeight = this.update.show().unsetLoading().getHeight(),
			fHeight = this.update.update(json.content).getHeight();
		
		//disable the autocomplete field
		this.autocomplete.input.disable();
		
		//find the field with the same name of the autocompleter,
		//to populate it with autocomplete content
		var name, input;
		if (json.action == 'new')
		{
			name = 'data'+this.autocomplete.input.name.substr(22);
			if (input = this.update.down('input[name="'+name+'"]'))
				input.value = this.autocomplete.input.value;
		}
		
		this.update.setStyle({height: iHeight+'px', overflow: 'hidden'});
		new Effect.Morph(this.update, {
			duration: this.baseFxDuration, 
			queue: this.queue, 
			style: {height: fHeight+'px'},
			afterFinish: function(action, fx) {
				this.update.setStyle({height: '', overflow: ''});
				this.observeForm();
				this.setActions('');
				if (action == 'preview')
					this.setActions('edit reset').hideAutocomplete();
				if (action == 'preview' || action == 'new')
					this.error.hide();
			}.bind(this, json.action)
		});
	},
	actionError: function(json)
	{
		this.trigger('onError');
	},
	observeForm: function()
	{
		var form_id = false,
			div_form = this.update.down('.buro_form');
		
		if (Object.isElement(div_form))
			if (form_id = div_form.readAttribute('id'))
				this.form = BuroCR.get(form_id).addCallbacks({
					onStart: function(form){form.setLoading().lock();},
					onCancel: this.cancel.bind(this),
					onSave: this.saved.bind(this),
					onReject: this.reject.bind(this)
				});
	},
	showPreview: function()
	{
		this.update.update().show().setLoading();
		this.trigger('onAction', 'preview', this.input.value);
	},
	saved: function(form, response, json, saved)
	{
		this.form.form.unsetLoading().unlock();
		this.autocomplete.input.value = '';
		this.input.value = saved;
		this.showPreview();
	},
	reject: function(form, response, json, saved)
	{
		this.form.form.unsetLoading().purge();
		this.update.update(json.content);
		this.observeForm.bind(this).delay(0.1);
	},
	cancel: function()
	{
		var content = this.update.innerHTML,
			iHeight = this.update.show().getHeight(),
			fHeight = this.update.update().setLoading().getHeight();
		
		this.update.unsetLoading().update(content).setStyle({height: iHeight+'px', overflow: 'hidden'});
		
		new Effect.Morph(this.update, {
			duration: this.baseFxDuration, 
			queue: this.queue, 
			style: {height: fHeight+'px'},
			afterFinish: function(fx) {
				if (!this.input.value.blank())
					this.showPreview();
				else
					this.reset();
			}.bind(this)
		});
	},
	ACUpdated: function()
	{
		var new_item = this.autocomplete.autocompleter.update.down('.action');
		if (new_item)
			new_item.show();
	},
	ACSelected: function(pair)
	{
		this.hideAutocomplete();
		this.input.value = pair.id;
		this.showPreview();
	},
	setActions: function(filter)
	{
		var links = this.actions.select('a'),
			filter = function(filter, link) {
				return $w(filter).indexOf(link.readAttribute('buro:action')) != -1;
			}.curry(filter);
		
		links.invoke('hide').findAll(filter).invoke('show');
		return this;
	},
	showAutocomplete: function() {this.autocomplete.input.show(); return this;},
	hideAutocomplete: function() {this.autocomplete.input.hide(); return this;}
});




/**
 * The main class for a list of items. It handles all ajax calls
 * 
 * ***How it works:***
 *
 *  - This class receives the templates for an item and for an menu.
 *  - Also it receives all already saved contents and renders it on initialize using the item template.
 *  - This class keeps updated two arrays (one for the items objects `BuroListOfItemsItem` and other
 *     for the menu objects `BuroListOfItemsMenu`)
 *  - Each item created has a callback called `buro:controlClick` (actions up, down, duplicate...) that
 *     is mapped here to method BuroListOfItems.routeAction(item, action, id) that triggers its own 
 *     `onAction` callback that is coded on BuroBurocrataHelper::_orderedItensManyChildren method
 *  - The `onAction` callback performs an ajax call witch, when is complete, calls 
 *     BuroListOfItems.actionError(json) or BuroListOfItems.actionSuccess(json) depending on response
 *  - The BuroListOfItems.actionSuccess(json) method do on user interface what the controllers and
 *     models did on backstage.
 *  - Each menu object created has a callback named `buro:newItem` that is mapped here to
 *     BuroListOfItems.newItem() method that opens a form right below the menu div
 *  - When a form is opened, this class searches for it and observes its main callbacks (like `onError`, 
 *    `onCancel` and `onSave`) to make possible do the necessary changes after the submit.
 *  
 *  
 * @access public
 * @param string id_base The master ID used to find one specific instance of this class and elements on HTML
 * @param object parameters A list of parameters to be sent with all requests.
 * @param object content A object with 3 properties: texts (object), templates (object), contents (array)
 */
var BuroListOfItems = Class.create(BuroCallbackable, {
	baseFxDuration: 0.3, //in seconds
	initialize: function(id_base, parameters, content)
	{
		this.templates = content.templates || {menu: '', item: ''};
		this.contents = content.contents || [];
		this.texts = content.texts || {};
		this.parameters = parameters || {};
		this.url = content.url;
		
		this.menus = [];
		this.items = [];
		
		this.id_base = id_base;
		BuroCR.set(this.id_base, this);
		
		this.divCont = $('div'+id_base);
		this.divCont.insert(this.divForm = new Element('div', {id: 'divform'+id_base}).hide());
		
		this.addNewMenu();
		this.contents.each(this.addNewItem.bind(this));
		
		this.editing = false;
		this.queue = {position:'end', scope: this.id_base};
	},
	
	addNewMenu: function(order)
	{
		var div, prevMenu = false;
		
		if (Object.isUndefined(order) || order > this.menus.length)
			order = this.menus.length;
		
		if (this.menus.length > order)
			prevMenu = this.menus[order];
		
		this.menus.each(function(order, menu) {
			if (Number(menu.order) >= order)
				menu.setOrder(Number(menu.order)+1);
		}.curry(order));
		
		div = new Element('div').insert(this.templates.menu.interpolate({order:order})).down();
		
		if (prevMenu)
			prevMenu.div.insert({before:div});
		else
			this.divCont.insert(div);
		
		this.menus.push(this.createMenu(div));
		this.reorderMenuList();
		return this;
	},
	createMenu: function(div)
	{
		return new BuroListOfItemsMenu(div).addCallbacks({'buro:newItem': this.newItem.bind(this)});
	},
	removeMenu: function(div)
	{
		var order = Number(div.readAttribute('buro:order'));
		this.menus.splice(order, 1);
		div.remove();
		this.menus.each(function(order, menu) {
			if (menu.order >= order)
				menu.setOrder(Number(menu.order)-1);
		}.curry(order));
		
		return this;
	},
	reorderMenuList: function()
	{
		return this.menus = this.menus.sortBy(function(menu) {
			return Number(menu.order);
		});
	},
	
	addNewItem: function(data, order, animate)
	{
		var item,content, div;
		if ((!data.title || data.title.blank()) && this.texts.title)
			data.title = this.texts.title;
		
		content = this.templates.item.interpolate(data),
		div = new Element('div').insert(content).down();					
		
		this.addNewMenu(order);
		if (this.menus[order])
			this.menus[order].div.insert({after: div});
		
		
		item = new BuroListOfItemsItem(div, this).addCallbacks({'buro:controlClick': this.routeAction.bind(this)})
		this.items.push(item);
		this.updateSiblings(item);
		
		
		if (animate)
			new Effect.BlindDown(div, {
				queue: this.queue, 
				duration: this.baseFxDuration
			});
		
		return this;
	},
	removeItem: function(item)
	{
		this.items.splice(this.items.indexOf(item), 1);
		
		item.div.unsetLoading();
		new Effect.BlindUp(item.div, {
			queue: this.queue,
			duration: this.baseFxDuration,
			afterFinish: function(item, eff) {
				var prev = this.getItem(item.getPrev()), 
					next = this.getItem(item.getNext());
				item.div.remove();
				if (prev) prev.checkSiblings();
				if (next) next.checkSiblings();
			}.bind(this, item)
		});
		return this;
	},
	updateSiblings: function(item)
	{
		var prev = this.getItem(item.getPrev()), 
			next = this.getItem(item.getNext());
		if (prev) prev.checkSiblings();
		if (next) next.checkSiblings();
	},
	
	newItem: function(menuObj, contentType)
	{
		this.currentContentType = contentType;
		if (this.placesForm(menuObj))
			this.trigger('onAction', 'edit', '', contentType);
	},
	placesForm: function(obj)
	{
		if (this.editing !== false)
			return false;
		obj.div.insert({after: this.divForm}).hide().unsetLoading();
		this.divForm.show().setLoading();
		this.editing = obj;
		this.menus.each(function(menu){
			menu.disable();
		});
		return true;
	},
	openForm: function(content)
	{
		var iHeight = this.editing.id ? this.editing.div.getHeight() : this.divForm.getHeight(),
			fHeight = this.divForm.update(content).setStyle({height:''}).getHeight();
		
		this.divForm.unsetLoading().setStyle({overflow:'hidden', height: iHeight+'px'});
		
		new Effect.Morph(this.divForm, {
			queue: this.queue,
			duration: this.baseFxDuration,
			style: {height: fHeight+'px'},
			afterFinish: function () {
				this.divForm.setStyle({overflow: '', height:''}).scrollVisible();
				this.injectControlOnForm();
			}.bind(this)
		});
	},
	closeForm: function()
	{
		var fHeight = this.editing.id ? this.editing.div.getHeight() : 0;
		
		this.divForm.unsetLoading().setStyle({overflow: 'hidden'});
		
		new Effect.Morph(this.divForm, {
			queue: this.queue,
			duration: this.baseFxDuration,
			style: {height: fHeight+'px'},
			afterFinish: function() {
				if (this.editing)
					this.editing.div.show();
				this.editing = false;
				this.menus.each(function(menu){
					menu.close().enable();
				});
				this.divForm.update().hide().setStyle({overflow: ''});
				this.trigger('onFormClose');
			}.bind(this)
		});
	},
	getOpenedForm: function()
	{
		var form_id = this.divForm.down('.buro_form') && this.divForm.down('.buro_form').readAttribute('id');
		return BuroCR.get(form_id);
	},
	injectControlOnForm: function()
	{
		var OpenedForm = this.getOpenedForm();
		if (OpenedForm)
		{
			OpenedForm.url = this.url;
			OpenedForm.addParameters(this.parameters.request);
			OpenedForm.addParameters(this.parameters.buroAction);
			OpenedForm.addParameters(this.parameters.fkBounding);
			
			if (this.currentContentType && this.parameters.contentType);
				OpenedForm.addParameters(this.parameters.contentType, {content_type: this.currentContentType});
			
			// If it doens't exists (creating)
			if (this.editing.order && this.parameters.orderField)
				OpenedForm.addParameters(this.parameters.orderField, {order: Number(this.editing.order)+1});
			
			// If it already exists (editing)
			if (this.editing.id)
				OpenedForm.addParameters(this.parameters.contentId, {id: this.editing.id});
			
			OpenedForm.addCallbacks({
				onStart: function(form) {
					form.lock();
					this.divForm.down().setLoading();
				}.bind(this),
				onComplete: function(form) {
					form.unlock();
				},
				onCancel: this.formCanceled.bind(this),
				onSave: this.formSaved.bind(this),
				onError: this.formError.bind(this),
				onReject: this.formRejected.bind(this)
			});
			this.trigger('onShowForm', OpenedForm);
		}
	},
	formSaved: function(form, response, json)
	{
		var id = this.editing.id || json.saved;
		if (id)
			this.trigger('onAction', 'afterEdit', id);
	},
	formCanceled: function()
	{
		this.closeForm();
	},
	formRejected: function(form, response, json)
	{
		this.divForm.down().unsetLoading();
		this.openForm(json.content);
	},
	formError: function(code, error)
	{
		if (this.texts.error)
			alert(this.texts.error);
		else if (debug)
		{
			if (code == E_JSON)
				alert(error);
		}
	},
	routeAction: function(item, action, id)
	{
		var prev, next;
		if (!action || (!Object.isUndefined(this.texts.confirm[action]) && !confirm(this.texts.confirm[action])))
			return;
		
		item.div.setLoading();
		if (action == 'up' && (prev = item.getPrev()))	 this.getItem(prev).div.setLoading();
		if (action == 'down' && (next = item.getNext())) this.getItem(next).div.setLoading();
		
		this.trigger('onAction', action, id);
	},
	actionError: function(json)
	{
		this.items.each(function(item){
			item.div.unsetLoading();
		});
		if (this.editing)
			this.closeForm();
		this.trigger('onError', json);
	},
	actionSuccess: function(json)
	{
		var item, prev, next;
		switch (json.action)
		{
			case 'down': 
				if (!json.id || !(item = this.getItem(json.id)) || !(next = this.getItem(item.getNext())))
					break;
				item.div.swapWith(next.div.unsetLoading()).unsetLoading();
				item.checkSiblings();
				next.checkSiblings();
			break;
			
			case 'up': 
				if (!json.id || !(item = this.getItem(json.id)) || !(prev = this.getItem(item.getPrev())))
					break;
				item.div.swapWith(prev.div.unsetLoading()).unsetLoading();
				item.checkSiblings();
				prev.checkSiblings();
			break;
			
			case 'delete':
				if (!json.id || !(item = this.getItem(json.id)))
					break;
				
				this.removeMenu(item.div.next('.ordered_list_menu'));
				this.removeItem(item);
			break;
			
			case 'duplicate':
				if (!json.id || !json.old_id || !(item = this.getItem(json.old_id)))
					break;
				item.div.unsetLoading();
				this.addNewItem(json, json.order, true);
			break;
			
			case 'save':
			case 'edit':
				if (json.id && (item = this.getItem(json.id)))
				{
					this.divForm.setStyle({height: item.div.getHeight()+'px'});
					this.placesForm(item);
				}
				if (this.editing == false)
					break;
				this.openForm(json.content);
			break;
			
			case 'afterEdit':
				if (this.divForm.down())
					this.divForm.down().unsetLoading();
				
				if (this.editing.id == json.id) { // Finished editing an item that already exists
					this.editing.content.update(json.content);
				} else if (!Object.isUndefined(this.editing.order)) { // Finished editing a new item
					this.addNewItem({content: json.content, id: json.id, title: json.title}, this.editing.order);
				}
				
				this.closeForm();
			break;
		}
	},
	getItem: function(id)
	{
		if (Object.isElement(id)) 
			id = id.readAttribute('buro:id');
		var result = this.items.findAll(function(id, item) {return item.id == id}.curry(id));
		if (result.length)
			return result[0];
		return false;
	}
});


/**
 * Automatic ordering version of BuroListOfItems.
 * All specific methods and behaviors are implemented here.
 * 
 * @access public
 */
var BuroListOfItemsAutomatic = Class.create(BuroListOfItems, {
	addNewItem: function($super, data, order, animate, reference)
	{
		$super(data, order, animate);
		
		var item = this.items.last();
		
		reference = reference || this.menus[1].div;
		if (this.editing)
			reference = this.editing.div;
		
		item.disableOrderControl();
		if (reference == this.menus[1].div)
			reference.insert({before: item.div});
		else
			reference.insert({after: item.div});
		this.checkLast();
		return this;
	},
	addNewMenu: function($super, order)
	{
		if (this.menus.length < 2)
			$super(this.menus.length);
		return this;
	},
	removeMenu: function($super, div)
	{
		if (this.items.length == 1)
			$super(div);
		return this;
	},
	actionSuccess: function($super, json)
	{
		switch (json.action)
		{
			case 'duplicate':
				if (!json.id || !json.old_id || !(item = this.getItem(json.old_id)))
					break;
				item.div.unsetLoading();
				this.addNewItem(json, null, true, item.div);
				this.getItem(json.id).div.setLoading();
				this.trigger.bind(this,'onAction', 'afterEdit', json.id).delay(this.baseFxDuration);
			break;
			
			case 'afterEdit':
				$super(json);
				
				this.getItem(json.id).div.unsetLoading();
				
				if (Object.isArray(json.id_order))
				{
					var index = json.id_order.map(Number).indexOf(Number(json.id));
					
					if (this.items.length > 1)
					{
						if (index == 0)
							this.putItem(json.id_order[index], 'before', json.id_order[index+1], true);
						else
							this.putItem(json.id_order[index], 'after', json.id_order[index-1], true);
					}
				}
			break;
			
			default:
				$super(json);
		}
	},
	putItem: function(id, on, other_id, animate)
	{
		var item = this.getItem(id),
			other = this.getItem(other_id);
		if (item && item.div && other && other.div)
		{
			if (on == 'after' && other.getNext() == item.div || on == 'before' && item.getNext() == other.div)
				return;
			
			item.div.unsetLoading();
			other.div.unsetLoading();
			
			var div, insert, insertion = $H({});
			
			if (!animate)
			{
				insertion.set(on, item.div);
				other.div.insert(insertion.toObject());
			}
			else
			{
				insertion.set(on, div = new Element('div'));
				other.div.insert(insertion.toObject());
				
				new Effect.Morph(div, {
					style: {height: item.div.getHeight()+'px'},
					queue: this.queue,
					delay: this.baseFxDuration,
					duration: this.baseFxDuration,
					afterFinish: function(item, div, fx)
					{
						item.div
							.swapWith(div)
							.setStyle({
								position: 'relative',
								top: (div.cumulativeOffset().top-item.div.cumulativeOffset().top)+'px'
							});
					}.curry(item, div)
				});
				new Effect.Morph(item.div, {
					style: {top: '0px'},
					queue: this.queue,
					duration: this.baseFxDuration,
					afterFinish: function(item, div, fx)
					{
						item.div.setStyle({position:'', top: ''});
						this.checkLast();
					}.bind(this, item, div)
				});
				new Effect.Morph(div, {
					style: {height: '0px'},
					queue: this.queue,
					duration: this.baseFxDuration,
					afterFinish: function(fx)
					{
						fx.element.remove.bind(fx.element).defer();
					}
				});
			}
		}
	},
	checkLast: function()
	{
		var last = this.divCont.down('div.ordered_list_item.last_item'),
			items = this.divCont.select('div.ordered_list_item');
		if (last) 
			last.removeClassName('last_item');
		if (items.length)
			items.last().addClassName('last_item');
	},
	updateSiblings: function()
	{
		this.checkLast();
	}
});



/**
 * Class for the menu of a list of items. It triggers the `buro:newItem` callback 
 * when the creation of a new item is requested. If it has a list of contents, it triggers 
 * when the link of that content is clicked. If not (just one item), it triggers when the 
 * 'expand menu' link is clicked.
 * 
 * ### Callbacks:
 * - `buro:newItem` callback receive itself and the 'type' of content (when there is a list)
 * 
 * @access public
 * @param element div The div reference of menu container
 * @todo order?
 */
var BuroListOfItemsMenu = Class.create(BuroCallbackable, {
	initialize: function(div)
	{
		this.div = $(div);
		this.order = this.div.readAttribute('buro:order');
		
		this.plus_button = this.div.down('button.ordered_list_menu_add');
		this.plus_button.observe('click', this.plusClick.bind(this));

		this.menu = this.div.down('div.ordered_list_menu_list');
		
		this.links = this.menu.select('a.ordered_list_menu_link');
		this.links.each(function(lnk){lnk.observe('click', this.lnkClick.bind(this))}.bind(this));
		
		this.close_link = this.div.down('.ordered_list_menu_close>a');
		this.close_link.observe('click', function(ev){ ev.stop(); this.close();}.bind(this));
		
		this.border = this.div.down('.border');
		
		this.enable().close();
	},
	plusClick: function(ev)
	{
		ev.stop();
		if (this.links.length > 1) 
			this.open();
		else if (this.links.length == 1)
			this.trigger('buro:newItem', this, this.getType(this.links[0]));
	},
	lnkClick: function(ev)
	{
		ev.stop();
		var lnk = ev.findElement('a');
		if (lnk)
			this.trigger('buro:newItem', this, this.getType(lnk));
	},
	getType: function(lnk)
	{
		return lnk.readAttribute('buro:content_type');
	},
	open: function()
	{
		this.close_link.up().show();
		this.plus_button.hide();
		this.border.hide();
		new Effect.SlideDown(this.menu, {duration: 0.15});
		return this;
	},
	close: function(ev)
	{
		this.close_link.up().hide();
		this.plus_button.show();
		this.border.show();
		
		if (ev)	new Effect.SlideUp(this.menu, {duration: 0.15});
		else	this.menu.hide();
		
		return this;
	},
	setOrder: function(order)
	{
		if (Object.isNumber(order))
			this.div.writeAttribute('buro:order', this.order = order);
		return this;
	},
	hide: function()
	{
		this.div.hide();
		return this;
	},
	show: function()
	{
		this.div.show();
		return this;
	},
	disable: function()
	{
		Form.Element.disable(this.plus_button);
		return this;
	},
	enable: function()
	{
		Form.Element.enable(this.plus_button);
		return this;
	}
});

/**
 * Represents one item on list of items. It handles events on controls like (move up, move down, edit, etc)
 * It triggers a callback (`buro:controlClick`) every time a control is activeted and is passed what type of
 * callback was triggered (up, down, edit ... ).
 * It doesn't handles any kind of ajax requests by itself.
 * 
 * ### Callbacks
 * - `buro:controlClick` function(object, action) - It receive the object that triggered and an string describing the action
 * 
 * @access public
 * @param object list The object for the parent list
 * @param element div The div containing the item
 */
var BuroListOfItemsItem = Class.create(BuroCallbackable, {
	initialize: function (div, parent)
	{
		this.div = $(div);
		this.linksEnabled = true;
		this.id = this.div.readAttribute('buro:id');
		this.content = this.div.down('div.ordered_list_content');
		this.controls = this.div.down('.ordered_list_controls');
		this.controls.childElements().each(this.observeControls.bind(this));
		this.checkSiblings();

		parent.addCallbacks({
			'onFormClose': this.enableLinks.bind(this),
			'onShowForm': this.disableLinks.bind(this)
		});
	},
	enableLinks: function()
	{
		this.linksEnabled = true;
		this.controls.setOpacity(1);
		this.controls.childElements().invoke('removeClassName', 'disabled');
	},
	disableLinks: function()
	{
		this.linksEnabled = false;
		this.controls.setOpacity(0.5);
		this.controls.childElements().invoke('addClassName', 'disabled');
	},
	observeControls: function(element)
	{
		element.observe('click', this.controlClick.bindAsEventListener(this, element));
		return this;
	},
	controlClick: function(ev, element)
	{
		ev.stop();
		if (!this.linksEnabled)
			return;
		var action = element.readAttribute('buro:action');
		this.trigger('buro:controlClick', this, action, this.id);
	},
	checkSiblings: function()
	{
		this.controls.childElements().each(Form.Element.enable);
		if (!Object.isElement(this.getPrev())) Form.Element.disable(this.controls.down('.ordered_list_up'));
		if (!Object.isElement(this.getNext())) Form.Element.disable(this.controls.down('.ordered_list_down'));
		return this;
	},
	getNext: function()
	{
		return this.div.next('div.ordered_list_item');
	},
	getPrev: function()
	{
		return this.div.previous('div.ordered_list_item');
	},
	disableOrderControl: function()
	{
		this.controls.down('.ordered_list_up').hide();
		this.controls.down('.ordered_list_down').hide();
		return this;
	}
});





/**
 * 
 *
 * Callbacks:
 * - `onInitilize` function (response){}
 * - `onComplete` function (response){}
 * - `onFailure` function (response){}
 * - `onError` function (code, error){}
 * - `onSuccess` function (response, json){}
 * 
 * @access public
 */
var BuroEditableList = Class.create(BuroCallbackable, {
	baseFxDuration: 0.3,
	initialize: function(id_base, autocompleter_id_base, content, callbacks)
	{
		this.id_base = id_base;
		this.itemsList = $H({});
		this.form = false;
		Object.extend(this,content);
		
		BuroCR.set(this.id_base, this);
		
		this.update = $('update'+id_base);
		this.items = $('items'+id_base);
		this.autocomplete = BuroCR.get(autocompleter_id_base);
		this.observeControls(this.autocomplete.autocompleter.update.down('.action a'));
		
		this.addCallbacks(callbacks);
		
		if (this.contents)
			this.contents.each(this.addNewItem.bind(this));
		
		this.queue = {position:'end', scope: this.id_base};
	},
	observeControls: function(element)
	{
		if (Object.isElement(element) || Object.isElement(element = $(element)))
			element.observe('click', this.controlClick.bindAsEventListener(this, element));
		return this;
	},
	observeForm: function()
	{
		var form_id = false,
			div_form = this.update.down('.buro_form');
		
		if (Object.isElement(div_form))
			if (form_id = div_form.readAttribute('id'))
				this.form = BuroCR.get(form_id).addCallbacks({
					onStart: function(form){form.setLoading().lock();},
					onCancel: this.formCancel.bind(this),
					onSave: this.formSaved.bind(this)
				});
	},
	formCancel: function()
	{
		var content = this.update.innerHTML,
			iHeight = this.update.show().getHeight(),
			fHeight = this.update.update().setLoading().getHeight();
		
		this.update.unsetLoading().update(content).setStyle({height: iHeight+'px', overflow: 'hidden'});
		
		new Effect.Morph(this.update, {
			duration: this.baseFxDuration, 
			queue: this.queue, 
			style: {height: '0px'}
		});
	},
	formSaved: function(form, response, json, saved)
	{
		this.form.form.unsetLoading().unlock();
		new Effect.SlideUp(this.update, {
			duration: this.baseFxDuration, queue: this.queue,
			afterFinish: function()
			{
				if (this.form)
				{
					this.form.purge();
					this.form = false;
				}
			}.bind(this)
		});
		this.trigger('onAction', 'add', saved);
		this.items.setLoading();
	},
	controlClick: function(ev, element)
	{
		ev.stop();
		if (this.form)
			this.form.purge();
		this.form = false;
		
		var action = element.readAttribute('buro:action');
		switch (action)
		{
			case 'new':
				this.update.update().setLoading();
				this.trigger('onAction', action);
			break;
			
			case 'edit':
			case 'preview':
				this.update.update().setLoading();
				this.trigger('onAction', action, element.up('div').readAttribute('buro:id'));
			break;
			
			case 'unlink':
				if (confirm(this.texts.confirm_unlink))
					this.removeItem(element.up('div').readAttribute('buro:id'), true);
			break;
		}
	},
	addNewItem: function(data)
	{
		this.removeItem(data.id);
		var input = new Element('div').insert(this.templates.input.interpolate(data)).down(),
			item = new Element('div').insert(this.templates.item.interpolate($H(data).merge(this.texts).toObject())).down();
		
		this.itemsList.set(data.id, {input: input, item:item});
		this.items.insert(input).insert(item);
		
		item.down('.controls').select('a').each(this.observeControls.bind(this));
	},
	removeItem: function(id, animate)
	{
		var obj = this.itemsList.get(id);
		if (obj)
		{
			this.itemsList.unset(obj.input.value);
			
			obj.input.remove();
			if (animate)
				new Effect.Fade(obj.item, {
					duration: this.baseFxDuration, 
					afterFinish: function(eff) {
						window.setTimeout(Element.remove.curry(eff.element), 1000);
					}
				});
			else
				Element.remove(obj.item);
		}
	},
	actionError: function(json)
	{
		this.trigger('onError');
	},
	actionSuccess: function(json)
	{
		if (this.form)
			this.form.purge();
		this.form = false;
		
		switch (json.action)
		{
			case 'add':
				this.addNewItem(json);
				this.items.unsetLoading();
			break;
			
			case 'preview':
			case 'edit':
			default:
				var iHeight = this.update.show().unsetLoading().getHeight(),
					fHeight = this.update.update(json.content).getHeight();
				
				this.update.setStyle({height: iHeight+'px', overflow: 'hidden'});
				
				new Effect.Morph(this.update, {
					duration: this.baseFxDuration, 
					queue: this.queue, 
					style: {height: fHeight+'px'},
					afterFinish: function(fx){
						this.update.setStyle({height: '', overflow: ''});
						this.observeForm();
					}.bind(this)
				});
			break;
		}
	},
	ACSelected: function(pair)
	{
		this.autocomplete.input.value = '';
		
		if (this.itemsList.get(pair.id))
			return;
		
		this.trigger('onAction', 'add', pair.id);
		this.items.setLoading();
	},
	ACUpdated: function()
	{
		var new_item = this.autocomplete.autocompleter.update.down('.action');
		if (new_item)
			new_item.show();
	}
});


var BuroUploadGeneric = Class.create({
	initialize: function(id_base, url, parameters, aditionalData)
	{
		this.ajax_upload = (
			'multiple' in new Element('input', {type: 'file'}) &&
			typeof File != 'undefined' &&
			typeof FormData != 'undefined' &&
			!Object.isUndefined((new XMLHttpRequest()).upload)
		);
		
		if (this.ajax_upload)
		{
			this.object = new BuroAjaxUpload(this, id_base, url, parameters, aditionalData);
			return;
		}

		this.object = new BuroUpload(id_base, url, parameters);
	},
	addCallbacks: function(type, callbacks)
	{
		if (type == 'ajax' && this.ajax_upload)
			this.object.addCallbacks(callbacks);
		else if (type == 'classic' && !this.ajax_upload)
			this.object.addCallbacks(callbacks);

		return this;
	}
});

/**
 * Classic "Ajax" upload using the iframe method
 *
 * Callbacks:
 * - `onStart` function (input){}
 * - `onComplete` function (input){}
 * - `onFailure` function (input){}
 * - `onError` function (code, error){}
 * - `onSuccess` function (input, json){}
 * 
 * @access public
 */
var BuroUpload = Class.create(BuroCallbackable, {
	initialize: function(id_base, url, parameters)
	{
		if (Prototype.Browser.IE)
		{
			var ua = navigator.userAgent;
			var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
			if (re.exec(ua) != null)
				rv = parseFloat( RegExp.$1 );
		}

		this._submitted = false;
		this.uploading = false;
		this.id_base = id_base;
		this.url = url;
		this.parameters = $H(parameters);

		BuroCR.set(this.id_base, this);

		this.iframe = new Element('iframe', {
			name: 'if'+this.id_base, 
			id: 'if'+this.id_base, 
			src: 'javascript:false;',
			width: '900',
			height: '900'
		});
		this.iframe.observe('load', this.complete.bind(this));
		
		this.form = new Element('form', {
			action: this.url,
			target: this.iframe.name,
			method: 'post'
		});
		
		var upload_enctype = 'multipart/form-data';
		
		if (Prototype.Browser.IE && rv == 7)
			this.form.writeAttribute({encoding: upload_enctype});
		else
			this.form.writeAttribute({enctype: upload_enctype});
		
		this.div_container = new Element('div')
			.setStyle({height: '1px', width: '1px', position: 'absolute', left: '-100px', overflow: 'hidden'})
			.insert(this.iframe)
			.insert(this.form);
		document.body.appendChild(this.div_container);
		
		if (!document.loaded)	document.observe('dom:loaded', this.startObserve.bindAsEventListener(this, true));
		else					this.startObserve(true);
	},
	startObserve: function(ev, first)
	{
		if (ev === true)
			first = true;
		this.master_input = $('mi'+this.id_base);
		this.hidden_input = $('hi'+this.id_base);
		this.div_hidden = $('div'+this.id_base);
		this.master_input.hide();
		
		if (!first || this.hidden_input.value.blank())
		{
			this.tmp_input = this.master_input.clone().show();
			this.tmp_input.observe('change', this.submit.bind(this));
			this.master_input.insert({after: this.tmp_input});
		}

		if (!this.hidden_input.value.blank())
		{
			['act' + this.id_base, 'prv' + this.id_base].each(Element.show);
		}
	},
	submit: function()
	{
		if (this.tmp_input.value.empty())
			return;
		
		this.trigger('onStart', this.tmp_input);
		this.div_hidden.select('input[type=hidden]').each(function(input)
		{
			this.form.insert(input.clone());
		}.bind(this));
		
		this.parameters.each(function(pair) {
			this.form.insert(new Element('input', {name: pair.key, value: pair.value}));
		}.bind(this));
		
		this.div_hidden.up().removeClassName('error');
		this.div_hidden.up().select('.error-message').invoke('remove');
		this.div_hidden.setLoading();
		
		this.form.insert(this.tmp_input).submit();
		this._submitted = true;
		this.uploading = true;
	},
	complete: function()
	{
		if (!this._submitted)
			return;
		
		this.uploading = false;
		this.div_hidden.unsetLoading();
		
		var d, i = this.iframe;
		if (i.contentDocument) {
			d = i.contentDocument;
		} else if (i.contentWindow) {
			d = i.contentWindow.document;
		} else {
			d = window.frames[this.iframe.name].document;
		}
		
		var response = null;
		if (d.body.innerHTML.isJSON()) {
			response = this.responseJSON = d.body.innerHTML.evalJSON();
			if (this.responseJSON.error != false)
				this.trigger('onError', E_JSON, response.error, response);
			else
				this.trigger('onSuccess', this.tmp_input, this.responseJSON);
			
			if (this.responseJSON.saved != false)
				this.saved();
			else
				this.rejected();
		} else {
			response = d.body.innerHTML;
			this.responseJSON = false;
			this.trigger('onError', E_NOT_JSON);
		}
		
		this.trigger('onComplete', this.tmp_input, response);
	},
	again: function(reset_id)
	{
		if (!this._submitted && this.tmp_input)
			this.tmp_input.remove();
		
		if (reset_id == true)
			this.hidden_input.value = '';
		this._submitted = false;
		this.uploading = false;
		this.form.update();
		this.startObserve();
		this.trigger('onRestart');
	},
	saved: function()
	{
		this.hidden_input.value = this.responseJSON.saved;
		this.trigger('onSave', this.tmp_input, this.responseJSON, this.responseJSON.saved);
	},
	rejected: function()
	{
		var errorName, errorMsg = [];
		this.hidden_input.value = '';
		if (typeof this.responseJSON.validationErrors == 'object')
		{
			for (errorName in this.responseJSON.validationErrors)
			{
				errorName = this.responseJSON.validationErrors[errorName];
				if (BuroCaption.isSet('upload', 'error_'+errorName))
					errorMsg.push(BuroCaption.get('upload', 'error_'+errorName))
				else
					errorMsg.push(errorName);
			}
		}
		
		this.div_hidden.up().addClassName('error');
		this.div_hidden.up().insert(new Element('div', {className:'error-message'}).update(errorMsg.join('<br />')));
		
		this.trigger('onReject', this.tmp_input, this.responseJSON, this.responseJSON.saved);

		this.again();
	}
});


/**
 * HTML 5 upload, using XMLHttpRequest
 *
 * Callbacks:
 *  - `onStart` function(upload){%s}
 *  - `onComplete` function(upload, json){%s}
 *  - `onPieceSent` function(upload, json){%s}
 *  - `onReject` function(upload, json, saved){%s}
 *  - `onRestart` function(upload){%s}
 *  - `onError` function(upload, json){%s}
 * 
 * @access public
 */
var BuroAjaxUpload = Class.create(BuroCallbackable, {
	chunkSize: 1024*1024, // 1M
	MAX_TRIES: 5,
	ST_READY: 1 , ST_UPLOADING: 2, ST_DONE: 3, ST_ERROR: 4, ST_INVALIDATED: 5,
	initialize: function(parent, id_base, url, parameters, additionalData)
	{
		this.parent = parent;
		this.id_base = id_base;
		this.url = url;
		this.parameters = null;
		this.additionalData = additionalData;

		if (typeof parameters == 'object')
			this.parameters = parameters;

		BuroCR.set(this.id_base, this);

		if (document.loaded) this.loaded.bind(this).defer();
		else document.observe('dom:loaded', this.loaded.bind(this))
	},
	loaded: function()
	{
		this.cancelLink = new Element('a', {href: '#'}).update(BuroCaption.get('upload', 'cancel'));
		this.cancelLink.on('click', function(ev){ ev.stop(); this.abort(); }.bind(this));
		this.tryAgainLink = new Element('a', {href: '#'}).update(BuroCaption.get('upload', 'try_again'));
		this.tryAgainLink.on('click', this.again.bind(this));
		this.removeFileLink = new Element('a', {href: '#'}).update(BuroCaption.get('upload', 'remove'));
		this.removeFileLink.on('click', this.removeFile.bind(this));
		this.getFileLink = new Element('a', {href: ''}).update(BuroCaption.get('upload', 'get_file'));

		this.controls = new Element('div', {className: 'upload_control'});
		this.controls.insert(this.cancelLink).insert(' ')
					 .insert(this.tryAgainLink).insert(' ')
					 .insert(this.removeFileLink).insert(' ')
					 .insert(this.getFileLink);

		this.progress_bar = new Element('div', {className: 'progress_bar'});
		this.progress_bar.insert(new Element('div', {className: 'filling'}));
		this.progress_bar.insert(new Element('span', {className: 'label'}));

		this.upload_input = $('mi'+this.id_base);
		this.upload_input.insert({ after: this.controls });
		this.upload_input.insert({ after: this.progress_bar });
		this.upload_input.on('change', this.inputChange.bind(this));

		this.handleAbortBinded = this.handleAbort.bind(this);
		this.handleErrorBinded = this.handleError.bind(this);
		this.handleProgressBinded = this.handleProgress.bind(this);
		this.uploadStatusChangeBinded = this.uploadStatusChange.bind(this);

		this.hidden_input = $('hi' + this.id_base);

		this.reset();

		if (this.hidden_input.readAttribute('value'))
		{
			this.upload_input.hide();
			this.finish();
		}
		this.trigger('onLoad', this);
	},
	reset: function(resetData)
	{
		this.json = this.hash = this.startTime = this.file = null;
		this.currentByte = this.errorCount = 0;
		this.aborted = false;
		this.state = this.ST_READY;

		this.upload_input.show().value = '';
		if (this.upload_input.up('.input, .subinput'))
			this.upload_input.up('.input, .subinput').removeClassName('error').select('.error-message').invoke('remove');
		this.progress_bar.hide();

		if (resetData) {
			this.hidden_input.value = '';
		}

		this.clearCaption().clearXHR().controlControls();
	},
	addCaption: function(caption)
	{
		this.clearCaption();
		this.upload_input.insert({
			after: this.caption = (new Element('span')).insert(caption)
		});
	},
	clearCaption: function()
	{
		if (this.caption)
		{
			this.caption.remove();
			this.caption = null;
		}
		return this;
	},
	clearXHR: function()
	{
		if (this.xhr)
		{
			this.xhr.upload.removeEventListener('error', this.handleErrorBinded);
			this.xhr.upload.removeEventListener('progress', this.handleProgressBinded);
			this.xhr.upload.removeEventListener('abort', this.handleAbortBinded);
			this.xhr.onreadystatechange = null;
			this.xhr = null;
		}
		return this;
	},
	controlControls: function()
	{
		this.tryAgainLink.hide();
		this.removeFileLink.hide();
		this.cancelLink.hide();
		this.getFileLink.hide();
		switch (this.state)
		{
			case this.ST_READY:
				break;

			case this.ST_UPLOADING:
				this.cancelLink.show();
				break;

			case this.ST_DONE:
				this.removeFileLink.show();
				this.getFileLink.show();
				break;

			case this.ST_ERROR:
				this.tryAgainLink.show();
				break;
		}
	},
	abort: function()
	{
		if (this.xhr && this.xhr.readyState != 4)
		{
			this.xhr.onreadystatechange = function() {};
			this.xhr.abort();
			this.clearXHR();
		}

		if (!confirm(BuroCaption.get('upload', 'really_abort')))
		{
			this.uploadOnePiece();
			return;
		}

		this.aborted = true;
		this.handleAbort();
	},

	again: function(ev) {
		if (ev) ev.stop();

		this.reset();
		this.trigger('onRestart', this);
	},

	removeFile: function(ev) {
		ev.stop();
		if (confirm(BuroCaption.get('upload', 'really_remove'))) {
			this.reset(true);
			this.trigger('onRestart', this);
		}
	},
	inputChange: function(ev)
	{
		if (this.state != this.ST_READY)
			return;

		if (!this.upload_input.files.length)
		{
			this.reset();
		}
		else if (this.upload_input.files.length == 1)
		{
			var file = this.upload_input.files[0];

			this.reset();
			this.file = file;

			this.upload_input.hide();
			this.addCaption(BuroCaption.get('upload', 'sending', {fileName: this.getFileName()}));

			this.startTime = new Date().getTime();
			this.controls.setStyle({visibility: 'visible'});

			this.trigger('onStart', this);
			this.uploadOnePiece();
		}
	},
	getFileSize: function()
	{
		if (this.file)
			return this.file.size || this.file.fileSize;
		return null;
	},
	getFileName: function()
	{
		if (this.file)
			return this.file.name || this.file.fileName;
		else if (this.additionalData.filename)
			return this.additionalData.filename;
		return null;
	},
	uploadOnePiece: function()
	{
		if (this.xhr)
			return ;

		var chunk, form;

		this.endByte = Math.min(this.currentByte + this.chunkSize, this.getFileSize());
		this.isLast = this.endByte == this.getFileSize();

		if (this.file.mozSlice)
			chunk = this.file.mozSlice(this.currentByte, this.endByte);
		else if (this.file.webkitSlice)
			chunk = this.file.webkitSlice(this.currentByte, this.endByte);
		else if (this.file.slice && this.file.slice(2,1).size == 1)
			chunk = this.file.slice(this.currentByte, this.endByte - this.currentByte);
		else if (this.file.slice)
			chunk = this.file.slice(this.currentByte, this.endByte);

		if (!chunk)
			throw "Chunk is empty";

		this.xhr = new XMLHttpRequest();
		this.xhr.upload.addEventListener('error', this.handleErrorBinded);
		this.xhr.upload.addEventListener('progress', this.handleProgressBinded);
		this.xhr.onreadystatechange = this.uploadStatusChangeBinded;

		this.xhr.open('POST', this.url, true);
		this.xhr.setRequestHeader('Cache-Control', 'no-cache');
		this.xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		this.xhr.setRequestHeader('X-Uploader-Start-Byte', this.currentByte);
		this.xhr.setRequestHeader('X-Uploader-Is-Last', this.isLast ? 'yes' : 'no');
		this.xhr.setRequestHeader('X-Uploader-Chunk-Size', this.endByte-this.currentByte);

		form = new FormData();
		form.append(this.upload_input.name, chunk);
		for (fieldName in this.parameters)
			form.append(fieldName, this.parameters[fieldName]);

		if (this.hash)
			form.append('data[hash]', this.hash);

		if (this.isLast)
			form.append('data[original_name]', this.getFileName());

		this.state = this.ST_UPLOADING;
		this.controlControls();

		this.xhr.send(form);
	},
	uploadStatusChange: function()
	{
		if (this.xhr.readyState != 4)
			return;
	
		if (this.xhr.status != 200)
			this.handleError();

		this.requestEnded();

		if (this.isLast)
			this.trigger('onComplete', this, this.json);
	},
	requestEnded: function()
	{
		this.json = false;
		if (!this.xhr)
			return;

		if (this.xhr.response.isJSON())
			this.json = this.xhr.response.evalJSON();

		if (this.aborted)
			return this.handleAbort();

		if (!this.json)
			return this.handleError();

		if (this.json.hash)
			this.hash = this.json.hash;

		if (this.json.error)
		{
			if (this.json.error == 'chunk-doesnt-fit' && this.json.nextByte)
			{
				this.currentByte = this.json.nextByte;
				// Trying to sync the JS with the server (tries 5 times, and then, aborts it)
			}
			return this.handleError();
		}

		if (this.isLast)
			this.renderProgress(100);

		if (this.json.validationErrors)
		{
			this.state = this.ST_INVALIDATED;
			this.handleError()
			this.clearXHR();
			return;
		}

		this.currentByte = this.endByte;
		this.clearXHR();
		this.errorCount = 0;

		if (!this.isLast)
		{
			this.trigger('onPieceSent', this);
			this.uploadOnePiece();
		}
		else if (this.state == this.ST_UPLOADING)
		{
			this.hidden_input.value = this.json.saved;
			this.trigger('onSave', this, this.json);
			this.finish();
		}
	},
	handleError: function(ev)
	{
		if (this.state == this.ST_ERROR)
			return;

		if (this.aborted)
			return this.handleAbort();

		if (this.state == this.ST_UPLOADING)
		{
			this.errorCount++;
			if (this.errorCount < this.MAX_TRIES)
			{
				this.clearXHR();
				this.uploadOnePiece();
				return;
			}
		}

		this.renderError();

		this.state = this.ST_ERROR;
		this.controlControls();
		if (this.json && this.json.validationErrors)
			this.trigger('onReject', this, this.json, false);
		else
			this.trigger('onError', this, this.json);
	},
	handleProgress: function(ev)
	{
		this.renderProgress((this.currentByte + ev.loaded)/this.getFileSize()*99);
	},
	handleAbort: function(ev)
	{
		this.reset();
		this.controlControls();
	},
	finish: function()
	{
		if (this.json && this.json.dlurl)
			this.getFileLink.href = this.json.dlurl;
		else if (this.additionalData.dlurl)
			this.getFileLink.href = this.additionalData.dlurl;
		else
			throw "BuroAjaxUpload.finish() called, but not seems to be finished.";

		this.state = this.ST_DONE;
		this.controlControls();
	},
	renderProgress: function(progress)
	{
		var percent = Math.round(progress) + '%',
			timeTaken = new Date().getTime() - this.startTime,
			timeLeft = (timeTaken / (progress/100)) - timeTaken,
			formatedTime = new Date();

		if (false)
		{
			formatedTime.setHours(0,0,0,timeLeft);
			if (formatedTime.getHours())
				formatedTime = BuroCaption.get('upload', 'hours_left', {hours: formatedTime.getHours() + ':' + formatedTime.getMinutes()});
			else if (formatedTime.getMinutes())
				formatedTime = BuroCaption.get('upload', 'minutes_left', {minutes: formatedTime.getMinutes() + ':' + formatedTime.getSeconds()});
			else if (formatedTime.getSeconds())
				formatedTime = BuroCaption.get('upload', 'seconds_left', {seconds: formatedTime.getSeconds()});
			else
				formatedTime = false;

			console.log(formatedTime);
		}

		this.progress_bar.down('.filling').setStyle({width: percent})
		this.progress_bar.down('.label').update(percent);

		if (timeLeft > 2000)
			this.progress_bar.show();
	},
	renderError: function()
	{
		var errorName, errorMsg = [];
		if (typeof this.json.validationErrors == 'object')
		{
			for (errorName in this.json.validationErrors)
			{
				errorName = this.json.validationErrors[errorName];
				if (BuroCaption.isSet('upload', 'error_'+errorName))
					errorMsg.push(BuroCaption.get('upload', 'error_'+errorName))
				else
					errorMsg.push(errorName);
			}
		}

		if (this.json.error)
		{
			if (BuroCaption.isSet('upload', 'error_'+errorName))
				errorMsg.push(BuroCaption.get('upload', 'error_'+errorName))
			else if (BuroCaption.isSet('upload', 'error_with_server_resp'))
				errorMsg.push(BuroCaption.get('upload', 'error_with_server_resp', this.json));
		}

		if (!errorMsg.length)
			errorMsg.push(BuroCaption.get('upload', 'generic_error'));
		
		this.upload_input.up().up().addClassName('error');
		this.controls.insert({
			before: new Element('div', {className:'error-message'}).update(errorMsg.join('<br />'))
		});
	}
});


/**
 * 
 * 
 * @access public
 */
var BuroTextile = Class.create(BuroCallbackable, {
	initialize: function(id_base)
	{
		BuroCR.set(id_base, this);
		
		this.selection = {start: false, end: false};
		this.with_focus = false;
		
		this.id_base = id_base;
		this.input = $('npt'+this.id_base);
		
		this.links = this.input.up('.textarea_container').up().select('a.buro_textile');
		this.links.invoke('observe', 'click', this.routeAction.bind(this));
		
		this.input.observe('keyup', this.getSelection.bind(this));
		this.input.observe('mouseup', this.getSelection.bind(this));
		this.input.observe('focus', this.focus.bind(this));
		this.input.observe('blur', this.blur.bind(this));
	},
	routeAction: function (ev)
	{
		ev.stop();
		var action = ev.findElement('a').readAttribute('buro:action');
		switch (action)
		{
			case 'bold': this.insertToken('*'); break;
			case 'italic': this.insertToken('_'); break;
			case 'superscript': this.insertToken('^'); break;
			case 'subscript': this.insertToken('~'); break;
			case 'link': 
				$('itlink'+this.id_base).value = '';
				$('iulink'+this.id_base).value = '';
				var selection = this.getSelection(this.input);
				if (selection.start != selection.end)
					$('itlink'+this.id_base).value = this.input.value.substring(selection.start, selection.end);
				
			case 'image': 
			case 'file': 
			case 'title': 
				showPopup(action+this.id_base);
			break;
		}
	},
	focus: function(ev)
	{
		this.with_focus = true;
	},
	blur: function(ev)
	{
		this.with_focus = false;
	},
	insertFile: function(fileJson)
	{
		if (fileJson.saved)
			this.insertLink(fileJson.filename, null, fileJson.dlurl);
	},
	insertImage: function(fileJson)
	{
		if (fileJson.saved)
			this.insert('!'+fileJson.url+'!');
	},
	insertLink: function(text, title, url)
	{
		if (text.blank() || url.blank())
			return;
		if (!url.startsWith('/') && !url.match(/^\w+:\/\//i))
			url = 'http://' + url;
		url = encodeURI(url);
		this.insert('"'+text+'":'+url+' ');
	},
	insertTitle: function(type, title)
	{
		if (title.blank())
			return;
		var selection = this.getSelection(this.input);
		var header = type + '. ' + title + '\n\n';
		var char_before = '\n';
		
		if (selection.start != 0)
		{
			char_before = this.input.value.substr(selection.start-1, 1);
			header = '\n' + header;
		}
		
		if (char_before != '\n' && char_before != '\r')
			header = '\n' + header;
		
		this.insert(header);
	},
	insertToken: function(token)
	{
		var selection = this.getSelection(this.input);
		var textBefore = this.input.value.substring(0, selection.start);
		var selectedText = this.input.value.substring(selection.start, selection.end);
		var textAfter = this.input.value.substring(selection.end, this.input.value.length);
		
		if (!selectedText.blank())
			selectedText = selectedText.replace(/(^[\s\n\t\r]*)([^\t\n\r]*[^\s\t\n\r])([\s\b\t\r]*$)/gim, '$1'+token+'$2'+token+'$3');
		
		this.insert(selectedText);
	},
	insert: function(text)
	{
		var scrollTmp = this.input.scrollTop;
		var selection = this.getSelection(this.input);
		
		var textBefore = this.input.value.substring(0, selection.start);
		var textAfter = this.input.value.substring(selection.end);
		
		this.input.value = textBefore+text+textAfter;
		this.setSelection(this.input, selection.start, selection.start+text.length);	
		this.input.scrollTop = scrollTmp;
	},
	getSelection: function()
	{
		if (!this.with_focus)
		{
			if (this.selection.start !== false && this.selection.end !== false)
				return this.selection;
			else
				return {start:this.input.value.length, end:this.input.value.length};
		}
			
		var start, end;
		if (document.selection) //IE
		{
			selected_text = document.selection.createRange().text;
			start = this.input.value.indexOf(selected_text);
			if (start != -1)
				end = start + selected_text.length;
		}
		else if (typeof this.input.selectionStart != 'undefined') //FF
		{
			start = this.input.selectionStart;
			end = this.input.selectionEnd;
		}
		
		return this.selection = {start:start, end:end};
	},
	setSelection: function(input, start, end)
	{
		if (input.setSelectionRange)
		{
			input.focus();
			input.setSelectionRange(start,end);
		}
		else if (input.createTextRange)
		{
			var range = input.createTextRange();
			range.collapse(true);
			range.moveStart('character', start);
			range.moveEnd('character', end);
			range.select();
		}
		this.getSelection();
	}
});



/**
 * Create a input that comes with a color palette.
 * 
 * @access public
 * @param string id_base
 */
var CP;
var BuroColorPicker = Class.create(BuroCallbackable, {
	initialize: function(id_base)
	{
		if (!(this.input = $('inp'+id_base)))
			return;
		if (!CP)
			CP = new ColorPicker();
		
		BuroCR.set(id_base, this);
		
		this.input.observe('focus', this.openCP.bind(this));
		this.input.observe('keydown', this.keydown.bind(this));
		this.input.observe('keyup', this.keyup.bind(this));
		this.sample = $('samp'+id_base);
		if (!this.input.value.blank())
			this.updateSample();

		this.observeForm();
	},
	observeForm: function()
	{
		var form = BuroCR.get('frm'+this.input.readAttribute('buro:form'));
		if (!form)
		{
			window.setTimeout(this.observeForm.bind(this), 200);
			return;
		}
		
		form.addCallbacks({
			onReset: this.updateSample.bind(this)
		});
	},
	openCP: function(ev)
	{
		CP.open(this.input);
		CP.callbacks.change = this.change.bind(this);
		if (!this.input.value.blank())
			CP.setHex(this.input.value);
	},
	closeCP: function()
	{
		CP.close();
		return this;
	},
	change: function(color)
	{
		this.input.value = color.toHEX();
		this.updateSample();
	},
	keydown: function(ev)
	{
		var code = ev.keyCode || ev.witch;
		if (code == Event.KEY_TAB)
			this.closeCP();
	},
	keyup: function(ev)
	{
		CP.setHex(this.input.value);
		this.updateSample();
	},
	updateSample: function()
	{
		this.sample.setStyle({
			backgroundColor: this.input.value
		});
		return this;
	},
	setColor: function(color)
	{
		this.input.value = color;
		this.updateSample().closeCP();
		return this;
	}
});


/**
 * Handles the dynamic textarea actions
 * 
 * @access public
 */
var BuroDynamicTextarea = Class.create({
	initialize: function(id)
	{
		this.input = $(id);
		this.span = this.input.previous().down('span');
		this.input
			.observe('focus', this.focus.bind(this))
			.observe('blur', this.blur.bind(this));
		
		if (Prototype.Browser.IE)
			this.input.attachEvent('onpropertychange', this.update.bind(this));
		else
			this.input.observe('input', this.update.bind(this));

		this.update();
		this.observeForm();
	},
	observeForm: function()
	{
		var form = BuroCR.get('frm'+this.input.readAttribute('buro:form'));
		if (!form)
		{
			window.setTimeout(this.observeForm.bind(this), 200);
			return;
		}

		form.addCallbacks({
			onReset: this.update.bind(this)
		});
	},
	update: function(ev)
	{
		if (this.span)
		{
			if (Prototype.Browser.IE)
				this.span.innerText = this.input.value;
			else
				this.span.textContent = this.input.value;
		}
	},
	focus: function(ev){this.input.up().addClassName('focus')},
	blur: function(ev){this.input.up().removeClassName('focus')}
});























