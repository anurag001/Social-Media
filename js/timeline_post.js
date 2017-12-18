			$("#askbtn").click(function(){

				$("#postid").hide();
				$("#askid").fadeIn();
			});
			
			$("#postbtn").click(function(){
				
				$("#postid").fadeIn();
				$("#askid").hide();
			});
			
			
			$("#timeline-question-post").on('submit',function(e){
				
				e.preventDefault();
				var quest = $("#askdata").val();
				var pioneer = $("#pioneerto").val();
				
				quest = $.trim(quest);
				pioneer = $.trim(pioneer);
				
				if(quest == '' || pioneer == '')
				{
					$("#ask-result").html('<div style="color:red">Please fill both fields</div>');
				}
				else
				{
					var formData = new FormData(this);
					formData.append("quest",quest);
					formData.append("pioneer",pioneer);
					$.ajax({
						url:'askquest.php',
						type:"POST",
						data:formData,
						contentType:false,
						cache:false,
						processData:false,
					success:function(resp)
					{
						$("#ask-result").html(resp);
						setTimeout(function() {
							$("#ask-result").fadeOut();
						}, 3000);
						$("#pioneerto").val('');
						$("#askdata").val('');
					},
					error:function()
					{
						
					},
					complete:function(){
						pullPost();
					}
				});
				
				}
				
			});
			
			
			$("#timeline-post").on('submit',function(e){
				e.preventDefault();
				var postdata = $("#postdata").val();
				
				postdata = $.trim(postdata);
				if(postdata == '')
				{
					$("#post-result").html('<div style="color:red">Please enter something</div>');
				}
				else
				{
					var formData = new FormData(this);
					formData.append("postdata",postdata);
					$.ajax({
						url:'postdata.php',
						type:"POST",
						data:formData,
						contentType:false,
						cache:false,
						processData:false,
						success:function(data)
						{
							$("#post-result").html(data);
							setTimeout(function(){
								$("#post-result").fadeOut();
							}, 3000);
							$("#postdata").val('');
							$("#postpic").val('');
						},
						error:function()
						{
							
						},
						complete:function()
						{
							pullPost();
						}
					});
				}
			});
		
			function pullPost()
			{
				$.ajax({
					url: 'postview.php',
					method: "POST",
					data:'id='+<?php echo $user_id;?>+'&userid='+<?php echo $user_id;?>,
					success: function(data) {
						
						$('.postview').html(data);
					},
					error: function() {
						$(".postview").html('There is some error occured').fadeIn();
					}
				});
			}
			window.onload = function() {
				pullPost();
			};
			