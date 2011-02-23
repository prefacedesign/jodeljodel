// Global hash to save the popups
var Popups = {
	available_popups: $H(),
	open_popup: false
}


function showPopup(id)
{
	var popup = Popups.available_popups.get(id);
	if(popup)
		popup.open();
}

function closePopup(id)
{
	var popup = Popups.available_popups.get(id);
	if(popup)
		popup.close();
}

function cancelProgress(id, url)
{
	var popup = Popups.available_popups.get(id);
	if(popup && popup.call_progress)
		popup.call_progress.cancel(url);
}

var Popup = Class.create({
	initialize: function(id, links)
	{
		this.id = id;
		this.divCont = $(this.id);
		this.divCont.hide();
		this.call_progress = false;
		
		this.callback = function(action){}
		
		$H(links).each(function(pair)
		{
			var action = pair.key;
			var link_id = pair.value;
			$(link_id).observe('click', function(ev)
			{
				ev.stop();
				this[0].close();
				this[0].callback(this[1]);
			}.bind([this,action]));
		}.bind(this));
		
		Popups.available_popups.set(this.id, this);
		
		this.divCont.fire('popup:registered');
	},
	open: function()
	{
		if(Popups.open_popup !== false)
			closePopup(Popups.open_popup);
		
		Popups.open_popup = this.id;
		document.body.insert(new Element('div',{className: 'popup_maya_veil'}).setOpacity(0.45));
		this.divCont.show();
		this.divCont.setStyle({
			top: document.viewport.getScrollOffsets().top + (document.viewport.getHeight()/2-this.divCont.getHeight()/2)+'px',
			left: document.viewport.getScrollOffsets().left + (document.viewport.getWidth()/2-this.divCont.getWidth()/2)+'px'
		});
		this.divCont.fire('popup:opened');
	},
	close: function()
	{
		Popups.open_popup = false;
		$$('.popup_maya_veil').each(Element.remove);
		this.divCont.hide();
		this.divCont.fire('popup:closed');
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
		
		this.can_continue = true;
		this.url_cancel = false;
		
		this.kill_popup();
		
		new Ajax.Request(url, {
			onComplete: this.completed.bind(this)
		});
	},
	completed: function(response)
	{
		if(response.responseJSON)
		{
			var json = response.responseJSON;
			this.popup.divCont.down('.msg').update(json.msg);
			
			if(json.erro == 0)
			{
				this.popup.divCont.down('.enchimento_da_barra').morph('width: '+json.porcentagem+'%', {duration: 3});
				if(json.porcentagem != 100)
				{
					if(this.can_continue)
					{
						new ProgressPopup(json.url_prox, this.popup_id);
					}
					else
					{
						this.call_cancel();
					}
				}
				else
				{
					this.show_end();
				}
			}
		}
		else
		{
			alert('Erro na comunicação.');
		}
	},
	kill_popup: function()
	{
		var links = this.popup.divCont.select('.callbacks a');
		links[0].show();
		links[1].hide();
	},
	show_end: function()
	{
		this.popup.divCont.down('.carregando').hide();
		
		var links = this.popup.divCont.select('.callbacks a');
		links[0].hide();
		links[1].show();
	},
	cancel: function(url)
	{
		openPopup(this.popup_id+'_cancelando');
		this.url_cancel = url;
		this.can_continue = false;
	},
	call_cancel: function()
	{
		if(this.url_cancel && this.url_cancel != '')
			new Ajax.Request(this.url_cancel,{
				onComplete:function(){closePopup(this.popup_id+'_cancelando');}.bind(this)
			});
		else
			closePopup(this.popup_id+'_cancelando');
	}
});