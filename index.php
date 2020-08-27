<?php

    include("database_connection.php");
    session_start();

    if(!isset($_SESSION['user_id'])) {
        header("location:login.php");
    }
	
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ChatApp</title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.css">
        <link rel="stylesheet" href="style2.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
        <script src="https://use.fontawesome.com/38ca3b83ba.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    </head>
    <body>

        <header>
            <div class="contain">
                <h2 class="logo"><i class="fa fa-comments" aria-hidden="true"></i> ChatApp</h2>
                <nav>
                    <ul>
                        <li><button class="btn btn-outline-success my-2 my-sm-0" type="button" style="color:black;" onclick="location.href='logout.php'">Logout <i class="fa fa-sign-out" aria-hidden="true"></i></button></li>
                    </ul>
                </nav>
            </div>
        </header>

        <div class="wrapper">
            <div class="sidebar">
                <h2><i class="fa fa-user-circle-o" aria-hidden="true"></i> <?php echo $_SESSION['username']; ?></h2>
                <ul>
                    <li><a href="index.php"><i class="fa fa-commenting" aria-hidden="true"></i> Private Chat</a></li>
                    <!-- bohot mast jugaad -->
                    <li><a name="group_chat" id="group_chat"><i class="fa fa-users" aria-hidden="true"></i> Group Chat</a></li>
                    <!-- <li><a href="//<?php print $_SERVER{'SERVER_NAME'}; ?>:3000"><i class="fa fa-video-camera" aria-hidden="true"></i>Video Chat</a></li> -->
                    <li><a href="https://sat-webrtc.herokuapp.com/"><i class="fa fa-video-camera" aria-hidden="true"></i> Video Chat</a></li>
                </ul>
            </div>
            <div id="box">
                <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn"><i class="fa fa-bars" aria-hidden="true"></i> <span>Options</span></button>
            </div>
        </div>

        <center><h2>Welcome!!</h2></center>

        <div class="container" style="width:70%; margin-left:20%;">
        <br><br><br>

            <div class="row">
                <h4>Registered Users</h4>
                <div class="col-md-2 col-sm-3">
                    <input type="hidden" id="is_active_group_chat_window" value="no">  		<!-- value no means gcdb is not open on webpage -->
                </div>
            </div>
            <div class="table-responsive">
                    <div id="user_details"></div>
                    <div id="user_model_details"></div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
               

                $('#sidebarCollapse').on('click', function () {
                    $('.sidebar, #box').toggleClass('active');
                    $('.collapse.in').toggleClass('in');
                    $('a[aria-expanded=true]').attr('aria-expanded', 'false');
                });
            });
        </script>
    </body>
</html>

<style>
	.chat_message_area {
		position: relative;
		width: 100%;
		height: auto;
		background-color: #FFF;
		border: 1px solid #CCC;
		border-radius: 3px;
	}
	
	#group_chat_message {
		width: 100%;
		height: auto;
		min-height: 80px;
		overflow: auto;
		padding: 6px 24px 6px 12px;
    }
    
    .image_upload {
		position: absolute;
		top: 3px;
		right: 3px;
	}
	
	.image_upload > form > input {
		display: none;		<!-- this will hide file tag -->
	}
	
	.image_upload img {
		width: 24px;
		cursor: pointer;
	}
</style>

<div id="group_chat_dialog" title="Group Chat Window">
	<div id="group_chat_history" style="height:400px; border:1px solid #ccc; overflow-y:scroll; margin-bottom:24px; padding:16px;"></div>
	<div class="form-group">
		<!-- <textarea name="group_chat_message" id="group_chat_message" class="form-control"></textarea> -->
		<!-- making content editable chat box -->
		<div class="chat_message_area">
			<div id="group_chat_message" contenteditable class="form-control"></div>
			<div class="image_upload">
				<form id="uploadImage" method="POST" action="upload.php">
					<label for="uploadFile"><img src="upload.png"></label>
					<input type="file" name="uploadFile" id="uploadFile" accept=".jpg, .png">
				</form>
			</div>
		</div>
	</div>
	<div class="form-group" align="right">
		<button type="button" name="send_group_chat" id="send_group_chat" class="btn btn-info">Send</button>
	</div>
</div>

<script>
    $(document).ready(function() {

        fetch_user();

        // user login activity will be updated to database every 2 secs
        setInterval(function() {
            update_last_activity();
            fetch_user();                   // refresh user data every 2 secs on webpage
            update_chat_history_data();
			fetch_group_chat_history();
        }, 2000);

        function fetch_user() {
            $.ajax({
                url: "fetch_user.php",
                method: "POST",
                success: function(data) {
                    $('#user_details').html(data);
                }
            })
        }

        function update_last_activity() {
            $.ajax({
                url: "update_last_activity.php",
                success: function() {

                }
            })
        }

        function make_chat_dialog_box(to_user_id, to_user_name) {
            var modal_content = '<div id="user_dialog_'+to_user_id+'" class="user_dialog" title="Chat with '+to_user_name+'">';
            modal_content += '<div style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';
            modal_content += fetch_user_chat_history(to_user_id);
            modal_content += '</div>';
            modal_content += '<div class="form-group">';
            modal_content += '<textarea name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" class="form-control chat_message"></textarea>';
            modal_content += '</div><div class="form-group" align="right">';
            modal_content+= '<button type="button" name="send_chat" id="'+to_user_id+'" class="btn btn-info send_chat">Send</button></div></div>';
            
            $('#user_model_details').html(modal_content);
        }

        $(document).on('click', '.start_chat', function() {
            var to_user_id = $(this).data('touserid');
            var to_user_name = $(this).data('tousername');
            make_chat_dialog_box(to_user_id, to_user_name);
            $("#user_dialog_"+to_user_id).dialog({
                autoOpen:false,
                width:400
            });
            
            $('#user_dialog_'+to_user_id).dialog('open');
			$('#chat_message_'+to_user_id).emojioneArea({
				pickerPosition: "top",		// default
				searchPosition: "bottom",
				toneStyle: "bullet"
			});
        });

        $(document).on('click', '.send_chat', function() {
            var to_user_id = $(this).attr('id');
            var chat_message = $('#chat_message_'+to_user_id).val();
            $.ajax({
                url: "insert_chat.php",
                method: "POST",
                data: {to_user_id:to_user_id, chat_message:chat_message},      // data to be sent to server
                success: function(data) {   
                    // $('#chat_message_'+to_user_id).val('');     // to clear textarea
					var element = $('#chat_message_'+to_user_id).emojioneArea();
					element[0].emojioneArea.setText('');
                    $('#chat_history_'+to_user_id).html(data);      //display the received chat conversation data in the corresponding division tag 
                }
            })
        });

        function fetch_user_chat_history(to_user_id) {
            $.ajax({
                url: "fetch_user_chat_history.php",
                method: "POST",
                data: {to_user_id:to_user_id},
                success: function(data) {
                    $('#chat_history_'+to_user_id).html(data);
                }
            })
        }

        // auto-refresh chat box; the function will called in every interval of each method and display chat data in every open chat box
        function update_chat_history_data() {
            $('.chat_history').each(function() {
                var to_user_id = $(this).data('touserid');
                fetch_user_chat_history(to_user_id);
            });
        }

        $(document).on('click', '.ui-button-icon', function() {
            $('.user_dialog').dialog('destroy').remove();
			$('#is_active_group_chat_window').val('no');
        });

        // execute when cursor is in the textarea field
        $(document).on('focus', '.chat_message', function() {
            var is_type = 'yes';
            $.ajax({
                url: "update_is_type_status.php",
                method: "POST",
                data: {is_type:is_type},
                success: function() {

                }
            })
        });

        // execute when cursor leaves the textarea field
        $(document).on('blur', '.chat_message', function() {
            var is_type = 'no';
            $.ajax({
                url: "update_is_type_status.php",
                method: "POST",
                data: {is_type:is_type},
                success: function() {
                    
                }
            })
        });
		
		$('#group_chat_dialog').dialog({
			autoOpen: false,
			width: 400
		});
		
		$('#group_chat').click(function() {
			$('#group_chat_dialog').dialog('open');			// pop up gcdb on webpage
			$('#is_active_group_chat_window').val('yes');	// change no to yes	
			fetch_group_chat_history();
		});
		
		$('#send_group_chat').click(function() {
			// var chat_message = $('#group_chat_message').val();		// store textarea field value
			var chat_message = $('#group_chat_message').html();		// we're using editable divs instead of textarea
			var action = 'insert_data';			// store insert_data operation
			
			if(chat_message != '') {
				$.ajax({
					url: "group_chat.php",
					method: "POST",
					data: {chat_message:chat_message, action:action},
					success: function(data) {
						// $('#group_chat_message').val('');		// clear group chat textarea
						$('#group_chat_message').html('');
						$('#group_chat_history').html(data);
					}
				})
			}
		});
		
		function fetch_group_chat_history() {
			var group_chat_dialog_active = $('#is_active_group_chat_window').val();
			var action = "fetch_data";
			
			if(group_chat_dialog_active == 'yes') {
				$.ajax({
					url: "group_chat.php",
					method: "POST",
					data: {action:action},
					success: function(data) {
						$('#group_chat_history').html(data);
					}
				})
			}
		}
		
		$('#uploadFile').on('change', function() {
			$('#uploadImage').ajaxSubmit({
				target: "#group_chat_message",			// div where uploaded image will be shown
				resetForm: true					// reset form fields after successful image upload
			});
		});
	});
		
	$(document).on('click', '.remove_chat', function() {
		var chat_message_id = $(this).attr('id');
		if(confirm("Are you sure you want to remove this chat?")) {
			$.ajax({
				url: "remove_chat.php",
				method: "POST",
				data: {chat_message_id:chat_message_id},
				success: function(data) {
					update_chat_history_data();
				}
			})
		}
	});
</script>