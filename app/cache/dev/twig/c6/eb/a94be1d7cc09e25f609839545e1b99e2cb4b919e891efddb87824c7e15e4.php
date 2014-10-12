<?php

/* ::layout.html.twig */
class __TwigTemplate_c6eba94be1d7cc09e25f609839545e1b99e2cb4b919e891efddb87824c7e15e4 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheet' => array($this, 'block_stylesheet'),
            'javascript' => array($this, 'block_javascript'),
            'contentCenter' => array($this, 'block_contentCenter'),
            'content' => array($this, 'block_content'),
            'javascripts' => array($this, 'block_javascripts'),
            'ajout' => array($this, 'block_ajout'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"fr\">
\t<head>
\t\t<meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\">
\t\t<meta charset=\"utf-8\">
\t\t<title>";
        // line 6
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
\t\t<meta name=\"generator\" content=\"Bootply\" />
\t\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1\">
\t\t<!--[if lt IE 9]>
\t\t\t<script src=\"//html5shim.googlecode.com/svn/trunk/html5.js\"></script>
\t\t<![endif]-->
\t\t<!--<link href=\"css/styles.css\" rel=\"stylesheet\">-->
                ";
        // line 13
        $this->displayBlock('stylesheet', $context, $blocks);
        // line 18
        echo "                ";
        $this->displayBlock('javascript', $context, $blocks);
        // line 20
        echo "                
\t</head>
\t<body>
<div class=\"navbar navbar-default navbar-static-top\">
  <div class=\"container\">
    <div class=\"navbar-header\">
      <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\".navbar-collapse\">
        <span class=\"icon-bar\"></span>
        <span class=\"icon-bar\"></span>
        <span class=\"icon-bar\"></span>
      </button>
      <a class=\"navbar-brand\" href=\"#\">DaVyAn</a>
    </div>
    <div class=\"collapse navbar-collapse\">
      <ul class=\"nav navbar-nav\">
        <li class=\"";
        // line 35
        if (($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "request"), "attributes"), "get", array(0 => "_route"), "method") == "_index")) {
            echo "active";
        }
        echo "\"><a href=\"";
        echo $this->env->getExtension('routing')->getPath("_index");
        echo "\">Accueil</a></li>
        <li class=\"";
        // line 36
        if (($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "request"), "attributes"), "get", array(0 => "_route"), "method") == "_partitioneur")) {
            echo "active";
        }
        echo "\"><a href='";
        echo $this->env->getExtension('routing')->getPath("_partitioneur");
        echo "'>Partitioneur</a></li>
      </ul>
      <ul class=\"nav navbar-nav navbar-right\">
        <li><a href=\"#about\">Logout</a></li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</div>

<div class=\"container\">
    
    <div class=\"text-center\">
      ";
        // line 48
        $this->displayBlock('contentCenter', $context, $blocks);
        // line 50
        echo "    </div>
    
    ";
        // line 52
        $this->displayBlock('content', $context, $blocks);
        // line 54
        echo "  
  
  
</div><!-- /.container -->
\t<!-- script references -->
        
                
                ";
        // line 61
        $this->displayBlock('javascripts', $context, $blocks);
        // line 74
        echo "                ";
        $this->displayBlock('ajout', $context, $blocks);
        // line 76
        echo "                
                <script>
                    function setClassActive(item) {
                        
                        var div = document.getElementsByTagName(\"li\").item(item);
                        div.setAttribute(\"class\",\"active\");
                    }
                    
                </script>
                
\t</body>
</html>
";
    }

    // line 6
    public function block_title($context, array $blocks = array())
    {
    }

    // line 13
    public function block_stylesheet($context, array $blocks = array())
    {
        // line 14
        echo "                    <link rel=\"stylesheet\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/bootstrap/css/bootstrap.min.css"), "html", null, true);
        echo "\" />
                    <link rel=\"stylesheet\" href=\"";
        // line 15
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/bootstrap/css/styles.css"), "html", null, true);
        echo "\" />
                    
                ";
    }

    // line 18
    public function block_javascript($context, array $blocks = array())
    {
        // line 19
        echo "                ";
    }

    // line 48
    public function block_contentCenter($context, array $blocks = array())
    {
        // line 49
        echo "      ";
    }

    // line 52
    public function block_content($context, array $blocks = array())
    {
        // line 53
        echo "    ";
    }

    // line 61
    public function block_javascripts($context, array $blocks = array())
    {
        // line 62
        echo "                    <script src=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/ajax/js/jquery-1.11.1.min.js"), "html", null, true);
        echo "\"></script>
                    <!-- BOOTSTRAP SCRIPTS -->
                    <script src=\"";
        // line 64
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/ajax/js/bootstrap.min.js"), "html", null, true);
        echo "\"></script>
                    <!-- METISMENU SCRIPTS -->
                    <script src=\"";
        // line 66
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/ajax/js/jquery.metisMenu.js"), "html", null, true);
        echo "\"></script>
                    <!-- CUSTOM SCRIPTS -->
                    <script src=\"";
        // line 68
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/ajax/js/custom.js"), "html", null, true);
        echo "\"></script>
                    <script src=\"";
        // line 69
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"), "html", null, true);
        echo "\"></script>
                    ";
        // line 71
        echo "                    <!--<script src=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/ajax/js/uploadForm.js"), "html", null, true);
        echo "\"></script>-->
                    <script src=\"";
        // line 72
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/ajax/js/jsoncallback.js"), "html", null, true);
        echo "\"></script>
                ";
    }

    // line 74
    public function block_ajout($context, array $blocks = array())
    {
        // line 75
        echo "                ";
    }

    public function getTemplateName()
    {
        return "::layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  212 => 75,  209 => 74,  203 => 72,  198 => 71,  194 => 69,  190 => 68,  185 => 66,  180 => 64,  174 => 62,  171 => 61,  167 => 53,  164 => 52,  160 => 49,  157 => 48,  153 => 19,  150 => 18,  143 => 15,  138 => 14,  135 => 13,  130 => 6,  114 => 76,  111 => 74,  109 => 61,  100 => 54,  98 => 52,  94 => 50,  92 => 48,  73 => 36,  65 => 35,  48 => 20,  45 => 18,  43 => 13,  33 => 6,  26 => 1,);
    }
}
