<?php

/* OrgPartitioneurBundle:Default:index.html.twig */
class __TwigTemplate_160e88ec914bc9ecf29bc0ac31691ab14be86914f0cd302606cff122e791dd0c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("::layout.html.twig");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheet' => array($this, 'block_stylesheet'),
            'content' => array($this, 'block_content'),
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

    // line 5
    public function block_stylesheet($context, array $blocks = array())
    {
        // line 6
        echo "        <link rel=\"stylesheet\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/ajax/js/custom.js"), "html", null, true);
        echo "\" />
    ";
    }

    // line 9
    public function block_content($context, array $blocks = array())
    {
        // line 10
        echo "    
    <div class=\"row\">
     <form>
      <div class=\"col-md-4\">
       <div class=\"form-group\">
        <label>Intitulé du devoir</label> <input class=\"form-control\" />
       </div>
       <div class=\"form-group\">        
         <label> Card max des groupes <input type=\"text\" id='cardgroupes' value=\"3\"/>
         </label>     
      </div>
      
       <div class=\"form-group\">
        <label>Fichier des élèves (csv = prénom;nom)</label> <input
         type=\"file\" />
       </div>
       <div class=\"form-group\">
           <label  for=\"listeeleves\">Liste élèves</label>         
          <textarea class=\"form-control\" id=\"listeeleves\" name=\"listeeleves\"></textarea>        
       </div>
          
       <div class=\"form-group\">
        <button type=\"button\" class=\"btn\" onClick=\"test()\">Soumettre</button>
       </div>
     
     </form>
        
    </div>
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

    public function getTemplateName()
    {
        return "OrgPartitioneurBundle:Default:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  49 => 10,  46 => 9,  39 => 6,  36 => 5,  30 => 3,);
    }
}
