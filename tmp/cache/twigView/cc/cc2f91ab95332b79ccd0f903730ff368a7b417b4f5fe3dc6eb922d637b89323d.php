<?php

/* C:\xampp\htdocs\celke\vendor\cakephp\bake\src\Template\Bake\Model\entity.twig */
class __TwigTemplate_6981f6661d2dfb065f862df43a88d00108edfb2180f9bdc7435a3490b7c76ffb extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_770edd655cdeb606afc443e4edb1f19b4248a91788cb82e88bf8b9495a7c5cfa = $this->env->getExtension("WyriHaximus\\TwigView\\Lib\\Twig\\Extension\\Profiler");
        $__internal_770edd655cdeb606afc443e4edb1f19b4248a91788cb82e88bf8b9495a7c5cfa->enter($__internal_770edd655cdeb606afc443e4edb1f19b4248a91788cb82e88bf8b9495a7c5cfa_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "C:\\xampp\\htdocs\\celke\\vendor\\cakephp\\bake\\src\\Template\\Bake\\Model\\entity.twig"));

        // line 16
        $context["propertyHintMap"] = $this->getAttribute(($context["DocBlock"] ?? null), "buildEntityPropertyHintTypeMap", array(0 => ((($context["propertySchema"] ?? null)) ? (($context["propertySchema"] ?? null)) : (array()))), "method");
        // line 17
        $context["associationHintMap"] = $this->getAttribute(($context["DocBlock"] ?? null), "buildEntityAssociationHintTypeMap", array(0 => ((($context["propertySchema"] ?? null)) ? (($context["propertySchema"] ?? null)) : (array()))), "method");
        // line 18
        $context["annotations"] = $this->getAttribute(($context["DocBlock"] ?? null), "propertyHints", array(0 => ($context["propertyHintMap"] ?? null)), "method");
        // line 20
        if (($context["associationHintMap"] ?? null)) {
            // line 21
            $context["annotations"] = twig_array_merge(($context["annotations"] ?? null), array(0 => ""));
            // line 22
            $context["annotations"] = twig_array_merge(($context["annotations"] ?? null), $this->getAttribute(($context["DocBlock"] ?? null), "propertyHints", array(0 => ($context["associationHintMap"] ?? null)), "method"));
        }
        // line 25
        $context["accessible"] = $this->getAttribute(($context["Bake"] ?? null), "getFieldAccessibility", array(0 => ($context["fields"] ?? null), 1 => ($context["primaryKey"] ?? null)), "method");
        // line 26
        echo "<?php
namespace ";
        // line 27
        echo twig_escape_filter($this->env, ($context["namespace"] ?? null), "html", null, true);
        echo "\\Model\\Entity;

use Cake\\ORM\\Entity;

";
        // line 31
        echo $this->getAttribute(($context["DocBlock"] ?? null), "classDescription", array(0 => ($context["name"] ?? null), 1 => "Entity", 2 => ($context["annotations"] ?? null)), "method");
        echo "
class ";
        // line 32
        echo twig_escape_filter($this->env, ($context["name"] ?? null), "html", null, true);
        echo " extends Entity
{
";
        // line 34
        if (($context["accessible"] ?? null)) {
            // line 35
            echo "
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected \$_accessible = [";
            // line 45
            echo $this->getAttribute(($context["Bake"] ?? null), "stringifyList", array(0 => ($context["accessible"] ?? null), 1 => array("quotes" => false)), "method");
            echo "];
";
        }
        // line 48
        if (($context["hidden"] ?? null)) {
            // line 49
            echo "
    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected \$_hidden = [";
            // line 55
            echo $this->getAttribute(($context["Bake"] ?? null), "stringifyList", array(0 => ($context["hidden"] ?? null)), "method");
            echo "];
";
        }
        // line 58
        if (( !($context["accessible"] ?? null) &&  !($context["hidden"] ?? null))) {
            // line 59
            echo "
";
        }
        // line 61
        echo "}
";
        
        $__internal_770edd655cdeb606afc443e4edb1f19b4248a91788cb82e88bf8b9495a7c5cfa->leave($__internal_770edd655cdeb606afc443e4edb1f19b4248a91788cb82e88bf8b9495a7c5cfa_prof);

    }

    public function getTemplateName()
    {
        return "C:\\xampp\\htdocs\\celke\\vendor\\cakephp\\bake\\src\\Template\\Bake\\Model\\entity.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  96 => 61,  92 => 59,  90 => 58,  85 => 55,  77 => 49,  75 => 48,  70 => 45,  58 => 35,  56 => 34,  51 => 32,  47 => 31,  40 => 27,  37 => 26,  35 => 25,  32 => 22,  30 => 21,  28 => 20,  26 => 18,  24 => 17,  22 => 16,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{#
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         2.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
#}
{% set propertyHintMap = DocBlock.buildEntityPropertyHintTypeMap(propertySchema ?: []) %}
{% set associationHintMap = DocBlock.buildEntityAssociationHintTypeMap(propertySchema ?: []) %}
{% set annotations = DocBlock.propertyHints(propertyHintMap) %}

{%- if associationHintMap %}
    {%- set annotations = annotations|merge(['']) %}
    {%- set annotations = annotations|merge(DocBlock.propertyHints(associationHintMap)) %}
{% endif %}

{%- set accessible = Bake.getFieldAccessibility(fields, primaryKey) %}
<?php
namespace {{ namespace }}\\Model\\Entity;

use Cake\\ORM\\Entity;

{{ DocBlock.classDescription(name, 'Entity', annotations)|raw }}
class {{ name }} extends Entity
{
{% if accessible %}

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected \$_accessible = [{{ Bake.stringifyList(accessible, {'quotes': false})|raw }}];
{% endif %}

{%- if hidden %}

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected \$_hidden = [{{ Bake.stringifyList(hidden)|raw }}];
{% endif %}

{%- if not accessible and not hidden %}

{% endif %}
}
", "C:\\xampp\\htdocs\\celke\\vendor\\cakephp\\bake\\src\\Template\\Bake\\Model\\entity.twig", "C:\\xampp\\htdocs\\celke\\vendor\\cakephp\\bake\\src\\Template\\Bake\\Model\\entity.twig");
    }
}
