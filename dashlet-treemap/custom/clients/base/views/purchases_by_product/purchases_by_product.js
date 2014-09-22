({

    plugins: ['Dashlet'],

    initDashlet: function() {
        if(this.meta.config) {
            var limit = this.settings.get("limit") || "5";
            this.settings.set("limit", limit);
        }
    },

    loadData: function (options) {
        var name, limit;
    }

})