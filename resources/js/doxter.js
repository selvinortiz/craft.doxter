var Doxter = {
	createDoxterMarkdown: function(id, tabSize, softTabs) {
		var
			writeBtn	= $("#"+id+"WriteBtn"),
			previewBtn	= $("#"+id+"PreviewBtn"),
			canvas		= $("#"+id+"Canvas"),
			editor		= $("#"+id),
			preview		= $("#"+id+"Preview"),
			behavior	= new Behave(Doxter.getBehaviorConfig(""+id, tabSize, softTabs));

		editor.crevasse({
			previewer: preview,
			previewStyle: "github",
			convertTabsToSpaces: false
		});

		editor.on("keyup", function() {
			editor.trigger("change");
		});

		writeBtn.bind("click", function(e) {
			self	= $(this);
			editor	= $(self.attr("href")+"EditorPane");
			preview	= $(self.attr("href")+"PreviewPane");

			editor.show();
			preview.hide();
			previewBtn.show();
			self.hide();
			e.preventDefault();
		});

		previewBtn.bind("click", function(e) {
			self	= $(this);
			editor	= $(self.attr("href")+"EditorPane");
			preview	= $(self.attr("href")+"PreviewPane");

			preview.show();
			editor.hide();
			writeBtn.show();
			self.hide();
			e.preventDefault();
		});

		writeBtn.trigger("click");

		canvas.removeClass("doxterHidden");
	},
	getTabConfig: function() {
		return {
			cache: false,
			updateHash: false
		};
	},
	getBehaviorConfig: function(id, tabSize, softTabs) {
		return {
			textarea: document.getElementById(id),
			softTabs: softTabs ? true : false,
			tabSize: tabSize,
			replaceTab: softTabs ? true : false,
			autoOpen: true,
			overwrite: true,
			autoStrip: true,
			autoIndent: true,
			fence: false
		};
	}
};
