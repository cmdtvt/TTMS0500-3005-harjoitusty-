<span class="welcome-text">Topin Chatti</span>

<style>
    * {
        color: #ffffff;
    }
</style>

<div class="row" style="margin-top: 20vh;">
    <div class="offset-md-3 col-md-6">
        <p>
            
            <h4>Projekti</h4>
            Projektin ideana oli kehittää yksinkertainen chattiohjelma. Otin chattipalvelu Discordista jonkin verran mallia sillä tykkään miten heidän sivu ja ohjelmat on rakennettu.

            <br><br>

            Halusin saada sivustolle Kirjautumisen, chattaamisen sekä jonkinlaisen hyvän järjestelmän sivujen lataamiseen luotua.

            <br><br>
            <h4>Toteutus</h4>

            Halusin rakentaa ohjelman siten että pystyisin käyttämään Ajaxia helposti tiedon lisäämiseen sekä hakemiseen tietokannasta. Tämän takia tein tiedoston nimeltään <code>getData.php</code> Tämä ohjelma ottaa vastaan GET ja POST pyyntöjä ja tekee sitten tarvitut tietokanta tapahtumat.
            
            <br><br>

            Tämä idea oli hyvä sillä minulla oli yksi paikka josta pääsin käsiksi tietokantaan Ajaxilla. Kehityksen kohteena olisi että koko systeemi vaihdettaisiin käyttämään pelkkiä POST methodeja. Nyt <code>getData.php</code> tukee GET ja POST methodeja ja mielestäni se on hieman epäselvä ja ärsyttävä kehittää. Saman pystyisi tekemään juuri pelkillä POST pyynnöillä joka tekisi Javascript koodistakin helpompaa.<br><br>Testasin <code>getData.php</code> tiedoston testaamiseen ohjelmaa nimeltään <a href="https://www.postman.com/" target="_blank">postman</a>. Tämä ohjelma helpotti huomattavasti ohjelman testausta ja aion käyttää sitä myös tulevaisuudessa.

            <br><br><br>

            Kun sivustolla on nyt niin sanottu API ideanani oli saada sivuston chatti osiosta sellainen että se automaattisesti päivittäisi itsensä APIn kautta. Tämä onnistui ihan hyvin. Kirjautuminen ja rekisteröityminenkin odottaa varmistus viestiä APIsta että homma onnistui ennekuin käyttäjä uudelleen ohjataan. Myös virheviestit näytetään käyttäjille jos haluttu asia epäonnistui jostain syystä.<br><br>

            Pyrin rakentamaan <code>index.php</code> tiedoston sitten että GET muuttujaa muuttamalla pääset eri sivulle. Tein tämän sen takia että phpssä includetettujen tiedostojen polku ei hajoa niin helposti jos niitä kutsutaan eri paikoista. Tämä mahdollistaa myös sen että jos sivusto halutaan tulevaisuudessa muuttaa käyttämään URL overrideja niin se onnistuu huomattavasti helpommin.<br><br>


            <h5>Ongelmia</h5>
            Asioita jossa tuli ongelmia vastaan.<br>
            chat sivun automaattisen päivitys refreshaa koko contentin joka on turhaa. Tähän reacti olisi esimerkiksi auttanut kovasti.<br><br>
            Salasanat eivät ole tietokannassa hashattyinä. Tämä olisi varmasti helppo korjaus mutta yksinkertaisesti unohdin sen ja nyt ei ole enään aikaa jäljellä.

            <br><br>
            <h4>Tietokanta</h4>
            Käytin PHPssä PDO kirjastoa tietokannan kanssa komunikoinnissa koska se on mukavan helppo käyttää.<br>
            Käytin tietokantana MariaDBtä ja toteutin tietokannan muokkaamisen HeidiSQL ohjelmalla. Tietokanta koostuu kolmesta eri pöydästä. users, servers, messages. Users taulu sisältää käyttäjädatan eli käyttäjänimet salasanat jne.. Servers pöytä sisältää tiedot luoduista chatti palvelimista. Servers pöytään on linkitetty messages pöytä jossa on chattiserverin kaikki viestit.

            <img src="assets/database.png" height="550px" style="background-color: #d6d3d3;">

            <br><br>
            <h4>Tiedostorakenne</h4>

            <img src="assets/rakenne.PNG" height="550px">
            <br><br>

            <h5>Tiedostojen selityksiä</h5>
            <code>settings.php</code>: Sisältää asetuksia esimerkiksi tietokannan salasanat ja kehityksessä käytetty muuttuja jolla debug infoa sai näkyviin.<br>
            <code>db.php</code>: Sisältää luokan joka hoitaa tietokanta yhteyden ja eri tietokantaan liittyvät tehtävät.<br>
            <code>script.js</code>: Sisältää lähes kaiken Javascriptin jota sivusto käyttää

            <br>
            <code>login.php</code>: sivu sisältää kirjautumiseen tarvittavaa Javascriptiä. Kyseisen koodin pitäminen tällä sivulla tuntui järkevämmältä niin jätin sen sinne.<br>

            <code>testdata/</code>: kansio sisältää json tiedostoja jotka ovat esimerkit minkälaisena datan pitäisi tulla <code>getData.php</code> tiedostosta.
            
            <br><br>
            <h4>Itsearvio</h4>

            Olen tyytyväinen projektiin. MONIA asioita olisi voinut tehdä erilailla varsinkin niin sanotun APIn puolella, mutta opin täsät oikeasti paljon. Jos tätä ohjelmaa haluaisi jatkaa eteenpäin ehdottaisin vahvasti reactin käyttöä chatti osuudessa ja Javascripti koodin isompaa luokitusta. Annan tälle omasta mielestäni arvosanaksi 7/10 koska tämä on harjoitustyö.

            <br><br>
            <h4>Projektin jälkeen</h4>
            Projektia tehdessä minulla tuli mieleen että voisin kehittää PHP tai Python ohjelman joka osaisi luoda tälläisiä sivuja varten perusrakennetta. Tämä olisi nopeuttanut tekemistä huomattavasti sillä jokaista tietokannan pöytää kohden pitää melkein tehdä <code>INSERT UPDATE</code> ja <code>DELETE</code> lausekkeet. Jonkin lainen ohjelma joka loisi nämä automaattisesti ja tekisi jonkin <code>getData.php</code> kaltaisen tiedoston voisi nopeuttaa sivujen tekemistä tulevaisuudessa huomattavasti.




        </p>
    </div>
</div>