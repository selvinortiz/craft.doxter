(function($, Craft)
{
	Craft.DoxterFieldType = Garnish.Base.extend(
	{
		init: function(id, config)
		{
			this.id						= id;
			this.$editor				= $("#" + this.id);
			this.$container				= $("#" + this.id + "Canvas");
			this.$selectEntryButton		= $("#" + this.id + "SelectEntry");
			this.$selectAssetButton		= $("#" + this.id + "SelectAsset");
			this.$selectUserButton		= $("#" + this.id + "SelectUser");
			this.$selectTagButton		= $("#" + this.id + "SelectTag");
			this.$selectGlobalButton	= $("#" + this.id + "SelectGlobal");
			// ~
			this.tabSize				= config.tabSize	|| 4;
			this.softTabs				= config.softTabs	|| true;
			// ~
			this.addListener(this.$selectEntryButton, 'click', 'createEntrySelectorModal');
			this.addListener(this.$selectAssetButton, 'click', 'createAssetSelectorModal');
			this.addListener(this.$selectUserButton, 'click', 'createUserSelectorModal');
			this.addListener(this.$selectTagButton, 'click', 'createTagSelectorModal');
			this.addListener(this.$selectGlobalButton, 'click', 'createGlobalSetSelectorModal');
		},

		renderFieldType: function()
		{
			this.addBehavior();
			this.$container.removeClass('doxterHidden');

			return this
		},

		addBehavior: function()
		{
			return new Behave(
			{
				textarea:	document.getElementById(this.id),
				softTabs:	this.softTabs,
				tabSize:	this.tabSize,
				autoOpen:	true,
				overwrite:	true,
				autoStrip:	true,
				autoIndent:	true,
				replaceTab:	true,
				fence:		false
			});
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

		createGlobalSetSelectorModal: function(e)
		{
			this.writeToEditor("{globalset:id:property}")
			e.preventDefault();
		},

		writeToEditor: function(text)
		{
			this.$editor.textrange("insert", text);
			this.$editor.textrange("set", this.$editor.textrange().end - 9, 8);

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