var Doxter = {
	loadEditor: function() {

		$(".editor").crevasse({
			previewer: $(".preview"),
			convertTabsToSpaces: false
		});

		var behaved = new Behave(doxterEditorConfig);

		$("#fields-doxter").css("visibility", "visible").easytabs();
	}
};

$(document).ready(function() { Doxter.loadEditor(); });
