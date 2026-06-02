/**
 * Media picker and repeater UI for Lubben Vet page custom fields.
 */
( function ( $ ) {
	'use strict';

	function getPreviewWrap( input ) {
		return input.closest( '.lv-image-picker, .lubben-vet-page-fields__row' ).find( '.lubben-vet-page-fields__preview' );
	}

	function setPreviewImage( preview, attachment ) {
		var url =
			attachment.sizes && attachment.sizes.medium
				? attachment.sizes.medium.url
				: attachment.sizes && attachment.sizes.thumbnail
					? attachment.sizes.thumbnail.url
					: attachment.url;

		preview
			.removeClass( 'is-empty' )
			.html( '<img class="lubben-vet-page-fields__thumb" src="' + url + '" alt="">' );
	}

	function clearPreview( preview ) {
		preview.addClass( 'is-empty' ).empty();
	}

	function reindexRepeater( repeater ) {
		var itemLabel = repeater.data( 'item-label' ) || 'Item';

		repeater.find( '.lubben-vet-repeater__item' ).each( function ( index ) {
			var item = $( this );
			item.attr( 'data-index', index );
			item.find( '.lubben-vet-repeater__item-title' ).text( itemLabel + ' #' + ( index + 1 ) );

			item.find( '[name]' ).each( function () {
				var input = $( this );
				var name = input.attr( 'name' );
				if ( ! name ) {
					return;
				}
				input.attr(
					'name',
					name.replace( /\[\d+\]/, '[' + index + ']' )
				);
			} );

			item.find( '[id^="lubben-vet-field-"]' ).each( function () {
				var input = $( this );
				var id = input.attr( 'id' );
				if ( ! id ) {
					return;
				}
				var nextId = id.replace( /-\d+-/, '-' + index + '-' ).replace( /-__INDEX__-/, '-' + index + '-' );
				input.attr( 'id', nextId );
			} );

			item.find( '[data-target]' ).each( function () {
				var button = $( this );
				var target = button.data( 'target' );
				if ( ! target ) {
					return;
				}
				button.attr(
					'data-target',
					target.replace( /-\d+-/, '-' + index + '-' ).replace( /-__INDEX__-/, '-' + index + '-' )
				);
			} );
		} );

		repeater.find( '.lubben-vet-repeater__empty' ).toggle( repeater.find( '.lubben-vet-repeater__item' ).length === 0 );
	}

	$( document ).on( 'click', '.lubben-vet-page-fields__choose', function ( e ) {
		e.preventDefault();

		var targetId = $( this ).data( 'target' );
		var input = $( '#' + targetId );
		var preview = getPreviewWrap( input );
		var frame = wp.media( {
			title: 'Choose image',
			button: { text: 'Use this image' },
			library: { type: 'image' },
			multiple: false,
		} );

		frame.on( 'select', function () {
			var attachment = frame.state().get( 'selection' ).first().toJSON();
			input.val( attachment.id );
			setPreviewImage( preview, attachment );
		} );

		frame.open();
	} );

	$( document ).on( 'click', '.lubben-vet-page-fields__remove', function ( e ) {
		e.preventDefault();
		var targetId = $( this ).data( 'target' );
		var input = $( '#' + targetId );
		input.val( '0' );
		clearPreview( getPreviewWrap( input ) );
	} );

	$( document ).on( 'click', '.lubben-vet-repeater__add', function ( e ) {
		e.preventDefault();

		var repeater = $( this ).closest( '.lubben-vet-repeater' );
		var key = repeater.data( 'key' );
		var template = $( '.lubben-vet-repeater__template[data-key="' + key + '"]' ).html();

		if ( ! template ) {
			return;
		}

		var index = repeater.find( '.lubben-vet-repeater__item' ).length;
		var html = template.replace( /__INDEX__/g, String( index ) );

		repeater.find( '.lubben-vet-repeater__empty' ).remove();
		repeater.find( '.lubben-vet-repeater__items' ).append( html );
		reindexRepeater( repeater );
	} );

	$( document ).on( 'click', '.lubben-vet-repeater__remove', function ( e ) {
		e.preventDefault();

		var repeater = $( this ).closest( '.lubben-vet-repeater' );
		$( this ).closest( '.lubben-vet-repeater__item' ).remove();
		reindexRepeater( repeater );
	} );
} )( jQuery );
