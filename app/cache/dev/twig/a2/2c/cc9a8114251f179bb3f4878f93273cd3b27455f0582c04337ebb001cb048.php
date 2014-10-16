<?php

/* OrgFormaBundle:Default:test.html.twig */
class __TwigTemplate_a22ccc9a8114251f179bb3f4878f93273cd3b27455f0582c04337ebb001cb048 extends Twig_Template
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
        echo twig_escape_filter($this->env, ($this->renderParentBlock("title", $context, $blocks) . "Page de test"), "html", null, true);
    }

    // line 5
    public function block_contentCenter($context, array $blocks = array())
    {
        // line 6
        echo "    
    ";
        // line 7
        echo twig_escape_filter($this->env, (isset($context["message"]) ? $context["message"] : $this->getContext($context, "message")), "html", null, true);
        echo "
    
";
    }

    public function getTemplateName()
    {
        return "OrgFormaBundle:Default:test.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  41 => 7,  38 => 6,  35 => 5,  29 => 3,);
    }
}
