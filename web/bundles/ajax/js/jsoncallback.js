function jsoncallback(objetJS) {
  // alert("Nombre ds le premier groupe = " + objetJS.groupes.length);
  $("#res").html("");
  for (var i = 0; i < objetJS.groupes.length; i++ ) {
    // http://www.w3schools.com/jquery/jquery_dom_add.asp
    var div = document.createElement("div");
    var ul  = document.createElement("ul");

    // classes bootstrap twitter
    div.setAttribute("class", "col-sm-4");
    var div1 = document.createElement("div");
    div1.setAttribute("class", "panel panel-info");
    var div2 = document.createElement("div");
    div2.setAttribute("class", "panel-heading");
    var title = document.createElement("h3");
    title.setAttribute("class", "panel-title");
    // nomme le groupe à partir de "A" dont le code ascii est 65
    title.innerHTML=" Groupe <span class='badge '>"+ (i+1) +"</span>";
    var div3 = document.createElement("div");
    div3.setAttribute("class", "panel-body");
    
    for (var j = 0; j < objetJS.groupes[i].length; j++) {
      var li = document.createElement("li");
      li.innerHTML = objetJS.groupes[i][j].nom;
      ul.appendChild(li);   
    }

    div3.appendChild(ul);
    div1.appendChild(div2);
    div2.appendChild(title);
    div1.appendChild(div3);
    div.appendChild(div1);	     
    
    //div.appendChild(ul);
    $("#res").append(div);
  }
  
}

