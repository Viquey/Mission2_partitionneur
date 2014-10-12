<?php

/* ::layout.html.twig */
class __TwigTemplate_890c75d32ba8b0e963a6c5c0e62fe1d0ee952f4c96a90cfc7f104acbb3737efb extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheet' => array($this, 'block_stylesheet'),
            'contentCenter' => array($this, 'block_contentCenter'),
            'content' => array($this, 'block_content'),
            'javascripts' => array($this, 'block_javascripts'),
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
        echo "\t</head>
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
        <li class=\"active\"><a href=\"#\">Accueil</a></li>
        <li><a href='";
        // line 33
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
        // line 45
        $this->displayBlock('contentCenter', $context, $blocks);
        // line 47
        echo "    </div>
    
    ";
        // line 49
        $this->displayBlock('content', $context, $blocks);
        // line 51
        echo "  
  
  
</div><!-- /.container -->
\t<!-- script references -->
\t\t<script src=\"//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js\"></script>
                
                ";
        // line 58
        $this->displayBlock('javascripts', $context, $blocks);
        // line 63
        echo "\t</body>
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
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/bootstrap/css/style.css"), "html", null, true);
        echo "\" />
                
                ";
    }

    // line 45
    public function block_contentCenter($context, array $blocks = array())
    {
        // line 46
        echo "      ";
    }

    // line 49
    public function block_content($context, array $blocks = array())
    {
        // line 50
        echo "    ";
    }

    // line 58
    public function block_javascripts($context, array $blocks = array())
    {
        // line 59
        echo "                ";
        // line 60
        echo "                <script type=\"text/javascript\"
                src=\"";
        // line 61
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/bootstrap/js/bootstrap.min.js"), "html", null, true);
        echo "\"></script>
                ";
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
        return array (  142 => 61,  139 => 60,  137 => 59,  134 => 58,  130 => 50,  127 => 49,  123 => 46,  120 => 45,  113 => 15,  108 => 14,  105 => 13,  100 => 6,  94 => 63,  92 => 58,  83 => 51,  81 => 49,  77 => 47,  75 => 45,  60 => 33,  43 => 18,  41 => 13,  31 => 6,  24 => 1,);
    }
}
