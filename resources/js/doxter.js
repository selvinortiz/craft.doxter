(function($, Craft)
{
	/**
	 * General purpose Doxter module
	 * Enables dynamic code block selection based on highlighter selected and other misc
	 */
	Craft.Doxter = Garnish.Base.extend(
	{
		init: function()
		{
			this.$codeBlockSnippet		= $('.codeBlockSnippet');
			this.$addPrismSnippetBtn	= $('.addPrismSnippetBtn');
			this.$addRainbowSnippetBtn	= $('.addRainbowSnippetBtn');

			this.addListener(this.$addPrismSnippetBtn, 'click', 'addHighlighterSnippet');
			this.addListener(this.$addRainbowSnippetBtn, 'click', 'addHighlighterSnippet');
		},

		addHighlighterSnippet: function(e)
		{
			var highlighter = $(e.target).data('highlighter');

			switch (highlighter)
			{
				case 'PrismJs':
				{
					this.$codeBlockSnippet.val('<pre><code class="language-{languageClass}">{sourceCode}</code></pre>');

					break;
				}
				case 'RainbowJs':
				{
					this.$codeBlockSnippet.val('<pre><code data-language="language-{languageClass}">{sourceCode}</code></pre>');

					break;
				}
				default:
				{
					this.$codeBlockSnippet.val('<pre><code data-language="language-{languageClass}">{sourceCode}</code></pre>');
				}
			}

			e.preventDefault();
		}
	});

	/**
	 * DoxterFieldType class to manage fieldtype instances
	 */
	Craft.DoxterFieldType = Garnish.Base.extend(
	{
		init: function(id, config)
		{
			this.id						= id;
			this.$container				= $("#" + this.id + "Canvas");
			this.$livePreviewBtn		= $('#livepreview-btn');
			this.field					= $("#" + this.id);
			this.$selectEntryButton		= $("#" + this.id + "SelectEntry");
			this.$selectAssetButton		= $("#" + this.id + "SelectAsset");
			this.$selectUserButton		= $("#" + this.id + "SelectUser");
			this.$selectTagButton		= $("#" + this.id + "SelectTag");
			this.$selectCategoryButton	= $("#" + this.id + "SelectCategory");
			this.$selectGlobalButton	= $("#" + this.id + "SelectGlobal");
			// ~
			this.rows					= config.rows		|| 20;
			this.tabSize				= config.tabSize	|| 4;
			this.softTabs				= config.softTabs	|| true;
			// ~
			this.addListener(this.$selectEntryButton, 'click', 'createEntrySelectorModal');
			this.addListener(this.$selectAssetButton, 'click', 'createAssetSelectorModal');
			this.addListener(this.$selectUserButton, 'click', 'createUserSelectorModal');
			this.addListener(this.$selectTagButton, 'click', 'createTagSelectorModal');
			this.addListener(this.$selectCategoryButton, 'click', 'createCategorySelectorModal');
			this.addListener(this.$selectGlobalButton, 'click', 'createGlobalSetSelectorModal');
		},

		render: function()
		{
			this.addAceEditor();
			this.$container.removeClass('doxterHidden');
		},

		addAceEditor: function()
		{
			var self = this, height = this.rows * 15 + 'px';

			$('#' + this.id + 'Fake').addClass('doxterEditor').css({'height': height, 'max-height': height});

			this.editor = ace.edit(this.id + 'Fake');

			this.editor.renderer.setShowGutter(false);
			this.editor.setTheme('ace/theme/tomorrow');
			this.editor.getSession().setMode('ace/mode/markdown');
			this.editor.getSession().setTabSize(this.tabSize);
			this.editor.getSession().setUseSoftTabs(this.softTabs);
			this.editor.getSession().setUseWrapMode(false);
			this.editor.setHighlightActiveLine(true);
			this.editor.setShowPrintMargin(false);

			this.editor.getSession().on('change', function(e)
			{
				self.field.val(self.editor.getSession().getValue());
			});

			this.addListener(this.$livePreviewBtn, 'click', $.proxy(function(e)
			{
				$('#' + self.id + 'Fake', window.parent.document).hide();
			}, this));
		},

		createSelectorModal: function(type)
		{
			var self = this;

			Craft.createElementSelectorModal(type,
			{
				id: this.id + 'Select' + type + 'Modal',
				onSelect: function(elements)
				{
					var tags = self.createReferenceTags(type.toLowerCase(), elements);

					self.writeToEditor(tags);
				}
			});
		},

		createEntrySelectorModal: function(e)
		{
			this.createSelectorModal('Entry', e);
			e.preventDefault();
		},

		createUserSelectorModal: function(e)
		{
			this.createSelectorModal('User', e);
			e.preventDefault();
		},

		createAssetSelectorModal: function(e)
		{
			this.createSelectorModal('Asset');
			e.preventDefault();
		},

		createTagSelectorModal: function(e)
		{
			this.createSelectorModal('Tag');
			e.preventDefault();
		},
		createCategorySelectorModal: function(e)
		{
			this.createSelectorModal('Category');
			e.preventDefault();
		},

		createGlobalSetSelectorModal: function(e)
		{
			this.writeToEditor("{globalset:id:property}");
			e.preventDefault();
		},

		writeToEditor: function(text)
		{
			this.editor.insert(text);

			return this
		},

		createReferenceTags: function(type, elements)
		{
			var i = 0, tags	= "", tag;

			for (; i < elements.length; i++) {
				tag		= type.toLowerCase() + ":" + elements[i].id;
				tags	= tags + "{" + tag + ":property}"
			}

			return tags;
		}
	});

})(jQuery, Craft);
