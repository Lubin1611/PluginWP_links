function my_action_javascript() {

    jQuery(document).ready(function ($) {

        var data = {
            'action': 'my_action',

        };

        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php

        jQuery.post(ajaxurl, data, function (response) {


            console.log(response);


            var obj = JSON.parse(response);  // Avec JSON.parse, on rend exploitable en js le JSON retourné par notre fonction my_action().


                document.getElementById('texte').innerHTML = "Il y a " + obj.data.poi.total + " resultats dont : " + "<br><br>"


                    var obj = JSON.parse(response);

                    for (var t = 0; t < obj.data.poi.results.length; t++) {


                        if (obj.data.poi.results[t].takesPlaceAt[0].endTime = "null") {
                            obj.data.poi.results[t].takesPlaceAt[0].endTime = "heure de fin non définie par le serveur";

                        }


                        // Ici, je crée en js le reste de mon tableau et je renseigne tous les résultats dans chague colonne
                        // grâce a createTextNode.

                        tr = document.createElement("tr");


                        td1 = document.createElement("td");
                        txt1 = document.createTextNode(obj.data.poi.results[t].rdfs_label);
                        td1.appendChild(txt1);
                        tr.appendChild(td1);


                        td2 = document.createElement("td");
                        txt2 = document.createTextNode(obj.data.poi.results[t].isLocatedAt[0].schema_address[0].schema_streetAddress);
                        td2.appendChild(txt2);
                        tr.appendChild(td2);


                        td3 = document.createElement("td");
                        txt3 = document.createTextNode(obj.data.poi.results[t].isLocatedAt[0].schema_address[0].schema_addressLocality);
                        td3.appendChild(txt3);
                        tr.appendChild(td3);


                        td4 = document.createElement("td");
                        txt4 = document.createTextNode(obj.data.poi.results[t].takesPlaceAt[0].startDate);
                        td4.appendChild(txt4);
                        tr.appendChild(td4);


                        td5 = document.createElement("td");
                        txt5 = document.createTextNode(obj.data.poi.results[t].takesPlaceAt[0].startTime);
                        td5.appendChild(txt5);
                        tr.appendChild(td5);


                        td6 = document.createElement("td");
                        txt6 = document.createTextNode(obj.data.poi.results[t].takesPlaceAt[0].endDate);
                        td6.appendChild(txt6);
                        tr.appendChild(td6);


                        td7 = document.createElement("td");
                        txt7 = document.createTextNode(obj.data.poi.results[t].takesPlaceAt[0].endTime);
                        td7.appendChild(txt7);
                        tr.appendChild(td7);
                        document.getElementById('planning').appendChild(tr);


                    }

            });


        });
    }






window.onload = function() {


    document.getElementById('test').addEventListener('click', my_action_javascript);


};