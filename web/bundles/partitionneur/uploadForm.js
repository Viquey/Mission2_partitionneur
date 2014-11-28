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
