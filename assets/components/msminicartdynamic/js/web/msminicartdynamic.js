var msMiniCartDynamic = {
    
        init : {
                selectorAction : 'input[name=count]'
                ,action : '/assets/components/msminicartdynamic/connector.php'
                ,selectorResult : '#mc-dynamic'
                ,selectorClick : '.dynamic-count'
                ,cartChange : 'cart/chang'
        }
        ,changeDynamic : function( act ) {
            
            $.ajax({
                    type: 'POST'
                    ,url: this.init.action
                    ,data: { action : act }
                    ,cache: false
                    ,success: function( data ) {
                            var status = $.parseJSON( data );
                            
                            if( status['success'] == true ) {
                                    $( msMiniCartDynamic.init.selectorResult ).html( status['data']['tpl'] );
                            }
                            else {
                                    return false;
                            }
                    }
                    
            });
        }
        ,toCartDynamic : function( selectorForm ) {
                miniShop2.Callbacks.Cart.add.response.success = function( response ) {
                        if( response['success'] == true ) {
                                msMiniCartDynamic.changeDynamic( 'add' );
                                $( selectorForm+ ' .dynamic-key' ).val( response['data']['key'] );
                                $( selectorForm + ' .dynamic-action' ).val( 'cart/change' );
                        }
                };
        }
        ,changeCartDynamic : function( selectorForm, count  ) {
                miniShop2.Callbacks.Cart.change.response.success = function( response ) {
                        if( response['success'] == true ) {
                                msMiniCartDynamic.changeDynamic( 'add' );

                                if ( isNaN(count) || count == 0 ) {
                                        $( selectorForm + ' .dynamic-action' ).val( 'cart/add' );
                                }
                                else {
                                        $( selectorForm + ' .dynamic-action' ).val( 'cart/change' );
                                }
                        }
                };
        }
        
};

$(document).ready(function(){

	$( msMiniCartDynamic.init.selectorAction ).bind( 'keypress', function(b){
		var C = /[0-9\x25\x24\x23\x13]/;
		var a = b.which;
		var c = String.fromCharCode(a);

		return !!(a==0||a==8||a==9||a==13||c.match(C));
	});

	$( document ).on( 'change keypress', msMiniCartDynamic.init.selectorAction, function( event ){
		var selectorForm = '#' +  $( this ).closest( 'form' ).attr( 'id' );
		var count = parseInt($( this ).val());
		var c = $( selectorForm + ' .dynamic-action' ).val();

		if ( event.which == 13 ) {

			if ( c == 'cart/add' ) {
				msMiniCartDynamic.toCartDynamic( selectorForm );
			}
			else {
				msMiniCartDynamic.changeCartDynamic( selectorForm, count );
			}
			$(this).blur();

			return false;
		}
		else if ( event.type == 'change' ) {
			$( this ).closest( selectorForm ).submit();

			if ( c == 'cart/add' ) {
				msMiniCartDynamic.toCartDynamic( selectorForm );
			}
			else {
				msMiniCartDynamic.changeCartDynamic( selectorForm, count );
			}
		}
	});

	$( document ).on( 'click', msMiniCartDynamic.init.selectorClick, function(e) {
		e.preventDefault();
		var selectorForm = '#' +  $( this ).closest( 'form' ).attr( 'id' );
		var current = $( selectorForm + ' input[name=count]');
		var count = parseInt(current.val());
		var dynamic = parseInt( $( this ).data( 'dynamic' ) );
		var key = $( selectorForm + ' .dynamic-key' );

		if ( isNaN( count ) && dynamic == +1 ) {
			count = 0;
			current.val( count + dynamic ).submit();

			msMiniCartDynamic.toCartDynamic( selectorForm );
		}
		else if ( isNaN( count ) && dynamic == -1 ) {
			return false;
		}
		else if ( count == 1 && dynamic == -1 ) {
			current.val( '' ).submit();
			msMiniCartDynamic.changeCartDynamic( selectorForm, count - 1 );
			$( selectorForm + ' .dynamic-action' ).val( 'cart/add' );
		}
		else {
			current.val( count + dynamic ).submit();
			msMiniCartDynamic.changeCartDynamic( selectorForm, count );
			$( selectorForm + ' .dynamic-action' ).val( 'cart/change' );
		}
	});
	// Обновление мини корзины без +/-
	$(document).on('submit', 'form', function(e) {
		var cls = $( this ).attr( 'class' );
		var id = $( this ).closest( 'form' ).children( 'input[name=id]' ).val();
		if ( cls != 'dynamic-action' ) {
			miniShop2.Callbacks.Cart.add.response.success = function( response ) {
				if( response['success'] == true ) {
					msMiniCartDynamic.changeDynamic( 'add' );
				}
			}
			miniShop2.Callbacks.Cart.remove.response.success = function( response ) {
				if( response['success'] == true ) {
					msMiniCartDynamic.changeDynamic( 'remove' );
					
					if( $( 'form' ).is( '#dynamic-' + id ) ) {
						var selector = '#dynamic-' + id;
						
						$( selector + ' input[name=key]' ).val( '' );
						$( selector + ' .dynamic-action' ).val( 'cart/add' );
						$( selector + ' input[name=count]' ).val( '' );
					}
				}
			}
		}
		else {
			return false;
		}
	});
});
