/**
 * It is not uncommon for non-English speaking countries to use a comma for a
 * decimal place. This sorting plug-in shows how that can be taken account of in
 * sorting by adding the type `numeric-comma` to DataTables. A type detection 
 * plug-in for this sorting method is provided below.
 * 
 * Please note that the 'Formatted numbers' type detection and sorting plug-ins
 * offer greater flexibility that this plug-in and should be used in preference
 * to this method.
 *
 *  @name Commas for decimal place
 *  @summary Sort numbers correctly which use a comma as the decimal place.
 *  @deprecated
 *  @author [Allan Jardine](http://sprymedia.co.uk)
 *
 *  @example
 *    $('#example').dataTable( {
 *       columnDefs: [
 *         { type: 'numeric-comma', targets: 0 }
 *       ]
 *    } );
 */

jQuery.extend( jQuery.fn.dataTableExt.oSort, {

    "numeric-comma-pre": function ( a ) {
        function fSplit(a){
            var s = a.split('.');
            var x ="";
            for(var z = 0; z<s.length;z++){
                x += s[z];
            }
            return x;
        }
        var z = fSplit(a);
        var x = (z == "-") ? 0 : z.replace( /,/, "." );
        return parseFloat( x );
    },

    "numeric-comma-asc": function ( a, b ) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },

    "numeric-comma-desc": function ( a, b ) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
} );