<?php
/* Plugin name: Plugin Links
Plugin uri: localhost
Description: Plugin crée pour l'agence LINKS de laon
Version: 1.0
Author: Lubin
*/

register_activation_hook( FILE , maFonction);


// Ici, je commence a creer ma fonction pour afficher un menu wordpress.


add_action('admin_menu','Links_laon_menu');


function Links_laon_menu () {

    add_menu_page('Test Plugin Page', 'Plugin Links', 'manage_options', 'links_laon_aisne', 'page_accueil' );
    add_submenu_page('links_laon_aisne', 'Charger un fichier',
        'Charger un fichier', 'manage_options', 'test-fichier','chargement_fichier');
    add_submenu_page("links_laon_aisne", 'Vider la base de données', 'Vider la base de données', 'manage_options', 'other_page'
    , "vider_base");

}


// Puis, je link ma page CSS.


add_action('admin_enqueue_scripts', 'my_styles');

function my_styles() {

    $current_screen = get_current_screen();

    if ( strpos($current_screen->base, 'links_laon_aisne') === false) {

        return;

    }  else {
        wp_register_style('custom_wp_admin_css', plugins_url('/Links_Plugin/css/style.css'));
        wp_enqueue_style('custom_wp_admin_css');
    }
}


// La fonction chargement_fichier représente la page du plugin qui est censée uploader un fichier RDF-XML vers la base de données blazegraph,
// et elle correspond a la fonction que l'on a déclarée dans add_menu_page.


function chargement_fichier() {

?>

    <div id ='wrap'>

        <h1 id = 'chargerPage'>Pour stocker vos infos dans une base de données, veuillez appuyer sur le bouton charger</h1>


        <form method="POST" action="<?php echo plugin_dir_url(__FILE__ ); ?>envoiFichier.php" enctype="multipart/form-data">
            Fichier : <input type="file" name="avatar">
            <input type="submit" name="envoyer" value="Envoyer le fichier" id = "testEnvoi">
        </form>


    </div>

<?php

}


function vider_base() {

    ?>


    <h3>Pour vider la base de données blazegraph : </h3>

    <form method="POST" action="<?php echo plugin_dir_url(__FILE__ ); ?>viderBase.php">
        <label>Cliquez sur le bouton : </label><input type="submit" value="Vider">
    </form>
    <br><br>



    <?php
}

// Ma fonction page_accueil est la première page de mon plugin. C'est ici que l'utilisateur peut avoir ses résultats.


function page_accueil() {

   ?>


<div id = 'wrap'>


<h1 id = titrePlugin >Bienvenue sur la page d'accueil du plugin de Links !</h1>


<h3>Ici vous trouverez toutes les infos concernant les Evènements sur DataTourisme</h3>

    <div id = 'description_plugin_links'>

        <p>D'ici vous allez pouvoir interroger les fichiers contenus dans la base de données Blazegraph.</p>
        <p>Pour envoyer un fichier a la base de données, il faut se rendre au menu 'Charger un fichier'.
        Les fichiers a utiliser peuvent être de format RDF-XML, Turtle, ou NT, et sont compatibles avec la base de données blazegraph. </p>

        <p>Une fois les informations recueillies, et que vous voulez interroger un autre fichier, il est préférable de vider la base de
        données dans un premier temps, car les informations se cumulent et il devient difficile de lire les informations récoltées.</p>

        <p>Si un fichier a déja été chargé, vous pouvez commencer a lire les informations en cliquant sur le bouton ci-dessous :</p>

        <input type="button" value="Interroger" id = "queryButton">


    </div>

    <div id ="texte">

    </div>

    <div id = infos_plugin>

    </div>


    <p>DATATOURISME Powered. 2019</p>

</div>
<?php

}


// Et enfin, le link de mon javascript.


add_action('admin_enqueue_scripts', 'my_scripts'); // add scripts to dashboard head

function my_scripts() {

    $current_screen = get_current_screen();

    if ( strpos($current_screen->base, 'links_laon_aisne') === false) {

        return;

    }  else {

        wp_enqueue_script('jquery');
        wp_register_script('my_script', plugins_url('../Links_Plugin/js/dynamic.js', __FILE__));
        wp_enqueue_script('my_script');

    }
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
            { takesPlaceAt : { startDate : { order: desc } } }  # <- Tri des évenements par date de début
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


