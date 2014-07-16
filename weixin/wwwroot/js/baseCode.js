var urls = new function()
{
	var $ = this, unicode = String.fromCharCode, base64code = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/==';

	$.strval = String;

	$.utf8_decode = function(){
		var asciihigh = /[\x80-\xFF]{2,3}/g;
		function decode( a ) {
			return unicode( a.charCodeAt(2) ?
				( a.charCodeAt(0) & 15 ) << 12 | ( a.charCodeAt(1) & 63 ) << 6 | a.charCodeAt(2) & 63 :
				( a.charCodeAt(0) & 31 ) << 6 | a.charCodeAt(1) & 63 );
		};
		return function( a ) {
			return $.strval( a ).replace( asciihigh, decode );
		};
	}();

	$.utf8_encode = function(){
		var multibyte = /[^\x00-\x7F]/g;
		function encode( a ) {
			return ( a = a.charCodeAt(0) ) < 2048 ?
				unicode( a >> 6 | 192, a & 63 | 128 ) :
				unicode( a >> 12 | 224, a >> 6 & 63 | 128, a & 63 | 128 );
		};
		return function( a ) {
			return $.strval( a ).replace( multibyte, encode );
		};
	}();
	//URLs
	$.base64_decode = function( a ) {
		for ( var s = 0, d = $.strval( a ), f = '', g = d.length, h, j, k, l; s < g; ) {
			h = base64code.indexOf( d.charAt( s++ ) ),
			j = base64code.indexOf( d.charAt( s++ ) ),
			k = base64code.indexOf( d.charAt( s++ ) ),
			l = base64code.indexOf( d.charAt( s++ ) ),
			a = h << 18 | j << 12 | k << 6 | l,
			f += k > 63 ?
					unicode( a >> 16 & 255 ) :
				l > 63 ?
					unicode( a >> 16 & 255, a >> 8 & 255 ) :
					unicode( a >> 16 & 255, a >> 8 & 255, a & 255 );
		};
		return $.utf8_decode( f );
	};

	$.base64_encode = function( a ) {
		for ( var s = 0, d = $.utf8_encode( a ), f = '', g = d.length; s < g; ) {
			a = d.charCodeAt( s++ ) << 16 | d.charCodeAt( s++ ) << 8 | d.charCodeAt( s++ ),
			f += base64code.charAt( a >> 18 & 63 ) +
				base64code.charAt( a >> 12 & 63 ) +
				base64code.charAt( a >> 6 & 63 ) +
				base64code.charAt( a & 63 );
		};
		return ( g %= 3 ) ? f.slice( 0, -( 3 - g ) ) + base64code.slice( -( 3 - g ) ) : f;
	};
}


//alert( urls.base64_decode( urls.base64_encode( '你好' ) ) );