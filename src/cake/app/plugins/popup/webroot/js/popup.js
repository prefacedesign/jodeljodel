// Global hash to save the popups
var Popups = {
	available_popups: $H(),
	open_popup: false,
	add: function (obj)
	{
		Popups.available_popups.set(obj.id, obj);
	}
}


function showPopup(id)
{
	var popup = Popups.available_popups.get(id);
	if (popup)
		popup.open();
}

function closePopup(id)
{
	if (!id && Popups.open_popup)
		id = Popups.open_popup;
	
	var popup = Popups.available_popups.get(id);
	if (popup)
		popup.close();
}

function cancelProgress(id, url)
{
	var popup = Popups.available_popups.get(id);
	if (popup && popup.call_progress)
		popup.call_progress.cancel(url);
}

var Popup = Class.create({
	initialize: function(id, links)
	{
		this.id = id;
		this.links = $H(links);
		this.divCont = $(this.id);
		this.call_progress = false;
		this.activeElement = false;
		
		this.callback = function(action){}
		
		if (document.loaded)
			this.register()
		else
			document.observe('dom:loaded', this.register.bind(this));
	},
	register: function()
	{
		Popups.add(this);
		
		document.body.appendChild(this.divCont);
		
		this.links.each(function(pair)
		{
			var action = pair.key;
			var link_id = pair.value;
			$(link_id).observe('click', function(ev, action)
			{
				ev.stop();
				callback = this.callback(action);
				if (callback !== false)
					this.close();
			}.bindAsEventListener(this,action));
		}.bind(this));
		
		this.divCont.hide();
		this.divCont.fire('popup:registered');
	},
	open: function()
	{
		if (Popups.open_popup !== false)
			closePopup(Popups.open_popup);
		
		Popups.open_popup = this.id;
		document.body.appendChild(new Element('div',{className: 'popup_maya_veil'}).setOpacity(0.45));
		this.divCont.show();
		this.divCont.setStyle({
			top: document.viewport.getScrollOffsets().top + (document.viewport.getHeight()/2-this.divCont.getHeight()/2)+'px',
			left: document.viewport.getScrollOffsets().left + (document.viewport.getWidth()/2-this.divCont.getWidth()/2)+'px'
		});
		
		this.activeElement = document.activeElement;
		
		try
		{
			$(this.links.values().first()).focus();
		}
		catch (err) {}
		
		this.divCont.fire('popup:opened');
	},
	close: function()
	{
		Popups.open_popup = false;
		$$('.popup_maya_veil').each(Element.remove);
		this.divCont.hide();
		this.divCont.fire('popup:closed');
		if (this.activeElement)
		{
			this.activeElement.focus();
			this.activeElement = false;
		}
	},
	addCallback: function(procedure)
	{
		this.callback = procedure;
	}
});





//@todo: test the ProgressPopup

var ProgressPopup = Class.create({
	initialize: function(url, popup_id)
	{
		this.popup_id = popup_id;
		this.popup = Popups.available_popups.get(this.popup_id);
		this.popup.call_progress = this;
		
		this.morphEffect = false;
		this.isCancelled = false;
		this.url_cancel = false;

		this.onlyCancel();
		
		this.callURL(url);
	},
	completed: function(response)
	{
		if (!response.responseJSON)
		{
			this.updateMsg('Um erro na comunicação impediu que o processo fosse realizado com sucesso.');
			this.showEnd();
			return;
		}

		var json = response.responseJSON;
	
		if (json.msg)
			this.updateMsg(json.msg);
		
		if (!json.error)
		{
			if (this.isCancelled)
			{
				this.callCancel();
				return;
			}
			
			this.updatePercentage(json.percentage);
			if (json.percentage == 100)
			{
				this.showEnd();
				return;
			}
			
			this.callURL(json.nextURL)
		}
	},
	updateMsg: function(msg)
	{
		this.popup.divCont.down('.popup_message').update(msg);
	},
	updatePercentage: function(percentage)
	{
		if (this.morphEffect)
			this.morphEffect.cancel();
		
		var filler = this.popup.divCont.down('.popup_progress_bar_filler');
		if (filler)
		{
			if (percentage == 100)
				filler.setStyle({width:'100%'});
			else
				this.morphEffect = new Effect.Morph(filler, {
					style: 'width: '+Math.min(100, percentage+5)+'%',
					duration: 2, 
					transition: Effect.Transitions.linear
				});
		}
	},
	callURL: function(url)
	{
		new Ajax.Request(url, {
			onComplete: this.completed.bind(this)
		});
	},
	callCancel: function()
	{
		if (this.url_cancel && this.url_cancel != '')
		{
			new Ajax.Request(this.url_cancel,{
				onComplete:function() {
					closePopup(this.popup_id+'_cancelling');
				}.bind(this)
			});
		}
		else
		{
			closePopup(this.popup_id+'_cancelling');
		}
	},
	onlyCancel: function()
	{
		var links = this.popup.divCont.select('.callbacks a');
		links[0].show();
		links[1].hide();
	},
	showEnd: function()
	{
		this.popup.divCont.down('.popup_loading').hide();
		
		var links = this.popup.divCont.select('.callbacks a');
		links[0].hide();
		links[1].show();
	},
	cancel: function(url)
	{
		showPopup(this.popup_id+'_cancelling');
		this.url_cancel = url;
		this.isCancelled = true;
	}
});
