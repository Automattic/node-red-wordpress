jQuery( document ).ready( function( $ ) {

	// Loop through all the shortcodes and keep their data fresh
	function nrwpUpdate() {
		$( '.nrwp-data' ).each( function() {
			// Pluck the data key from span atts
			var dataKey = $( this ).attr( 'data-key' );

			// Request URL for fresh data
			var reqUrl = nrwp.resturl + 'nrwp/v1/get/' + dataKey;

			// Class name for this specific element
			var className = '.nrwp-data-' + dataKey;
			
			// Make the request for fresh data
			$.get( reqUrl, function( response ) {
				if ( response.status ) {
					// Update the content of the span
					$( className ).html( response.data );
					
					// Add/update body atts
					$( 'body' ).attr( 'nrwp-' + dataKey, response.data );
				}
			} );
		} );
	}

	// Refresh update every 3 seconds
	setInterval( nrwpUpdate, 3000 );
} );