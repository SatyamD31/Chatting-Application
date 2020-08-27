$("#signup").click(function() {
    $(".message").css("transform", "translateX(100%)");
    if ($(".message").hasClass("login")) {
        $(".message").removeClass("login");
    }
    $(".message").addClass("signup");
});
  
$("#login").click(function() {
    $(".message").css("transform", "translateX(0)");
    if ($(".message").hasClass("login")) {
        $(".message").removeClass("signup");
    }
    $(".message").addClass("login");
});

// $('#submit').click(function() {
//     // event.preventDefault();
//     // var username = $(".username").val();
//     // var password = $(".password").val();
//     $.ajax({
//         url: 'form.php',
//         type: 'POST',
//         data: {
//             username: username,
//             password: password
//         },
//         success: function(data) {

//         }
//     });
// });


// $(document).ready(function() {
//     $("#form").submit(function(e) {                         //.on('click', function(){})
//         // e.preventDefault();
//         var name = $("#name").val();
//         var pass = $("#pass").val();
//         // var contact = $("#contact").val();
//         // var gender = $("input[type=radio]:checked").val();
//         // var msg = $("#msg").val();
//         if (name == '' || pass == '' || contact == '' || gender == '' || msg == '') {
//             $.post("form.php", {
//                 name1: name,
//                 pass1: pass,
//             }, function(e) {
//                     e.preventDefault();
//                     e.stopPropagation();
//                     return false;
//             })
//         //     alert("Insertion Failed Some Fields are Blank....!!");
//         } else {
//             // Returns successful data submission message when the entered information is stored in database.
//             $.post("form.php", {
//                 name1: name,
//                 pass1: pass,
//                 // contact1: contact,
//                 // gender1: gender,
//                 // msg1: msg
//             }, function() {
//                     // alert(data);
//                     // e.preventDefault();
//                     // e.stopPropagation();
//                     // e.stopImmediatePropagation();
//                     $('#form')[0].reset(); // To reset form fields
//             });
//         }
//     });
//     event.preventDefault();
// });