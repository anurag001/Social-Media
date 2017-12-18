
			function showHint(query) {
				if (query != "") {
					$.ajax({
						url: './pioneersearch.php',
						method: 'GET',
						data:'query='+query,
						success: function(result) {
							$('#searchResult').slideDown('fast');
							$('#searchResult').html(result);
						},
						error: function() {
							$('#searchResult').html('We are facing some problem');
						},
						complete: function() {
							document.onclick = function() {
								$('#searchResult').slideUp(600);
								
							}

						}
					});
				}
			}