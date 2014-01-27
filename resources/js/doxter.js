var Doxter = {
	loadEditor: function() {

		$(".editor").crevasse({
			previewer: $(".preview"),
			editorStyle: "editorStyle"
		});

		var behaved = new Behave(doxterEditorConfig);
	}
};

$(document).ready(function() {
	Doxter.loadEditor();
});
