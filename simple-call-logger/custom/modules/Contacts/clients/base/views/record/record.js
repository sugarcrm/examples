/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

({
    extendsFrom: 'RecordView',

    events: {
        'click a[name=payment]': 'paymentClicked'
    },

    /**
     * @inheritdoc
     */
    initialize: function(options) {
//        this.plugins = _.union(this.plugins || [], ['HistoricalSummary']);
//        this.plugins.push('ContactsPortalMetadataFilter');
        this._super('initialize', [options]);
//        this.removePortalFieldsIfPortalNotActive(this.meta);
    },

    paymentClicked: function()
    {
        app.drawer.open({
            layout: 'payment',
            context: {
                module: 'Calls'
            }
        });

    }
})