<?php

/* OrgFormaBundle:Default:index.html.twig */
class __TwigTemplate_a84f67c310e31cd1ecf2b7eec1f1099fb074f883e7c6ee5fe156d42e2b615da4 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("::layout.html.twig");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'contentCenter' => array($this, 'block_contentCenter'),
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
        echo twig_escape_filter($this->env, ($this->renderParentBlock("title", $context, $blocks) . "Page de log"), "html", null, true);
    }

    // line 5
    public function block_contentCenter($context, array $blocks = array())
    {
        // line 6
        echo "    
    <form action=\"\">
        <h1>Connexion</h1>
        Identifiant : <input type=\"text\" id=\"inputLog\"/>
        </br>
        Mot de Passe : <input type=\"password\" id=\"password\"/>
        </br>
        <input type=\"submit\" value=\"Se connecter\"/>
    
    </form>
";
    }

    public function getTemplateName()
    {
        return "OrgFormaBundle:Default:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  38 => 6,  35 => 5,  29 => 3,);
    }
}
