<?php
/**
 * Created by PhpStorm.
 * User: stagiaire
 * Date: 2019-03-15
 * Time: 16:17
 */


$cmd = "curl http://localhost:9999/blazegraph/namespace/kb/sparql  --data-urlencode 'update=DROP ALL'";
exec($cmd,$result);



echo "la base de données a été vidée avec succès";
