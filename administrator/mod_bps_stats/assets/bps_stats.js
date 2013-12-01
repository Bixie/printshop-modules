/* Bixie Printshop
 * Module BPS Stats
 */
 

var modBPSstats = new Class({
	Implements: [Options],
	options: {
		elIds: {
			periode: '',
			dataType: '',
			startDatum: '',
			graph: ''
		},
		templates: {
			graphHolder: '<div id="graphHolder"></div>',
			graphTitle: '<h2 class="graphTitle">{content}</h2>',
			tblStart: '<table class="bps-stats"><thead><tr>',
			label: '<em>{content}</em>',
			tblHead: '<th>{content}</th>',
			tblCell: '<td>{content}</td>',
			tblEndHead: '</tr></thead><tbody>',
			tblStartRow: '<tr>',
			tblEndRow: '</tr>',
			tblEnd: '</tbody></table>'
		},
		reqUrl: 'index.php?option=com_bixprintshop&format=raw&task=plugin.triggermodule&action=bps_stats.showstats',
		periodical: 0
	},
	formEl: {},
	els: {},
	initialize: function(formID,options) {
		this.setOptions(options);
		this.formEl = document.id(formID);
		var self = this;
		Object.each(this.options.elIds, function (id,name) {
			self.els[name] = document.id(id);
		});
		['periode','dataType','startDatum'].each(function (elId) {
			self.els[elId].addEvent('change', function (e) {
				self.loadGraphs();
			});
			
		});
// console.log(this.formEl,formID);
		if (this.options.periodical) {
			self.loadGraphs.periodical(self.options.periodical,self);
		}
		this.loadGraphs();
	},
	loadGraphs: function () {
		var self = this;
		new Request.JSON({
			url: self.options.reqUrl,
			onRequest: self.els.graph.fade(0.1),
			onError: function(text,error){self.els.graph.set('html',text);self.els.graph.fade(1);},
			onSuccess: function(result){self.setGraphs(result)} 
		}).send(self.formEl);
	},
	setGraphs: function (returndata) {
		var self = this, tmpl = this.options.templates;
		this.els.graph.fade(1);
		var html = tmpl.graphHolder;
		
		html += this.buildTable(returndata);
		
		this.els.graph.set('html',html);
		this.setBrowseRange(returndata);
		this.drawVisualization(returndata);
	},
	buildTable: function (returndata) {
		var self = this, tmpl = this.options.templates;
		var html = tmpl.tblStart;
		//labels toevoegen
		Object.each(returndata.fields,function(fieldInfo,fieldName) {
			html += tmpl.tblHead.replace('{content}',fieldInfo.label);
		});
		html += tmpl.tblEndHead;
// console.log(returndata);
		//data uitlezen
		Object.each(returndata.infos,function(labelInfo,key) {
			var stats = returndata.stats[key];
			//rij maken
			html += tmpl.tblStartRow;
			Object.each(returndata.fields,function(fieldInfo,fieldName) {
				if (!stats[fieldName]) stats[fieldName] = 0;
				switch (fieldInfo.format) {
					case 'label':
						var formatted = tmpl.label.replace('{content}',labelInfo.formatted);
					break;
					case 'euro':
						var formatted = BixTools.formatPrice(stats[fieldName].toFloat());
					break;
					case 'perc':
						var formatted = stats[fieldName].replace('.', ',')+'%';
					break;
				}
				html += tmpl.tblCell.replace('{content}',formatted);
			});
			html += tmpl.tblEndRow;
			
		});
		html += tmpl.tblEnd;
		return html;
	},
	setBrowseRange: function(returndata) {
		var optionEls = [];
		Object.each(returndata.browseRange,function(optionInfo) {
			optionEls.push(new Element('option',{value:optionInfo.value,text:optionInfo.text}));
		});
		this.els.startDatum.empty().adopt(optionEls).set('value',returndata.params.startDatum);
	},
	drawVisualization: function(returndata,totalCol) {
		var dataArray = [], tmpl = this.options.templates;
		var skipFields = ['margePerc'];
		
		//labels toevoegen
		var dataRow = [];
		Object.each(returndata.fields,function(fieldInfo,fieldName) {
			if (!skipFields.contains(fieldName)) {
				dataRow.push(fieldInfo.label);
			}
		});
		dataArray.push(dataRow);
		//data uitlezen
		var i = 0;
		Object.each(returndata.infos,function(labelInfo,key) {
			if (i > 0 || totalCol) {
				var stats = returndata.stats[key];
				//rij maken
				var dataRow = [];
				Object.each(returndata.fields,function(fieldInfo,fieldName) {
					if (!skipFields.contains(fieldName)) {
						switch (fieldInfo.format) {
							case 'label':
								var formatted = labelInfo.formatted;
							break;
							case 'euro':
								var formatted = stats[fieldName].toFloat();
							break;
							case 'perc':
								var formatted = stats[fieldName].toFloat();
							break;
						}
						dataRow.push(formatted);
					}
				});
				dataArray.push(dataRow);
			}
			i++;
		});

// console.log(dataArray);
		var data = google.visualization.arrayToDataTable(dataArray);
		var options = {
			title : returndata.graphInfo.titel,
			vAxis: {title: returndata.graphInfo.titelvAxis},
			hAxis: {title: returndata.graphInfo.titelhAxis},
			seriesType: "bars"
		}; 
		if (returndata.graphInfo.lineCol != 'undefined') {
			options.series = {index: {type: "line"}};
			options.series[returndata.graphInfo.lineCol] = {type: "line"};
		}
		 
		var chart = new google.visualization.ComboChart(document.getElementById('graphHolder'));
		chart.draw(data, options);
	}
	//google.setOnLoadCallback(drawVisualization);
});




 var bixSelectNav = new Class({
	Implements: [Options],
	options: {
		prevText: '<<',
		nextText: '>>'
	},
	selectEl: {},
	initialize: function(selectID,options) {
		this.setOptions(options);
		this.selectEl = document.id(selectID);
		var self = this, parent = this.selectEl.getParent();
		var prevButEl = new Element('button.bix-nav',{
			text: self.options.prevText,
			type: 'button'
		}).addEvent('click', function () {
			self.navigate('prev');
		});
		parent.grab(prevButEl,'top');
		var nextButEl = new Element('button.bix-nav',{
			text: self.options.nextText,
			type: 'button'
		}).addEvent('click', function () {
			self.navigate('next');
		});
		parent.grab(nextButEl,'bottom');
	},
	navigate: function(direction) {
		var newValue = this.newValue(direction);
	console.log(direction,newValue);
		if (newValue) {
			this.selectEl.set('value',newValue);
			this.selectEl.fireEvent('change');
		}
	},
	newValue: function(direction) {
		var current = this.selectEl.get('value');
		var currentKey = false, last = false, newValue = false;
		this.selectEl.getElements('option').each(function (optionEl, key) {
			if (last && optionEl.get('value') == current) {
				if (direction == 'prev')
					newValue = last;
				else 
					currentKey = key
			}
			last = optionEl.get('value');
			if (currentKey == (key-1) && direction == 'next') {
				newValue = optionEl.get('value');
			}
		});
		return newValue;
	}
});





