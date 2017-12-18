$("#del").click(function(e){
	
		var val = $("#del").attr('contextmenu');
		e.preventDefault();
		$.ajax({
			url:'delete_question.php',
			method:"post",
			data:'qid='+val,
			success:function(resp)
			{
				$(this).fadeOut();
			}
		});
	});
	
			$("#btnSave").click(function(e){
				e.preventDefault();
				var data = $("#edit-profile-form").serialize();
				$.ajax({
					url:'update_profile.php',
					method:"post",
					data:data,
					success:function(resp)
					{
						$("#edit-result").html(resp);
					},
					error: function() {
						$("#edit-result").html('There is some error occured').fadeIn();
					},
					complete:function(){}
				});
			});
			
			$("#closebtn").click(function(){
				$("#overlay").fadeOut();
				$("#overlaypic").fadeOut();
			});
			$("#close").click(function(){
				$("#overlay").fadeOut();
				$("#overlaypic").fadeOut();
			});
			$("#closebtn2").click(function(){
				$("#overlaypic").fadeOut();
			});
			$("#close2").click(function(){
				$("#overlaypic").fadeOut();
			});
			$("#edit-btn").click(function(){
				$("#overlay").fadeIn('fast');
			});
			
			$("#profile-pic").click(function(){
				$("#overlaypic").fadeIn('fast');								
			});
			
			$("#edit-profile-pic-form").on('submit',function(e){
				
					e.preventDefault();
							
					var formData = new FormData(this);
					formData.append("userid",<?php echo $user_id;?>);
					
				$.ajax({
						url:'upload_prof_pic.php',
						type:"POST",
						data:formData,
						contentType:false,
						cache:false,
						processData:false,
					success:function(resp)
					{
						$("#upload-result").html(resp);
						
					},
					error:function()
					{
						
					},
					complete:function(){
			
					}
				});
			
				
			});
			
					$(function(){
						
						$("#prof-pic").change(function(){
							var file = this.files[0];
							var imagefile = file.type;
							var match = ["image/jpeg","image/png","image/jpg"];
				
							if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
							{
								$("#post-result").html('<span style="color:red">Select valid image extension in jpg/jpeg/png</span>');
								return false;
							}
							else
							{
								var reader = new FileReader();
								reader.onload = imageIsLoaded;
								reader.readAsDataURL(this.files[0]);
							}
						});
					});
			function imageIsLoaded(e)
			{
				$("#file").css("color","green");
				$("#image_preview").css("display","block");
				$("#image").attr('src',e.target.result);
				$("#image").attr("width","250px");
				$("#image").attr("width","230px");
			}
