<div class="row custom-modal" id="custom-modal" style="display: none;">
    <div class="offset-md-4 col-md-4 content">
        <div class="row">
            <div class="col-md-12">
                <span id="close-modal">X</span>
            </div>
            <div class="col-md-12">
                <h4>Luo uusi palvelin</h4>
                <hr>
            </div>

            <div class="col-md-12">
                <input type="text" class="form-control" placeholder="Nimi" id="reg-name">
                <input type="text" class="form-control" placeholder="Server icon url" id="reg-url">
                <button type="submit" class="btn btn-success" onclick="registerServer()">Luo</button>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-1 server-list hide-scrollbar">
        <div class="row" id="server-list">
            





        </div>

    </div>

    <div class="col-md-10">
        <div class="row">
            <div class="col-md-12 chat-messages hide-scrollbar" id="chat-messages">
                    <!--

                    <div class="col-md-12 message">
                        <div class="row">
                            <div class="col-md-1">
                                <img src="https://via.placeholder.com/350x350" class="img-fluid mx-auto d-block">
                            </div>

                            <div class="col-md-11">
                                <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis et quos exercitationem aspernatur ullam! Velit, unde architecto impedit vitae necessitatibus quae voluptates et libero voluptatibus! Sit porro illo tempore accusamus.</span>
                            </div>
                        </div>
                    </div>


                    -->
            </div>

            <div class="col-md-12 chat-input">
                <input type="text" placeholder="Message" class="form-control" id="message-input">
            </div>
        </div>
    </div>

    
</div>