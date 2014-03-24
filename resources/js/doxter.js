function Doxter(id, config) {
    this.uid				= id;
    this.behave				= {};
    this.tabSize			= config.tabSize || 4;
    this.softTabs			= config.softTabs || true;
    this.$editor			= $("#" + this.uid);
    this.$container			= !! config.container ? $("#" + config.container) : $("#" + this.uid + "Canvas");
    this.$selectEntryButton	= $("#" + this.uid + "SelectEntry");
    this.$selectAssetButton	= $("#" + this.uid + "SelectAsset");
    this.$selectUserButton	= $("#" + this.uid + "SelectUser");
    this.$selectTagButton   = $("#" + this.uid + "SelectTag");
    this.$selectGlobalButton= $("#" + this.uid + "SelectGlobal");
    this.selectEntryModal	= null;
    this.selectAssetModal	= null;
    this.selectUserModal	= null;
    this.selectTagModal     = null;
    this.selectGlobalModal	= null;

	return this
}

Doxter.prototype.render = function() {
    this.behave = this.behavior(this.uid, this.tabSize, this.softTabs);
    this.toolbar();
    this.$container.removeClass("doxterHidden");

    return this
};

Doxter.prototype.toolbar = function() {
    var self = this;

    this.$selectEntryButton.on("click", function(e) {
        self.selectEntryModal = Craft.createElementSelectorModal("Entry", {
            id: this.uid + "SelectEntryModal",
            criteria: {},
            onSelect: function(elements) {
                var tags = self.createTags("entry", elements);
                self.write(tags)
            }
        });
        e.preventDefault()
    });

    this.$selectAssetButton.on("click", function(e) {
        this.selectAssetModal = Craft.createElementSelectorModal("Asset", {
            id: this.uid + "SelectAssetModal",
            criteria: {},
            onSelect: function(elements) {
                var tags = self.createTags("asset", elements);
                self.write(tags)
            }
        });
        e.preventDefault()
    });

    this.$selectUserButton.on("click", function(e) {
        this.selectUserModal = Craft.createElementSelectorModal("User", {
            id: this.uid + "SelectUserModal",
            criteria: {},
            onSelect: function(elements) {
                var tags = self.createTags("user", elements);
                self.write(tags)
            }
        });
        e.preventDefault()
    });

    this.$selectTagButton.on("click", function(e) {
        this.selectTagModal = Craft.createElementSelectorModal("Tag", {
            id: this.uid + "SelectTagModal",
            criteria: {},
            onSelect: function(elements) {
                var tags = self.createTags("tag", elements);
                self.write(tags)
            }
        });
        e.preventDefault()
    });

    this.$selectGlobalButton.on("click", function(e) {
        self.write("{globalset:id:property}")
        e.preventDefault()
    });

    return this
};

Doxter.prototype.behavior = function() {
    var a = {
        textarea: document.getElementById(this.uid),
        softTabs: this.softTabs,
        tabSize: this.tabSize,
        replaceTab: true,
        autoOpen: true,
        overwrite: true,
        autoStrip: true,
        autoIndent: true,
        fence: false
    };

    this.behave = new Behave(a);

    return this
};

Doxter.prototype.write = function(a) {
    this.$editor.textrange("insert", a);
    this.$editor.textrange("set", this.$editor.textrange().end - 9, 8);
    return this
};

Doxter.prototype.createTags = function(type, elements) {
    var i = 0, tags	= "", tag;

    for (; i < elements.length; i++) {
        tag		= type.toLowerCase() + ":" + elements[i].id;
        tags	= tags + "{" + tag + ":property}"
    }

    return tags;
};