(function ($, Craft) {
  /**
   * General purpose Doxter module
   * Enables dynamic code block selection based on highlighter selected and other misc
   */
  Craft.Doxter = Garnish.Base.extend(
    {
      init: function () {
        this.$codeBlockSnippet = $('.codeBlockSnippet');
        this.$addPrismSnippetBtn = $('.addPrismSnippetBtn');
        this.$addRainbowSnippetBtn = $('.addRainbowSnippetBtn');

        this.addListener(this.$addPrismSnippetBtn, 'click', 'addHighlighterSnippet');
        this.addListener(this.$addRainbowSnippetBtn, 'click', 'addHighlighterSnippet');
      },

      addHighlighterSnippet: function (e) {
        var highlighter = $(e.target).data('highlighter');

        switch (highlighter) {
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
      init: function (id) {
        this.id = id;
        this.$textarea = $("#" + this.id);
        this.$selectEntryButton = $("#" + this.id + "SelectEntry");
        this.$selectAssetButton = $("#" + this.id + "SelectAsset");
        this.$selectUserButton = $("#" + this.id + "SelectUser");
        this.$selectTagButton = $("#" + this.id + "SelectTag");
        this.$selectCategoryButton = $("#" + this.id + "SelectCategory");
        this.$selectGlobalButton = $("#" + this.id + "SelectGlobal");
        this.addListener(this.$selectEntryButton, 'click', 'createEntrySelectorModal');
        this.addListener(this.$selectAssetButton, 'click', 'createAssetSelectorModal');
        this.addListener(this.$selectUserButton, 'click', 'createUserSelectorModal');
        this.addListener(this.$selectTagButton, 'click', 'createTagSelectorModal');
        this.addListener(this.$selectCategoryButton, 'click', 'createCategorySelectorModal');
        this.addListener(this.$selectGlobalButton, 'click', 'createGlobalSetSelectorModal');
      },

      createSelectorModal: function (type) {
        var self = this;
        Craft.createElementSelectorModal(type,
          {
            id      : this.id + 'Select' + type + 'Modal',
            onSelect: function (elements) {
              var tags = self.createReferenceTags(type.toLowerCase(), elements, 'image');
              self.writeToEditor(tags);
            }
          });
      },

      createEntrySelectorModal: function (e) {
        this.createSelectorModal('Entry', e);
        e.preventDefault();
      },

      createUserSelectorModal: function (e) {
        this.createSelectorModal('User', e);
        e.preventDefault();
      },

      createAssetSelectorModal: function (e) {
        var self = this;
        Craft.createElementSelectorModal('Asset',
          {
            id         : this.id + 'SelectAssetModal',
            multiSelect: false,
            criteria   : {kind: 'image'},
            onSelect   : function (elements) {
              var tags = self.createReferenceTags('asset', elements, 'image');
              self.writeToEditor(tags);
            }
          });

        e.preventDefault();
      },

      createTagSelectorModal     : function (e) {
        this.createSelectorModal('Tag');
        e.preventDefault();
      },
      createCategorySelectorModal: function (e) {
        this.createSelectorModal('Category');
        e.preventDefault();
      },

      createGlobalSetSelectorModal: function (e) {
        this.writeToEditor('{globalset:id}')
        e.preventDefault();
      },

      writeToEditor: function (text) {
        prompt('Copy Reference Tag', text);
      },

      createReferenceTags: function (type, elements) {
        var i = 0, tags = "", tag;

        for (; i < elements.length; i++) {
          tag = type.toLowerCase() + ":" + elements[i].id;
          tags = tags + "{" + tag + "}"
        }

        return tags;
      }
    });

})(jQuery, Craft);
