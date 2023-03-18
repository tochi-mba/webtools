document.addEventListener("DOMContentLoaded", function(){
    // Get the form
    var form = document.getElementById("registerForm");
    
    // Get the inputs
    var username = document.getElementById("username");
    var firstname = document.getElementById("firstname");
    var lastname = document.getElementById("lastname");
    var password = document.getElementById("password");
    
    // Add event listener
    form.addEventListener("submit", function(e){
      // Check if inputs are empty
      if(username.value == "" || firstname.value == "" || lastname.value == "" || password.value == ""){
        alert("Please fill in all fields");
        e.preventDefault();
      }
    });
  });