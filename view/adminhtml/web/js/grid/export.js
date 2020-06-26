/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    'jquery',
    'Magento_Ui/js/grid/export',
    'underscore'
], function ($, Component, _) {
    'use strict';

    return Component.extend({
        defaults: {
            columnsProvider: 'ns = ${ $.ns }, componentType = columns',
            imports: {
                addColumns: '${ $.columnsProvider }:elems'
            }
        },
        _columns: [],

        addColumns: function(columns) {
            this._columns = _.where(columns, {
                controlVisibility: true
            });
        },

        getVisibleColumns: function() {
            var self = this,
                columns = [];

            $.each(this._columns, function(i) {
                var column = self._columns[i];

                if ((column.dataType !== 'actions') && column.visible) {
                    columns.push(column.index);
                }
            });

            return columns;
        },

        getParams: function () {
            var selections = this.selections(),
                columns = this.getVisibleColumns(),
                data = selections ? selections.getSelections() : null,
                itemsType,
                result = {};

            if (data) {
                itemsType = data.excludeMode ? 'excluded' : 'selected';
                result.filters = data.params.filters;
                result.columns = columns;
                result.search = data.params.search;
                result.namespace = data.params.namespace;
                result[itemsType] = data[itemsType];

                if (!result[itemsType].length) {
                    result[itemsType] = false;
                }
            }

            return result;
        }
    });
});
