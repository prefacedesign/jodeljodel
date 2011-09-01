var ColorPicker = Class.create({
	initialize: function() {
		
		this.callbacks = {};
		this.active = false;
		this.color = new HSV(0,0,0);
		this.hue = false;
		
		this.div = new Element('div', {className: 'cpk-cont'})
		 .insert(this.colorHolder = new Element('div', {className: 'cpk-color'}))
		 .insert(this.croma = new Element('div', {className: 'cpk-croma'}))
		 .insert(this.hdiv = new Element('div', {className: 'cpk-h'}))
		 .insert(this.text = new Element('span'))
		;
		
		this.croma.insert(this.picker = new Element('div', {className: 'cpk-picker'}))
		this.hdiv.insert(this.hdrag = new Element('div', {className: 'cpk-hdrag'}));
		
		document.body.insert(this.div);
		this.slider = new Control.Slider(this.hdrag, this.hdiv, {
			axis: 'vertical',
			maximum: 254,
			onSlide: this.onSlide.bind(this)
		});
		
		this.close();
		
		this.div.observe('mousedown', function(ev){ev.stop()});
		this.croma.observe('mousedown', function(ev){this.active = true;}.bind(this));
		document.observe('mousemove', this.onMouseMove.bind(this));
		document.observe('mouseup', this.finishSearch.bind(this));
		document.observe('mousedown', this.close.bind(this));
	},
	close: function(ev) {
		this.div.hide();
		this.hue = false;
		if (!ev)
			return this;
	},
	open: function(element) {
		element = $(element);
		this.div.show().setStyle({
			top: (element.cumulativeOffset().top-this.div.getHeight()/2)+'px',
			left: (element.cumulativeOffset().left+element.getWidth()+10)+'px'
		});
		return this;
	},
	finishSearch: function(ev) {
		this.active = false;
		if (Object.isFunction(this.callbacks.finish))
			this.callbacks.finish(this.color);
	},
	setHex: function(hex) {
		this.setColor(this.color.setHEX(hex));
	},
	setColor: function(color) {
		var HSV = color.toHSV();
		this.text.update(color.toHEX());
		this.color = color;
		if (this.hue === false) {
			this.setHue(HSV.h);
			this.slider.setValue(1-HSV.h/360);
		}
		this.picker.setStyle({
			bottom: (this.croma.getHeight()*HSV.v/100-1)+'px',
			left: (this.croma.getWidth()*HSV.s/100-1)+'px',
			borderColor: HSV.v>50?'black':'white'
		});
	},
	setHue: function(hue) {
		var cor = new HSV(hue,100,100).toHEX();
		this.colorHolder.setStyle({backgroundColor: cor});
		this.hdrag.setStyle({backgroundColor: cor});
		this.hue = hue;
	},
	onSlide: function(value) {
		var HSV = this.color.toHSV();
		this.setHue(Math.floor(360-value*360));
		this.setColor(this.color.setHSV(this.hue,HSV.s,HSV.v));
		this.callbacks.change(this.color);
	},
	onMouseMove: function(ev) {
		if (!this.active) return;
		var width = this.colorHolder.getWidth()-2;
		var height = this.colorHolder.getHeight()-2;
		var m = {
			x: Math.max(0, Math.min(Event.pointerX(ev)-this.colorHolder.cumulativeOffset().left, width)),
			y: Math.max(0, Math.min(Event.pointerY(ev)-this.colorHolder.cumulativeOffset().top, height))
		};
		this.setColor(this.color.setHSV(
			this.hue,
			Math.round(m.x*100/width),
			Math.round(100-m.y*100/height)
		));
		this.callbacks.change(this.color);
	}
});

var RGB = Class.create({
	initialize: function(r,g,b) {
		this.setRGB(r,g,b);
	},
	setRGB: function(r,g,b) {
		this.r = r; this.g = g; this.b = b; return this;
	},
	setHEX: function(hex) {
		hex = hex.replace('#','');
		this.r = this._decimalize(hex.substring(0,2));
		this.g = this._decimalize(hex.substring(2,4));
		this.b = this._decimalize(hex.substring(4,6));
		return this;
	},
	setHSV: function(h,s,v) {
		if (!Object.isUndefined(h.h)) {
			s=h.s; v=h.v; h=h.h;
		}
		h=h/360; s=s/100; v=v/100;
		if (s == 0) {
			this.r = this.g = this.b = v * 255;
		} else {
			var_h = h * 6;
			var_i = Math.floor(var_h);
			var_1 = v * (1 - s);
			var_2 = v * (1 - s * (var_h - var_i));
			var_3 = v * (1 - s * (1 - (var_h - var_i)));

			if (var_i == 0) {var_r = v; var_g = var_3; var_b = var_1}
			else if (var_i == 1) {var_r = var_2; var_g = v; var_b = var_1}
			else if (var_i == 2) {var_r = var_1; var_g = v; var_b = var_3}
			else if (var_i == 3) {var_r = var_1; var_g = var_2; var_b = v}
			else if (var_i == 4) {var_r = var_3; var_g = var_1; var_b = v}
			else {var_r = v; var_g = var_1; var_b = var_2};

			this.r = var_r * 255;
			this.g = var_g * 255;
			this.b = var_b * 255;
		}
		return this;
	},
	toHEX: function() {
		return '#'+this._hexfy(this.r)+this._hexfy(this.g)+this._hexfy(this.b);
	},
	toHSV: function() {
		r = this.r/255; g = this.g/255; b = this.b/255;
		var minVal = Math.min(r, g, b);
		var maxVal = Math.max(r, g, b);
		var delta = maxVal - minVal;
		
		hsv = {};
		hsv.v = maxVal;
		
		if (delta == 0) {
			hsv.h = 0;
			hsv.s = 0;
		} else {
			hsv.s = delta / maxVal;
			var del_R = (((maxVal - r) / 6) + (delta / 2)) / delta;
			var del_G = (((maxVal - g) / 6) + (delta / 2)) / delta;
			var del_B = (((maxVal - b) / 6) + (delta / 2)) / delta;
			
			if (r == maxVal) {hsv.h = del_B - del_G;}
			else if (g == maxVal) {hsv.h = (1 / 3) + del_R - del_B;}
			else if (b == maxVal) {hsv.h = (2 / 3) + del_G - del_R;}
			
			if (hsv.h < 0) {hsv.h += 1;}
			if (hsv.h > 1) {hsv.h -= 1;}
		}
		hsv.h = hsv.h*360;
		hsv.s = hsv.s*100;
		hsv.v = hsv.v*100;
		return new HSV(hsv.h,hsv.s,hsv.v);
	},
	toRGB: function() {
		return this;
	},
	
	digits: '0123456789ABCDEF',
	_hexfy: function (number) {
		var lsd = number % 16;
		var msd = (number - lsd) / 16;
		var hexified = this.digits.charAt(msd) + this.digits.charAt(lsd);
		return hexified;
	},
	_decimalize: function (hexNumber) {
		return ((this.digits.indexOf(hexNumber.charAt(0).toUpperCase()) * 16) + this.digits.indexOf(hexNumber.charAt(1).toUpperCase()));
	} 
});

var HSV = Class.create({
	initialize: function(h,s,v) {
		this.setHSV(h,s,v);
	},
	setHSV: function(h,s,v) {
		if (!Object.isUndefined(h.h)) {
			this.h=h.h; this.s=h.s; this.v=h.v;
		} else {
			this.h=h; this.s=s; this.v=v;
		}
		return this;
	},
	setHEX: function(hex) {
		return this.setHSV(new RGB().setHEX(hex).toHSV());
	},
	toHSV: function() {
		return this;
	},
	toHEX: function() {
		return new RGB().setHSV(this).toHEX();
	}
});