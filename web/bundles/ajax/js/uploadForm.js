function uploadForm() {
    var liste = $('#listeeleves').val();
    var cardG = $('#cardgroupes').val();
    $.ajax({
           url : 'jsonpartitionne',
           type : 'POST',
           cache : false,
           dataType : 'json',                                  
           data : {"cardGrp":cardG, "personnes" : liste },
           success : function(json, statut) { 
              jsoncallback(json);
              console.log(json);
           }
    });
} 


