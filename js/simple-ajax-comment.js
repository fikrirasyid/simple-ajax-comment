jQuery(document).ready(function($){
	/**
	* Ajaxify Comment Submission
	* Assuming that comment form's ID is #commentform. Adjust it as you see fit
	*/
	$('body').on('submit', '#commentform', function(e){
		// Stop the default form behavior
		e.preventDefault();

		var commentform 		= $(this);
		var action 				= commentform.attr( 'action' );
		var inputs 				= commentform.serializeArray();
		var submitting_comment 	= $('#submitting-comment');

		// Submitting comment
		commentform.ajaxSubmit({
			beforeSend: function(){
				// Display the loading state
				commentform.find('p').slideUp();
				submitting_comment.slideDown();
			},
			success: function( responseText, statusText, xhr, form ) {
				// Switch the existing comment area with the comment area returned from AJAX call
				var page 		= $(responseText);
				var comments 	= page.find('.comments-area' );
				$('.comments-area').replaceWith( comments );
		    },
		    error: function( xhr, textStatus, errorThrown ){
		    	// Translates the error code status into understandable error message
		    	if( textStatus == 'error' ){
		    		var error_code = xhr.status;
		    		alert( simple_ajax_comment_params.error_messages[error_code] );
	
					// Unloading state
					commentform.find('p').slideDown();
					submitting_comment.slideUp();
		    	}
		    },
			url : action,
			clearForm : true,
			data : inputs
		});
	})
});