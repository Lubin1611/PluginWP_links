function my_action_javascript() {

    jQuery(document).ready(function ($) {

        var data = {
            'action': 'my_action',

        };

        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php

        jQuery.post(ajaxurl, data, function (response) {



            console.log(response);


            var obj = JSON.parse(response);    // Avec JSON.parse, on rend exploitable en js le JSON retourné par notre fonction my_action().


            document.getElementById('texte').innerHTML = "Il y a " + obj.data.poi.total + " resultats dont : " + "<br><br>"


            var table = document.createElement("table");
            var ligne = document.createElement("br");


            var firstrow = document.createElement('tr');
            firstrow.style.color = "lightblue";
            firstrow.style.fontSize = "1.1vw";

            var firstHead = document.createElement('th');
            var firstHeadTxt = document.createTextNode("Intitulé de l'évènement");
            firstHead.appendChild(firstHeadTxt);
            firstrow.appendChild(firstHead);

            var secHead = document.createElement('th');
            var secHeadTxt = document.createTextNode("Adresse");
            secHead.appendChild(secHeadTxt);
            firstrow.appendChild(secHead);

            var thirdHead = document.createElement('th');
            var thirdHeadTxt = document.createTextNode("Lieu");
            thirdHead.appendChild(thirdHeadTxt);
            firstrow.appendChild(thirdHead);

            var fourthHead = document.createElement('th');
            var fourthHeadTxt = document.createTextNode("Date de début");
            fourthHead.appendChild(fourthHeadTxt);
            firstrow.appendChild(fourthHead);

            var fifthHead = document.createElement('th');
            var fifthHeadTxt = document.createTextNode("Heure de début");
            fifthHead.appendChild(fifthHeadTxt);
            firstrow.appendChild(fifthHead);

            var sixthHead = document.createElement('th');
            sixthHead.innerHTML = "date de fin";
            firstrow.appendChild(sixthHead);

            var sevenHead = document.createElement('th');
            var sevenHeadTxt = document.createTextNode("Heure de fin");
            sevenHead.appendChild(sevenHeadTxt);
            firstrow.appendChild(sevenHead);

            var lastHead = document.createElement('th');
            lastHead.style.width = "150px";
            var lastHeadTxt = document.createTextNode("Description");
            lastHead.appendChild(lastHeadTxt);
            firstrow.appendChild(lastHead);


            table.appendChild(firstrow);



            for (var index = 0; index < obj.data.poi.results.length; index++) {

                if ((obj.data.poi.results[index].takesPlaceAt[0].endTime) == null) {

                    obj.data.poi.results[index].takesPlaceAt[0].endTime = "Non renseigné";

                }


                // Ici, je crée en js le reste de mon tableau et je renseigne tous les résultats dans chague colonne
                // grâce a createTextNode.


                tr = document.createElement("tr");
                tr.id = index;


                td1 = document.createElement("td");
                txt1 = document.createTextNode(obj.data.poi.results[index].rdfs_label);
                td1.appendChild(txt1);
                tr.appendChild(td1);


                td2 = document.createElement("td");
                txt2 = document.createTextNode(obj.data.poi.results[index].isLocatedAt[0].schema_address[0].schema_streetAddress);
                td2.appendChild(txt2);
                tr.appendChild(td2);


                td3 = document.createElement("td");
                txt3 = document.createTextNode(obj.data.poi.results[index].isLocatedAt[0].schema_address[0].schema_addressLocality);
                td3.appendChild(txt3);
                tr.appendChild(td3);


                td4 = document.createElement("td");
                td4.appendChild(ligne);

                if (obj.data.poi.results[index].takesPlaceAt[1]) {


                    for (var pas = 0; pas < obj.data.poi.results[index].takesPlaceAt.length; pas++) {


                        var txt4 = document.createTextNode("Date n° " + (pas + 1) + "  -  " + obj.data.poi.results[index].takesPlaceAt[pas].startDate );
                        div = document.createElement("div");
                        div.style.borderBottom = "1px black solid";
                        div.appendChild(txt4);
                        td4.appendChild(div);

                    }

                }  else {

                     txt4 = document.createTextNode(obj.data.poi.results[index].takesPlaceAt[0].startDate);
                     td4.appendChild(txt4);

                }

                tr.appendChild(td4);



                td5 = document.createElement("td");

                if (obj.data.poi.results[index].takesPlaceAt[1]) {


                    for (var pas2 = 0; pas2 < obj.data.poi.results[index].takesPlaceAt.length; pas2++) {

                        var txt5 = document.createTextNode("Heure de début n° " + (pas2 + 1) + " - " + obj.data.poi.results[index].takesPlaceAt[pas2].startTime );
                        div2 = document.createElement("div");
                        div2.style.borderBottom = "1px black solid";
                        div2.appendChild(txt5);
                        td5.appendChild(div2);

                    }

                    } else {

                        txt5 = document.createTextNode(obj.data.poi.results[index].takesPlaceAt[0].startTime);
                        td5.appendChild(txt5);

                    }


                tr.appendChild(td5);


                td6 = document.createElement("td");

                if (obj.data.poi.results[index].takesPlaceAt[1]) {


                    for (var pas3 = 0; pas3 < obj.data.poi.results[index].takesPlaceAt.length; pas3++) {


                        var txt6 = document.createTextNode("Date de fin n° " + (pas3 + 1) + " - " +  obj.data.poi.results[index].takesPlaceAt[pas3].endDate);
                        div3 = document.createElement("div");
                        div3.style.borderBottom = "1px black solid";
                        div3.appendChild(txt6);
                        td6.appendChild(div3);

                    }

                } else {

                    txt6 = document.createTextNode(obj.data.poi.results[index].takesPlaceAt[0].endDate);
                    td6.appendChild(txt6);

                }

                tr.appendChild(td6);


                td7 = document.createElement("td");

                if (obj.data.poi.results[index].takesPlaceAt[1]) {


                    for (var pas4 = 0; pas4 < obj.data.poi.results[index].takesPlaceAt.length; pas4++) {

                        var txt7 = document.createTextNode("Heure de fin n° " + (pas4 + 1) + " - " +  obj.data.poi.results[index].takesPlaceAt[pas4].endTime );
                        div4 = document.createElement("div");
                        div4.style.borderBottom = "1px black solid";
                        div4.appendChild(txt7);
                        td7.appendChild(div4);

                    }

                } else {

                    txt7 = document.createTextNode(obj.data.poi.results[index].takesPlaceAt[0].endTime);
                    td7.appendChild(txt7);

                }

                tr.appendChild(td7);



                td8 = document.createElement("td");
                td8.style.width = "150px";

                txt8 = document.createTextNode(obj.data.poi.results[index].hasDescription[0].dc_description);
                td8.appendChild(txt8);
                tr.appendChild(td8);

                if (index % 2 == 0) {

                    tr.style.backgroundColor = "#e6e6e6";

                }


                table.appendChild(tr);

                document.getElementById('infos_plugin').appendChild(table);

            }

        });

    });

}


window.onload = function() {


    document.getElementById('queryButton').addEventListener('click', my_action_javascript);


};


