$(document).on('pageshow', function(){ // $(function(){
	var selector, logActivity, callbackAlbumSelected, callbackPhotoUnselected, callbackSubmit;
	var buttonOK = $('#CSPhotoSelector_buttonOK');
	var o = this;
	fbphotoSelect = function(id) {
		// if no user/friend id is sent, default to current user
		if (!id) id = 'me';
		callbackAlbumSelected = function(albumId) {
			var album, name;
			album = CSPhotoSelector.getAlbumById(albumId);
			// show album photos
			selector.showPhotoSelector(null, album.id);
		};
		callbackAlbumUnselected = function(albumId) {
			var album, name;
			album = CSPhotoSelector.getAlbumById(albumId);
		};
		// when photo is selected
		callbackPhotoSelected = function(photoId) {
			var photo;
			photo = CSPhotoSelector.getPhotoById(photoId);
			buttonOK.show();
			var orientation = '';
			if (photo.height > photo.width ) { 
				orientation = 'portrait'; 
			} else { 
				orientation = 'landscape'; 
			}

			// id's of the text fields populated by data
			$('#fbimageurl').val(photo.source);
			$('.createPool .profile_img').attr("src", photo.source);
			$('#fbimageorientation').val(orientation);
			$('.createPool .profile_img').removeClass('portrait landscape').addClass(orientation);
		};
		// Initialise the Photo Selector with options that will apply to all instances
		CSPhotoSelector.init({debug: false});
		// Create Photo Selector instances
		selector = CSPhotoSelector.newInstance({
			callbackAlbumSelected	: callbackAlbumSelected,
			callbackPhotoSelected	: callbackPhotoSelected,
			maxSelection			: 1,
			albumsPerPage			: 6,
			photosPerPage			: 200
		});
		// reset and show album selector
		selector.reset();
		selector.showAlbumSelector(id);
	}
	// MRY: this is the photoselect photo selected click function
	$(".photoSelect").click(function (e) {
		e.preventDefault();
		id = null;
		if ( $(this).attr('data-id') ) id = $(this).attr('data-id');
		fbphotoSelect(id);
	});
});