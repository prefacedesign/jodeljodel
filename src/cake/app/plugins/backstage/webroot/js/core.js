

/**
 *
 * Copyright 2010-2012, Preface Design LTDA (http://www.preface.com.br")
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2011, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */


/**
 * Does some extends on default elements behavior:
 *  - Adds the `setLoading` and `unsetLoading` methods that handles loading element
 *  - Adds the `swapWith` method, that allows swapping elements places 
 *  - Adds the `scrollVisible` that works like scrollIntoView(), but does some animation.
 *  - Implements an observer on inputs and textareas for focusing
 */
document.observe('dom:loaded', function()
{
	Element.addMethods({
		setLoading: function(element)
		{
			if (!(element = $(element))) return;
			if (!element.visible() || element.retrieve('loading')) return element;
			var indicator = new Element('div', {className: 'loading-indicator'}), 
				overlayer = new Element('div', {className: 'loading-overlayer'}),
				position, pe;
			document.body.insert(overlayer);
			overlayer.insert({after: indicator}).clonePosition(element).setOpacity(0.7);
			
			position = $H(overlayer.cumulativeOffset()).merge(overlayer.getDimensions());
			indicator.setStyle({
				left: (position.get('left')+position.get('width')/2-indicator.getWidth()/2)+'px',
				top: position.get('top')+'px'
			});
			pe = new PeriodicalExecuter(function(indicator, position) {
				var pos = Math.max(position.get('top')+20, document.viewport.getScrollOffsets().top+20);
				pos = Math.min(pos, position.get('top')+position.get('height')-20);
				pos+= (indicator.cumulativeOffset().top-pos)/2;
				indicator.setStyle({top: pos+'px'});
			}.curry(indicator,position), 0.1);
			return element.store('loading', {pe:pe,elements:[overlayer,indicator]}).addClassName('loading');
		},
		unsetLoading: function(element)
		{
			var loading;
			if (!(element = $(element))) return;
			if (!(loading = element.retrieve('loading'))) return element;
			loading.pe.stop();
			loading.elements.each(Element.remove);
			return element.store('loading', false).removeClassName('loading');
		},
		swapWith: function(element, other)
		{
			if (!(element = $(element))) return;
			if (!(other = $(other))) return;
			var reference = new Element('div');
			reference.insert({after: other.insert({after: element.insert({after: reference})})}).remove();
			return element;
		},
		scrollVisible: function(element, padding)
		{
			if (!(element = $(element))) return;
			padding = padding || 0;
			
			var offset = element.viewportOffset().top;
			if (offset < 0)
				offset = -Number(padding);
			else if (offset > document.viewport.getHeight()-element.getHeight())
				offset = -(document.viewport.getHeight()-element.getHeight()-Number(padding));
			else
				offset = false;
			
			if (offset !== false)
				new Effect.ScrollTo(element, {duration: 0.5, offset: offset});
			return element;
		}
	});
});