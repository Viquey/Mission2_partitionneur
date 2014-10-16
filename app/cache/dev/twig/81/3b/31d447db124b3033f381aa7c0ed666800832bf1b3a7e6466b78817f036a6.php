<?php

/* OrgPartitioneurBundle:Default:partitionneur.html.twig */
class __TwigTemplate_813b31d447db124b3033f381aa7c0ed666800832bf1b3a7e6466b78817f036a6 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("::layout.html.twig");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
            'ajout' => array($this, 'block_ajout'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        echo twig_escape_filter($this->env, ($this->renderParentBlock("title", $context, $blocks) . "Page de test"), "html", null, true);
    }

    // line 7
    public function block_content($context, array $blocks = array())
    {
        // line 8
        echo "    
    
    
    <div class=\"row\">
        
        <div class=\"col-md-5\">
            <div class=\"form-group\">
                <label>Intitulé du devoir</label> <input class=\"form-control\" />
            </div>
            <div class=\"form-group\">        
                <label> Card max des groupes <input class=\"form-control\" type=\"text\" id='cardgroupes' value=\"3\"/>
                </label>     
            </div>

            <div class=\"form-group\">
                <label>Fichier des élèves (csv = prénom;nom)</label> <input type=\"file\" />
            </div>
            <div class=\"form-group\">
                <label  for=\"listeeleves\">Liste élèves</label>         
                <textarea class=\"form-control\" id=\"listeeleves\" name=\"listeeleves\"></textarea>        
            </div>

            <div class=\"form-group\">
                <button type=\"button\" class=\"btn\" onClick=\"uploadForm();\">Soumettre</button>
            </div>
        </div>
        <div class=\"col-lg-4\"><img src=\"";
        // line 34
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/bootstrap/images/cakeMission2.jpg"), "html", null, true);
        echo "\" alt=\"parts_egales\" /></div>
   </div>
    
  <!-- Panel -->
  <div class=\"text-center\" >
  <div class=\"panel panel-default\">
   <div class=\"panel-heading\">Données pour la génération des groupes</div>
   <div class=\"panel-body\">
    <div class=\"row\">
     <h3>[Choix d'une partition]</h3>
     <div id=\"choixGroupe\"></div>
    </div>
   </div>
  </div>
  <div class=\"panel panel-default\">
   <div class=\"panel-heading\">Voici les groupes</div>
   <div class=\"panel-body\">
    <div class=\"row\" id=\"res\">
     <h3>Les groupes</h3>

    </div>
   </div>
  </div>
    
    
";
    }

    // line 60
    public function block_ajout($context, array $blocks = array())
    {
        // line 61
        echo "<script>
                        function uploadForm() {
                            var liste = \$('#listeeleves').val();
                            var cardG = \$('#cardgroupes').val();
                            \$.ajax({
                                   url : 'jsonpartitionne',
                                   type : 'POST',
                                   cache : false,
                                   dataType : 'json',                                  
                                   data : {\"cardGrp\":cardG, \"personnes\" : liste },
                                   success : function(json, statut) { 
                                      jsoncallback(json);
                                      console.log(json);
                                   }
                            });
                        } 
                    </script>
";
    }

    public function getTemplateName()
    {
        return "OrgPartitioneurBundle:Default:partitionneur.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  100 => 61,  97 => 60,  67 => 34,  39 => 8,  36 => 7,  30 => 3,);
    }
}
