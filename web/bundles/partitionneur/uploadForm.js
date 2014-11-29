function uploadForm(choice) {
    var liste = $('#listeeleves').val();
    var cardG = $('#cardgroupes').val();
    $.ajax({
           url : 'jsonpartitionne',
           type : 'POST',
           cache : false,
           dataType : 'json',                                  
           data : {"cardGrp":cardG, "personnes" : liste,"choice" : choice },
           success : function(json, statut) { 
              jsoncallback(json);
              console.log(json);
           }
    });
}

function firstPush() {
    var cardinal = $('#cardgroupes').val();
    var nbEleve = $('#listeeleves').val().split(/\n/).length;


    var blocChoixGroup = $('#choixGroupe');
    if (cardinal <= 0 || cardinal == 1 || cardinal >= nbEleve) {
        alert("Le cardinal doit être un nombre compris entre 1 (exclu) et le nombre total d'élèves (exlu aussi)")
    }
    else if (nbEleve % cardinal == 0) {
        blocChoixGroup.html("<b id=\"msgEqui\">Tous les groupes sont équilibrés !</b>")
        uploadForm();
    }
    else {
        blocChoixGroup.html("<input type='radio' name='choice'\n\
            onChange='uploadForm();' value='maxi' checked='true'>\n\
                Un maximum de groupe au cardinal max<br/>\n\
            <input type='radio' name='choice' \n\
                onChange='uploadForm(\"equilibre\");' \n\
                    value='equilibre'>Un maximum de groupe équilibrés");
        uploadForm();
    }
}
