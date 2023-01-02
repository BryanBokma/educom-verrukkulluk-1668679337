<?php
//// Allereerst zorgen dat de "Autoloader" uit vendor opgenomen wordt:
require_once("./vendor/autoload.php");

/// Twig koppelen:
$loader = new \Twig\Loader\FilesystemLoader("./templates");
/// VOOR PRODUCTIE:
/// $twig = new \Twig\Environment($loader), ["cache" => "./cache/cc"]);

/// VOOR DEVELOPMENT:
$twig = new \Twig\Environment($loader, ["debug" => true ]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

/******************************/

/// Next step, iets met je data doen. Ophalen of zo
require_once("lib/database.php");
require_once("lib/artikel.php");
require_once("lib/user.php");
require_once("lib/keuken_type.php");
require_once("lib/ingredient.php");
require_once("lib/gerecht-info.php");
require_once("lib/gerecht.php");
require_once("lib/boodschappen.php");
require_once("lib/zoekfunctie.php");

$db = new database();

$gerecht_info = new gerecht_info($db->getConnection());
$gerecht = new gerecht($db->getConnection());
$boodschappen = new boodschappen($db->getConnection());
$zoekfunctie = new zoekfunctie($db->getConnection());

$data = $gerecht->selecteerGerecht();



/*
URL:
http://localhost/index.php?gerecht_id=4&action=detail
*/

$gerecht_id = isset($_GET["gerecht_id"]) ? $_GET["gerecht_id"] : "";
$action = isset($_GET["action"]) ? $_GET["action"] : "homepage";
$rating = isset($_GET["rating"]) ? $_GET["rating"] : [];
$user_id = 1;
$zoeken = isset($_GET['zoeken']) ? $_GET["zoeken"] : NULL; //input text veld main ophalen
$totaalprijs = $boodschappen->totaalPrijsBoodschappen($user_id);

switch($action) {

        case "homepage": {
            $data = $gerecht->selecteerGerecht();
            $template = 'homepage.html.twig';
            $title = "homepage";
            break;
        }

        case "detail": {
            $data = $gerecht->selecteerGerecht($gerecht_id);
            $template = 'detail.html.twig';
            $title = "detail pagina";
            break;
        }

        case "addWaardering": {
            $addWaardering = $gerecht_info->addWaardering($gerecht_id, $rating); 
            break;
        }

        case "berekenGemiddelde": {
            $data = $gerecht_info->berekenGemiddelde($gerecht_id);
            $template = 'detail.html.twig';
            $title = "gemiddelde";
            break;
        }

        case "boodschappenlijst": {
            $data = $boodschappen->ophalenBoodschappen($user_id);
            $template = "boodschappen.html.twig";
            $title = "boodschappenlijst";
            break;
        }

        case "boodschappen_toevoegen": {
            $data = $boodschappen->boodschappenToevoegen($gerecht_id, $user_id);
            $template = "boodschappen.html.twig";
            $title = "boodschappen";
            break;
        }

        case "zoekfunctie": {
            $zoekfunctie = $zoekfunctie->zoekFunctie($zoeken);
            $template = "zoekfunctie.html.twig";
            $title = "detail pagina";
            break;
        }

        /// etc

}

if ($zoeken != NULL) {
    $zoekfunctie = $zoekfunctie->zoekFunctie($zoeken);
    $template = "zoekfunctie.html.twig";
    $title = "zoek functie pagina";
} // end if


/// Onderstaande code schrijf je idealiter in een layout klasse of iets dergelijks
/// Juiste template laden, in dit geval "homepage"
$template = $twig->load($template);


/// En tonen die handel!
echo $template->render(["title" => $title, "data" => $data, "totaalprijs" => $totaalprijs, "zoekfunctie" => $zoekfunctie]);