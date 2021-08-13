<div class="row">
    <div class="col-md-12">
        <div class="login-box">

            <div class="row">
                <div class="col-md-12 alert alert-info" id="login-alert" style="display: none;">

                </div>
    
                <div class="col-md-12">
                    <input type="username" placeholder="Username" class="form-control" id="username" value="cmdtvt">
                </div>
    
                <div class="col-md-12">
                    <input type="password" placeholder="Password" class="form-control" id="password" value="heartbreaker">
                </div>
    
                <div class="col-12 col-sm-12 col-md-4">
                    <button id="register-button" class="btn btn-primary btn-full">Register</button>
                </div>
    
                <div class="offset-md-4 col-12 col-sm-12 col-md-4">
                    <button type="submit" id="login-button" class="btn btn-success btn-full">Login</button>
                </div>
            </div>


        </div>
    </div>
</div>





<script>
    //Sisään kirjautumis sivun tarvitsemat koodit.



    function checkLogin() {
        
        //Haetaam inputeista käyttäjänimi ja salasana sitten lähetetään ne POSTilla varmistettaviksi.
        var data = {
            request: "login",
            username: $('#username').val(),
            password: $('#password').val()
        }

        $.ajax({
            type: "POST", 
            url : "getData.php",
            data: data
        }).done(function(data)  {

            if (data.loginValid=="true") {
                window.location.href = "index.php?page=chat";
            } else {
                $('#login-alert').html("<span>Wrong username or password</span>");
                $('#login-alert').show();
            }
            
        }).fail(function()  {
            alert("Yhteyttä ei pystytty muodostamaan!");
        }); 
    }


    function register() {
        var data = {
            request: "register",
            username: $('#username').val(),
            password: $('#password').val()
        }

        $.ajax({
            type: "POST", 
            url : "getData.php",
            data: data
        }).done(function(data)  {

            if (data.registerValid=="true") {
                window.location.href = "index.php?page=chat";
            } else {
                $('#login-alert').html("<span>Käyttäjänimi on jo viety</span>");
                $('#login-alert').show();
            }
            
        }).fail(function()  {
            alert("Yhteyttä ei pystytty muodostamaan!");
        }); 
    }


    //Jos enter painetaan pyritään kirjautumaan sisään.
    document.addEventListener('keyup', ({key}) => {
        if (key == "Enter") {checkLogin();}
    });



    $(document).ready(function(){
        $('#login-button').click(function(){
            console.log("click");
            checkLogin($('#username').val(),$('#password').val())
        });

        $('#register-button').click(function(){
            console.log("clickRegister");
            register($('#username').val(),$('#password').val())
        });


    });
</script>
