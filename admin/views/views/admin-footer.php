<script language="JavaScript" type="text/javascript" src="../js/popper.min.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/bootstrap.min.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/Chart.min.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/shards.min.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/jquery.sharrre.min.js"></script>
<script language="JavaScript" type="text/javascript" src="../scripts/extras.1.1.0.min.js"></script>
<script language="JavaScript" type="text/javascript" src="../scripts/shards-dashboards.1.1.0.min.js"></script>
<script language="JavaScript" type="text/javascript" src="../scripts/app/app-blog-overview.1.1.0.js"></script>
<script language="JavaScript" type="text/javascript" src="../scripts/myjs.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/select2.min.js"></script>

<script>
	//$( document ).ready( function () {
	$( "#addImages" ).click( function () {
		$( "#insert" ).append( '<br \><input type="file" name="img[]">' );
	} );
	$( '.cus-selected' ).select2( {
			placeholder: {
				id: '',
				text: 'Vui lòng chọn bằng cấp'
			}
		} )
		.on( "select2:select", function ( e ) {
			setScrollTopForDropDown( e );
		} )
		.on( "select2:selecting", function ( e ) {
			setScrollTopForSelectBox( e );
		} )
		.on( "select2:unselect", function ( e ) {
			setScrollTopForDropDown( e );
		} )
		.on( "select2:unselecting", function ( e ) {
			$( this ).data( "state", "unselected" );
			setScrollTopForSelectBox( e );
		} )
		.on( "select2:open", function ( e ) {
			if ( $( this ).data( "state" ) === "unselected" ) {
				$( this ).removeData( "state" );
				$( this ).select2( "close" );
			}
		} );

	function setScrollTopForDropDown( e ) {
		$( ".select2-results__options" ).scrollTop( $( e.currentTarget ).data( "scrolltop" ) );
	};

	function setScrollTopForSelectBox( e ) {
		$( e.currentTarget ).data( "scrolltop", $( ".select2-results__options" ).scrollTop() );
	};
	$( '.formatCurrency' ).on( 'input', function ( e ) {
		var number = this.value.replace( /[.]/g, '' );
		if(number.length > 1)
			number = number.replace(/^0+/, '');
		var n = number.split( '' ).reverse().join( "" );
		var n2 = n.replace( /\d\d\d(?!$)/g, "$&." );
		$( this ).val( n2.split( '' ).reverse().join( "" ));
	} ).on( 'keypress', function ( e ) {
		if ( !$.isNumeric( String.fromCharCode( e.which ) ) ) e.preventDefault();
	} ).on( 'paste', function ( e ) {
		var cb = e.originalEvent.clipboardData || window.clipboardData;
		if ( !$.isNumeric( cb.getData( 'text' ) ) ) e.preventDefault();
	} );
	//} );
</script>
</body>
</html>