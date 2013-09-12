/*Bixie Printshop adminuser script*/

var BixAdminuser = new Class({
	Implements: [Options],
	request: false,
	inputEl: '',
	selectEl: '',
	resetEl: '',
	options: {
		reqUrl: 'index.php?option=com_bixprintshop&format=raw&task=raw.userlist',
		initValue: 0
	},
	initialize: function (inputID, options) {
		this.setOptions(options);
		this.inputEl = document.id(inputID);
		this.selectEl = document.id('select'+inputID);
		this.resetEl = document.id('reset'+inputID);
		var self = this;
		this.request = new Request.JSON({
			url:self.options.reqUrl,
			link:'cancel',
			onRequest: function(){},
			onFailure: function(error){},
			onError: function(text,error){},
			onSuccess: function(result){
				self.setSelect(result);
			}
		});
		this.resetEl.addEvent('click',function () {
			var selectContent = '<option value="-1" selected="selected">Reset</option>';
			self.selectEl.set('html',selectContent);
			self.selectEl.getParent('form').submit();
		});
		this.inputEl.addEvent('keyup',function () {
			self.lookup();
		});
		if (this.options.initValue > 0) {
			this.lookup();
		}
	},
	lookup: function () {
		var req = {
			search: this.inputEl.get('value')
		};
		this.request.post(Object.toQueryString(req))
	},
	setSelect: function (result) {
		if (result.error == false) {
			var selectContent = '';
			var self = this;
			if (typeof result.options == 'object') {
				Object.each(result.options,function(optionData) {
					var selected = optionData.value == self.options.initValue ?' selected="selected"':'';
					var disabled = optionData.value == '' ?' disabled="disabled"':'';
					selectContent += '<option value="'+optionData.value+'"'+selected+disabled+'>'+optionData.text+'</option>';
				})
			}
			this.selectEl.set('html',selectContent)
		}
	}
});