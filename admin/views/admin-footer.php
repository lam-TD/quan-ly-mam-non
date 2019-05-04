<script language="JavaScript" type="text/javascript" src="../js/popper.min.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/bootstrap.min.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/Chart.min.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/shards.min.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/jquery.sharrre.min.js"></script>
<script language="JavaScript" type="text/javascript" src="../scripts/extras.1.1.0.min.js"></script>
<script language="JavaScript" type="text/javascript" src="../scripts/shards-dashboards.1.1.0.min.js"></script>
<script language="JavaScript" type="text/javascript" src="../scripts/app/app-blog-overview.1.1.0.js"></script>
<script language="JavaScript" type="text/javascript" src="../scripts/myjs.js"></script>

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
	function validateSalary() {
								if ( $( "input[name='new-salary-basic']" ).val() == "" ) {
									$( "#editSalaryModal" ).find( '.text-danger' ).css( "display", "block" );
									return false;
								}
							}

							function getMonth( id ) {
								$.ajax( {
									type: "GET",
									url: "getMucLuong.php?yearid=" + id,
									success: function ( result ) {
										if ( id == 0 )
											$( '.get-month' ).prop( 'disabled', 'true' );
										else
											$( '.get-month' ).removeAttr( 'disabled' );
										$( '.get-month' ).html( result );
									}
								} );
							}

							function changeSalaryData( id ) {
								if ( id != 0 ) {
									var ajaxUrl = "admin-quanlyluong.php?salaryDataId=" + id;
									if ( id == 'reload' )
										ajaxUrl = "admin-quanlyluong.php";
									$.ajax( {
										type: "GET",
										url: ajaxUrl,
										success: function ( result ) {
											$( '.container-salary' ).html( $( result ).find( '.container-salary' ).html() );
										}
									} );
								}
							}
							$( '#targetLayer' ).on( 'mouseenter', function () {
			if($(this).hasClass('have-photo'))
				$( '#targetLayer .glyphicon' ).fadeIn();
		} );
		$( '#targetLayer' ).on( 'mouseleave', function () {
			if($(this).hasClass('have-photo'))
			$( '#targetLayer .glyphicon' ).fadeOut();
		} );
		$( '#targetLayer .glyphicon' ).on('click',function(){
			$( '#targetLayer input' ).click();
		});
	//} );
</script>
</body>
</html>