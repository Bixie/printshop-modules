/* Bixie Printshop
 * Module BPS Stats
 */
 

 var modBPSstats = new Class({
	Implements: [Options],
	options: {
		elIds: {
			periode: '',
			graph: ''
		},
		templates: {
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
		reqUrl: 'index.php?option=com_bixprintshop&format=raw&task=plugin.triggermodule&action=bps_stats.showstats'
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
		this.els.periode.addEvent('change', function (e) {
			self.loadGraphs();
		});
// console.log(this.formEl,formID);
		this.loadGraphs();
	},
	loadGraphs: function () {
		var self = this;
		new Request.JSON({
			url: self.options.reqUrl,
			onRequest: self.els.graph.addClass('loading'),
			onError: function(text,error){self.els.graph.set('html',text)},
			onSuccess: function(result){self.setGraphs(result)} 
		}).send(self.formEl);

		
	},
	setGraphs: function (returndata) {
		var self = this;
		this.els.graph.removeClass('loading');
		var table = this.buildTable(returndata);
		
		this.els.graph.set('html',table)
	},
	buildTable: function (returndata) {
		var self = this, tmpl = this.options.templates;
		var html = tmpl.graphTitle.replace('{content}',returndata.graphInfo.titel);
		html += tmpl.tblStart;
		//labels toevoegen
		Object.each(returndata.fields,function(fieldInfo,fieldName) {
			html += tmpl.tblHead.replace('{content}',fieldInfo.label);
		});
		html += tmpl.tblEndHead;
console.log(returndata);
		//data uitlezen
		Object.each(returndata.infos,function(labelInfo,key) {
			var stats = returndata.stats[key];
			//rij maken
			html += tmpl.tblStartRow;
			Object.each(returndata.fields,function(fieldInfo,fieldName) {
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
	}
});











