<?php
/* Plugin name: Plugin Links
Plugin uri: localhost
Description: Plugin crée pour l'agence LINKS de laon
Version: 1.0
Author: Lubin
*/

register_activation_hook( FILE , maFonction);


// Ici, je commence a creer ma fonction pour afficher un menu wordpress.


add_action('admin_menu','test_plugin_setup_menu');


function test_plugin_setup_menu () {

    add_menu_page('Test Plugin Page', 'Plugin Links', 'manage_options', 'test-plugin', 'page_accueil' );
    add_submenu_page('test-plugin', 'Charger un fichier',
        'Charger un fichier', 'manage_options', 'test-fichier','chargement_fichier');

}


// Puis, je link ma page CSS.


add_action('admin_enqueue_scripts', 'my_styles');

function my_styles() {

    wp_register_style( 'custom_wp_admin_css', plugins_url('/Links_Plugin/css/style.css'));
    wp_enqueue_style( 'custom_wp_admin_css' );

}


// La fonction chargement_fichier représente la page du plugin qui est censée uploader un fichier RDF-XML vers la base de données blazegraph,
// et elle correspond a la fonction que l'on a déclarée dans add_menu_page.
// La page est toujours en cours de developpement.


function chargement_fichier() {

?>

    <div id ='wrap'>

    <h1 id = 'chargerPage'>Pour stocker vos infos dans une base de données, veuillez appuyer sur le bouton charger</h1>




    <form action="" method ="post">

        <label>Appuyer sur le bouton pour commencer : </label><input type="submit" name="submit" value="Importer">
    </form>

    </div>

<?php

}



// Ma fonction page_accueil est la première page de mon plugin. C'est ici que l'utilisateur peut avoir ses résultats.



function page_accueil() {

   ?>


<div id = 'wrap'>


<h1 id = titrePlugin >Bienvenue sur le plugin de Links !</h1>


<h3>Ici vous trouverez toutes les infos concernant les Evènements sur DataTourisme</h3>


    <p>D'ici vous allez pouvoir charger les fichiers contenus dans la base de données Blazegraph/ PhpMyadmin au besoin. Ces données
    seront stockées de manière a ce que vous y ayez accès en permanence.</p>

    <label>Cliquez sur le bouton</label>&nbsp;<input type="button" value="Interroger" id = "test">
    <br><br>

    <div id ="texte">


    </div>

    <div id = infos_plugin>

        <table id="planning" border="0">
            <tr>
                <th>Intitulé du spectacle</th>
                <th>Adresse</th>
                <th>Commune</th>
                <th>Date de début</th>
                <th>Heure de début</th>
                <th>Date de fin</th>
                <th>Heure de fin</th>
            </tr>
        </table>


    </div>


    <p>DATATOURISME Powered. 2019</p>

</div>
<?php

}


// Et enfin, le link de mon javascript.



add_action('admin_enqueue_scripts', 'my_scripts'); // add scripts to dashboard head

function my_scripts() {

    wp_enqueue_script('jquery');
    wp_register_script('my_script', plugins_url('../Links_Plugin/js/dynamic.js', __FILE__));
    wp_enqueue_script('my_script');

}



/***********************************************************************************************************************
 ***********************************************************************************************************************
 *                                                                                                                     *
 *      Une fois nos pages de plugin créees, il reste a utiliser l'API pour interroger les données sur le serveur      *
 *      Blazegraph. Ci-dessous, la fonction my_action() est la fonction php qui va exploiter l'api, notamment en       *
 *      appelant la méthode create de la classe DatatourismeApi. Cette methode va instancier le client pour avoir      *
 *      accès aux données de blazegraph. Par la suite, on utilise des requêtes de type graphQL pour récupérer          *
 *      les infos auprès de la base de données.                                                                        *
 *                                                                                                                     *
 *                                                                                                                     *
 ***********************************************************************************************************************/


add_action( 'wp_ajax_my_action', 'my_action' );

function my_action()
{


    //define('SERVER', 'sparql'); # switch resolver to pure sparql

    header('Access-Control-Allow-Credentials: true', true);
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Content-Type');

    $payload = null;

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            if (isset($_SERVER['CONTENT_TYPE']) && 'application/json' === $_SERVER['CONTENT_TYPE']) {
                $rawBody = file_get_contents('php://input');
                $requestData = json_decode($rawBody ?: '', true);
            } else {
                $requestData = $_POST;
            }
            break;
        case 'GET':
            $requestData = $_GET;
            break;
        default:
            exit;
    }

    $payload = isset($requestData['query']) ? $requestData['query'] : null;


// composer autoload
    require __DIR__ . '/vendor/autoload.php';

// instanciation du client

    $api = \Datatourisme\Api\DatatourismeApi::create('http://localhost:9999/blazegraph/namespace/kb/sparql');

// éxecution d'une requête

    $result = $api->process('{
    poi (

     size: 100,          # <- Limite le nombre de résultats par page
     from: 0,
     
      sort:[
            { takesPlaceAt : {startDate : { order: desc } } }  # <- Tri des évenements par date de début
        ]

    )
    {
    total
    results {
    rdfs_label
    lastUpdate
     isLocatedAt {
      schema_address {
      schema_streetAddress
      cedex
      schema_addressLocality
                }
            }
      takesPlaceAt {
      startDate
      startTime
      endDate
      endTime
      }
    }
  }

}');


// prévisualisation des résultats
// Le résultat retourné sera du JSON que l'on exploite grâce a une fonction js a la page dynamic.js

    echo json_encode($result);

    wp_die();

    // this is required to terminate immediately and return a proper response


}


