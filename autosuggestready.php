<div class="input-group">
										<span class="input-group-addon">@</span>
										<input type="text" class="form-control" id="pioneerto" onkeyup="autosuggest(this.value)" placeholder="@username of Pioneer" autocomplete="off" required/>
										<div class="dropdown" id="suggest-box" style="margin-top:28px;">
											<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel" style="width:280px;overflow:none;" id="suggest">

											</ul>
										</div>
									</div>
			function autosuggest(str)
			{
				$.ajax({
					url:'autosuggest.php',
					method:"post",
					data:'str='+str,
					success:function(resp)
					{
						$("#suggest").slideDown();
						$("#suggest").html(resp);
					},
					complete: function() 
					{
							document.onclick = function() {
								$('#suggest').slideUp(600);	
							}

					}
				});
			}