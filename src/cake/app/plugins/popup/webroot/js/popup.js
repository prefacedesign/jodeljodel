// Cria uma Hash global para guardar todas os popups
window.dados_popup = {
	popups_disponiveis: $H(),
	popup_aberto: false,
}

// Função global para ser usada para chamar o abre das classes
function abrePopup(id)
{
	var popup = window.dados_popup.popups_disponiveis.get(id);
	if(popup)
		popup.abre();
}

// Função global para fechar um popup
function fechaPopup(id)
{
	var popup = window.dados_popup.popups_disponiveis.get(id);
	if(popup)
		popup.fecha();
}

// Função que cancela a cadeida de chamadas Ajax da barra de progresso
function cancelaProgresso(id, url)
{
	var popup = window.dados_popup.popups_disponiveis.get(id);
	if(popup && popup.chamada_progresso)
		popup.chamada_progresso.cancela(url);
}

var Popup = Class.create({
	initialize: function(id, links)
	{
		this.id = id;
		this.divCont = $(this.id);
		this.divCont.hide();
		
		// Variável usada pela classe de progresso para ser referenciada dps
		this.chamada_progresso = false;
		
		// Monta uma funcao de callback padrão para ser substituida depois
		this.callback = function(acao){}
		
		// Trata os links
		$H(links).each(function(pair)
		{
			var acao = pair.key;
			var link_id = pair.value;
			$(link_id).observe('click', function(ev)
			{
				ev.stop();
				this[0].fecha();
				this[0].callback(this[1]);
			}.bind([this,acao]));
		}.bind(this));
		
		// Salva essa instância de classe para referência posterior 
		window.dados_popup.popups_disponiveis.set(this.id, this);
		
		this.divCont.fire('popup:registrou');
	},
	abre: function()
	{
		if(window.dados_popup.popup_aberto !== false)
			fechaPopup(window.dados_popup.popup_aberto);
		
		window.dados_popup.popup_aberto = this.id;
		document.body.insert(new Element('div',{className: 'velatura_popup'}).setOpacity(0.65));
		this.divCont.show();
		this.divCont.setStyle({
			top: document.viewport.getScrollOffsets().top + (document.viewport.getHeight()/2-this.divCont.getHeight()/2)+'px',
			left: document.viewport.getScrollOffsets().left + (document.viewport.getWidth()/2-this.divCont.getWidth()/2)+'px'
		});
		this.divCont.fire('popup:abriu');
	},
	fecha: function()
	{
		window.dados_popup.popup_aberto = false;
		$$('.velatura_popup').each(Element.remove);
		this.divCont.hide();
		this.divCont.fire('popup:fechou');
	},
	addCallback: function(funcao)
	{
		this.callback = funcao;
	}
});


var ChamadasProgresso = Class.create({
	initialize: function(url, popup_id)
	{
		this.popup_id = popup_id;
		this.popup = window.dados_popup.popups_disponiveis.get(this.popup_id);
		this.popup.chamada_progresso = this;
		
		this.permite_continuar = true;
		this.url_cancelar = false;
		
		this.zera_popup();
		
		new Ajax.Request(url, {
			onComplete: this.completo.bind(this)
		});
	},
	completo: function(response)
	{
		if(response.responseJSON)
		{
			var json = response.responseJSON;
			this.popup.divCont.down('.mensagem').update(json.mensagem);
			
			if(json.erro == 0)
			{
				this.popup.divCont.down('.enchimento_da_barra').morph('width: '+json.porcentagem+'%', {duration: 3});
				if(json.porcentagem != 100)
				{
					if(this.permite_continuar)
					{
						new ChamadasProgresso(json.url_prox, this.popup_id);
					}
					else
					{
						this.procede_cancelar();
					}
				}
				else
				{
					this.mostra_fim();
				}
			}
		}
		else
		{
			alert('Erro na comunicação.');
		}
	},
	zera_popup: function()
	{
		var links = this.popup.divCont.select('.callbacks a');
		links[0].show();
		links[1].hide();
	},
	mostra_fim: function()
	{
		this.popup.divCont.down('.carregando').hide();
		
		var links = this.popup.divCont.select('.callbacks a');
		links[0].hide();
		links[1].show();
	},
	cancela: function(url)
	{
		abrePopup(this.popup_id+'_cancelando');
		this.url_cancelar = url;
		this.permite_continuar = false;
	},
	procede_cancelar: function()
	{
		if(this.url_cancelar && this.url_cancelar != '')
			new Ajax.Request(this.url_cancelar,{
				onComplete:function(){fechaPopup(this.popup_id+'_cancelando');}.bind(this)
			});
		else
			fechaPopup(this.popup_id+'_cancelando');
	}
});