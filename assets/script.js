console.log("Script is go!");

var loadingMessages = false;

//Varastoidaan tieto palvelimista ja "niiltä ladatuista tiedoista".
var serverData = {};
var currentServer = 0;
var currentChannel = 0;

//Luodaan kaikki elementit sivullaalkukäyttöä varten.
function setup() {

    updateServers()
    updateMessages(currentServer);

}

function updateServers() {
	//Haetaan data kaikista palvelimista.
    fetch('getData.php?request=servers')
        .then((response)=>response.json())
        .then((responseData)=>{
            serverData = responseData;
            console.log(serverData);

            var temp_addServer = `
                <div class="col-md-12 server-button" id="create-server" data-toggle="tooltip" title="Luo uusi kanava">
                    <img src="http://via.placeholder.com/350x350?text=NEW" class="img-fluid mx-auto d-block">
                </div>`;

            $("#server-list").html(temp_addServer);




			for(const [key,server] of Object.entries(serverData['servers'])) {
				console.log(key,server);

				console.log(server['icon']);
				$("#server-list").prepend(createServer(key,server['name'],server['icon']));
			}
            

            //Käynnistetään bootstrapin tooltipit. Tehdään se tässä koska "pavelimissa" on hover tekstit.
            $('[data-toggle="tooltip"]').tooltip();   
    });



}

//Heittää virheen jos serverillä ei ole yhtään viestiä.
function updateMessages(id) {
    fetch('getData.php?request=messages&serverID='+id)
        .then((response)=>response.json())
        .then((responseData)=>{
            messagesData = responseData;

            //Alempana oleva for of looppi ei toimi jollei sille ole annettu dictionaryä.
            //Katsotaan tässä onko se olemassa ja jos ei niin alustetaan tarvittu dictionary.
            if ("messages" in serverData['servers'][currentServer]) {} else {
                console.log("No key found preparing dict.");
                serverData['servers'][currentServer].messages = {};
            }


            if (messagesData['messages'] != null) {
                for(const [key,message] of Object.entries(messagesData['messages'])) {


                    //En saa tätä toimimaan niin kuin haluan. Dictionaryt eiv't ole hirveän käyttäjä ystävällisä.
                    if (key in serverData['servers'][currentServer].messages) {} else {
                        console.log(key);
                        $("#chat-messages").append(createMessage(message['message'],message['userdata']['username']));
                    }

                    
                }

                serverData['servers'][currentServer].messages = messagesData;

            } else {
                console.log("Palvelimella ei ole viestejä");
            }


            

    });

    return true;

    
}

function createServer(id,name,icon) {
	//console.log(serverData[id]['icon']);
    return`
        <div class="col-md-12 server-button" id="server-trigger" data-id="${id}" data-name="${name}" data-toggle="tooltip" title="${id} : ${name}">
            <img src="${icon}" class="img-fluid mx-auto d-block">
        </div>
    `;
}

function createMessage(message,username,avatar="https://via.placeholder.com/350x350") {
    return `
        <div class="col-md-12 message">
            <div class="row">
                <div class="col-md-1">
                    <img src="${avatar}" class="img-fluid mx-auto d-block">
                </div>

                <div class="col-md-11">
                    <div class="row">
                        <div class="col-md-12">
                            <span>${username}</span>
                        </div>

                        <div class="col-md-12">
                            <span class="message-text">${message}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
}

function registerServer() {
    var postdata = {
        request: "createServer",
        name: $("#reg-name").val(),
        avatar: $("#reg-url").val()
    }

    $.ajax({
        type: "POST", 
        url : "getData.php",
        data: postdata

    }).done(function(data)  {

        updateServers()
        
    }).fail(function()  {
        alert("Palvelimen luominen epäonnistui!");
    });    
}




//Initialize the script.
$(document).ready(function(){
    var chatArea = document.getElementById("chat-messages");
    if (chatArea) {
        chatArea.scrollTop = chatArea.scrollHeight;
        
        
        
        //Valmistellaan sivu ensikäyttöä varten.
        setup();
        

        window.setInterval(function(){

            //Siivotaan chatti ja päivitetään viestit.
            $("#chat-messages").html("");
            updateMessages(currentServer);
        }, 5000);

        
        //Jos käyttäjä on rullannut kanavan yläosaan lähetetään pyyntö saada uudet viestit.
        document.getElementById("chat-messages").addEventListener("scroll",function(){
            
            //Kun ladataan uusia viestejä näytetään Loading mewssages teksti.
            var temp = `
			<div class="col-md-12 message-clean" id="loading-messages">
                <p style="text-align:center">Loading new messages...</p>
			</div>
            `;
            
            //Jos on scrollattu viestialueen yläosaan ja viestejä ei jo latadata.
            if (this.scrollTop === 0 && loadingMessages == false) {
                
                $(this).prepend(temp);
                loadingMessages = true;
                
                if (updateMessages(currentServer)) {
                    loadingMessages = false;
                    document.getElementById("loading-messages").remove();
                };
            }
        });
        
        document.getElementById("message-input").addEventListener('keyup', ({key}) => {
            console.log(key);
            if (key == "Enter" && $("#message-input").val() != "") {
                console.log("Enter was pressed.");

                var postdata = {
                    request: "createMessage",
                    message: $("#message-input").val(),
                    serverID: currentServer
                }
        
                $.ajax({
                    type: "POST", 
                    url : "getData.php",
                    data: postdata

                }).done(function(data)  {

                    $("#chat-messages").append(createMessage($("#message-input").val(),$("#hidden_username").val()));
                    $("#message-input").val("");
                    
                }).fail(function()  {
                    alert("Viestin lähettäminen epäonnistui!");
                }); 

                //$("#chat-messages").animate({scrollTop: $("#chat-messages").offset().top}, 1000);
            }
        });
        
        $(document).on('click','#server-trigger',function(){
            $("#chat-messages").text("");
            var id = $(this).data()['id'];
            var name = $(this).data()['name'];
            $("#nav-info").text(name);
            updateMessages(id);
            currentServer = id;
        });
        
        $(document).on('click','#create-server',function(){
            $('#custom-modal').toggle();
        });

        $(document).on('click','#close-modal',function(){
            $('#custom-modal').toggle();
        });
    }
}); 
    