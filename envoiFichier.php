<?php
/**
 * Created by PhpStorm.
 * User: stagiaire
 * Date: 2019-03-14
 * Time: 14:09
 */


$fichier = $_FILES['avatar']['tmp_name'];


$cmd = "curl -X POST -H 'Content-Type:application/rdf+xml' --data-binary '@$fichier' http://localhost:9999/blazegraph/namespace/kb/sparql";
exec($cmd,$result);



echo "Le fichier a bien été envoyé a la base de données";



