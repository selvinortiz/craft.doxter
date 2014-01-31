var Doxter = {
	addEditorBehavior: function(id, tabSize, softTabs) {
		var editoBehavior = new Behave(Doxter.getBehaviorConfig(""+id, tabSize, softTabs));
	},

	createDoxterMarkdown: function(id, tabSize, softTabs) {
		var fieldBehavior = new Behave(Doxter.getBehaviorConfig(""+id, tabSize, softTabs));

		$("#"+id+"Canvas").removeClass("doxterHidden");
	},

	getBehaviorConfig: function(id, tabSize, softTabs) {
		return {
			textarea: document.getElementById(id),
			softTabs: softTabs ? true : false,
			tabSize: tabSize,
			replaceTab: true,
			autoOpen: true,
			overwrite: true,
			autoStrip: true,
			autoIndent: true,
			fence: false
		};
	}
};
