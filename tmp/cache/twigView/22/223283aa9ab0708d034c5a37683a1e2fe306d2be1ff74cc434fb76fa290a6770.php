<?php

/* C:\xampp\htdocs\celke\vendor\cakephp\bake\src\Template\Bake\Element\form.twig */
class __TwigTemplate_926e7c4c8c8c240eb3cc5e6ce08dd6c75f840b76ce2440f42f90495a0f855865 extends Twig_Template
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
        $__internal_770edd655cdeb606afc443e4edb1f19b4248a91788cb82e88bf8b9495a7c5cfa->enter($__internal_770edd655cdeb606afc443e4edb1f19b4248a91788cb82e88bf8b9495a7c5cfa_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "C:\\xampp\\htdocs\\celke\\vendor\\cakephp\\bake\\src\\Template\\Bake\\Element\\form.twig"));

        // line 16
        $context["fields"] = $this->getAttribute(($context["Bake"] ?? null), "filterFields", array(0 => ($context["fields"] ?? null), 1 => ($context["schema"] ?? null), 2 => ($context["modelObject"] ?? null)), "method");
        // line 17
        echo "<nav class=\"large-3 medium-4 columns\" id=\"actions-sidebar\">
    <ul class=\"side-nav\">
        <li class=\"heading\"><?= __('Actions') ?></li>
";
        // line 20
        if ((strpos(($context["action"] ?? null), "add") === false)) {
            // line 21
            echo "        <li><?= \$this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', \$";
            // line 23
            echo twig_escape_filter($this->env, ($context["singularVar"] ?? null), "html", null, true);
            echo "->";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["primaryKey"] ?? null), 0, array(), "array"), "html", null, true);
            echo "],
                ['confirm' => __('Are you sure you want to delete # {0}?', \$";
            // line 24
            echo twig_escape_filter($this->env, ($context["singularVar"] ?? null), "html", null, true);
            echo "->";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["primaryKey"] ?? null), 0, array(), "array"), "html", null, true);
            echo ")]
            )
        ?></li>
";
        }
        // line 28
        echo "        <li><?= \$this->Html->link(__('List ";
        echo twig_escape_filter($this->env, ($context["pluralHumanName"] ?? null), "html", null, true);
        echo "'), ['action' => 'index']) ?></li>";
        // line 29
        echo "
";
        // line 30
        $context["done"] = array();
        // line 31
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["associations"] ?? null));
        foreach ($context['_seq'] as $context["type"] => $context["data"]) {
            // line 32
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($context["data"]);
            foreach ($context['_seq'] as $context["alias"] => $context["details"]) {
                // line 33
                if (( !($this->getAttribute($context["details"], "controller", array()) === $this->getAttribute(($context["_view"] ?? null), "name", array())) && !twig_in_filter($this->getAttribute($context["details"], "controller", array()), ($context["done"] ?? null)))) {
                    // line 34
                    echo "        <li><?= \$this->Html->link(__('List ";
                    echo twig_escape_filter($this->env, Cake\Utility\Inflector::humanize(Cake\Utility\Inflector::underscore($context["alias"])), "html", null, true);
                    echo "'), ['controller' => '";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["details"], "controller", array()), "html", null, true);
                    echo "', 'action' => 'index']) ?></li>
        <li><?= \$this->Html->link(__('New ";
                    // line 35
                    echo twig_escape_filter($this->env, Cake\Utility\Inflector::humanize(Cake\Utility\Inflector::underscore(Cake\Utility\Inflector::singularize($context["alias"]))), "html", null, true);
                    echo "'), ['controller' => '";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["details"], "controller", array()), "html", null, true);
                    echo "', 'action' => 'add']) ?></li>";
                    // line 36
                    echo "
";
                    // line 37
                    $context["done"] = twig_array_merge(($context["done"] ?? null), array(0 => $this->getAttribute($context["details"], "controller", array())));
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['alias'], $context['details'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['type'], $context['data'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 41
        echo "    </ul>
</nav>
<div class=\"";
        // line 43
        echo twig_escape_filter($this->env, ($context["pluralVar"] ?? null), "html", null, true);
        echo " form large-9 medium-8 columns content\">
    <?= \$this->Form->create(\$";
        // line 44
        echo twig_escape_filter($this->env, ($context["singularVar"] ?? null), "html", null, true);
        echo ") ?>
    <fieldset>
        <legend><?= __('";
        // line 46
        echo twig_escape_filter($this->env, Cake\Utility\Inflector::humanize(($context["action"] ?? null)), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, ($context["singularHumanName"] ?? null), "html", null, true);
        echo "') ?></legend>
        <?php
";
        // line 48
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["fields"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["field"]) {
            if (!twig_in_filter($context["field"], ($context["primaryKey"] ?? null))) {
                // line 49
                if ($this->getAttribute(($context["keyFields"] ?? null), $context["field"], array(), "array")) {
                    // line 50
                    $context["fieldData"] = $this->getAttribute(($context["Bake"] ?? null), "columnData", array(0 => $context["field"], 1 => ($context["schema"] ?? null)), "method");
                    // line 51
                    if ($this->getAttribute(($context["fieldData"] ?? null), "null", array())) {
                        // line 52
                        echo "            echo \$this->Form->control('";
                        echo twig_escape_filter($this->env, $context["field"], "html", null, true);
                        echo "', ['options' => \$";
                        echo twig_escape_filter($this->env, $this->getAttribute(($context["keyFields"] ?? null), $context["field"], array(), "array"), "html", null, true);
                        echo ", 'empty' => true]);";
                        // line 53
                        echo "
";
                    } else {
                        // line 55
                        echo "            echo \$this->Form->control('";
                        echo twig_escape_filter($this->env, $context["field"], "html", null, true);
                        echo "', ['options' => \$";
                        echo twig_escape_filter($this->env, $this->getAttribute(($context["keyFields"] ?? null), $context["field"], array(), "array"), "html", null, true);
                        echo "]);";
                        // line 56
                        echo "
";
                    }
                } elseif (!twig_in_filter(                // line 58
$context["field"], array(0 => "created", 1 => "modified", 2 => "updated"))) {
                    // line 59
                    $context["fieldData"] = $this->getAttribute(($context["Bake"] ?? null), "columnData", array(0 => $context["field"], 1 => ($context["schema"] ?? null)), "method");
                    // line 60
                    if ((twig_in_filter($this->getAttribute(($context["fieldData"] ?? null), "type", array()), array(0 => "date", 1 => "datetime", 2 => "time")) && $this->getAttribute(($context["fieldData"] ?? null), "null", array()))) {
                        // line 61
                        echo "            echo \$this->Form->control('";
                        echo twig_escape_filter($this->env, $context["field"], "html", null, true);
                        echo "', ['empty' => true]);";
                        // line 62
                        echo "
";
                    } else {
                        // line 64
                        echo "            echo \$this->Form->control('";
                        echo twig_escape_filter($this->env, $context["field"], "html", null, true);
                        echo "');";
                        // line 65
                        echo "
";
                    }
                }
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['field'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 70
        if ($this->getAttribute(($context["associations"] ?? null), "BelongsToMany", array())) {
            // line 71
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["associations"] ?? null), "BelongsToMany", array()));
            foreach ($context['_seq'] as $context["assocName"] => $context["assocData"]) {
                // line 72
                echo "            echo \$this->Form->control('";
                echo twig_escape_filter($this->env, $this->getAttribute($context["assocData"], "property", array()), "html", null, true);
                echo "._ids', ['options' => \$";
                echo twig_escape_filter($this->env, $this->getAttribute($context["assocData"], "variable", array()), "html", null, true);
                echo "]);";
                // line 73
                echo "
";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['assocName'], $context['assocData'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 76
        echo "        ?>
    </fieldset>
    <?= \$this->Form->button(__('Submit')) ?>
    <?= \$this->Form->end() ?>
</div>
";
        
        $__internal_770edd655cdeb606afc443e4edb1f19b4248a91788cb82e88bf8b9495a7c5cfa->leave($__internal_770edd655cdeb606afc443e4edb1f19b4248a91788cb82e88bf8b9495a7c5cfa_prof);

    }

    public function getTemplateName()
    {
        return "C:\\xampp\\htdocs\\celke\\vendor\\cakephp\\bake\\src\\Template\\Bake\\Element\\form.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  194 => 76,  186 => 73,  180 => 72,  176 => 71,  174 => 70,  164 => 65,  160 => 64,  156 => 62,  152 => 61,  150 => 60,  148 => 59,  146 => 58,  142 => 56,  136 => 55,  132 => 53,  126 => 52,  124 => 51,  122 => 50,  120 => 49,  115 => 48,  108 => 46,  103 => 44,  99 => 43,  95 => 41,  84 => 37,  81 => 36,  76 => 35,  69 => 34,  67 => 33,  63 => 32,  59 => 31,  57 => 30,  54 => 29,  50 => 28,  41 => 24,  35 => 23,  31 => 21,  29 => 20,  24 => 17,  22 => 16,);
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
{% set fields = Bake.filterFields(fields, schema, modelObject) %}
<nav class=\"large-3 medium-4 columns\" id=\"actions-sidebar\">
    <ul class=\"side-nav\">
        <li class=\"heading\"><?= __('Actions') ?></li>
{% if strpos(action, 'add') is same as(false) %}
        <li><?= \$this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', \${{ singularVar }}->{{ primaryKey[0] }}],
                ['confirm' => __('Are you sure you want to delete # {0}?', \${{ singularVar }}->{{ primaryKey[0] }})]
            )
        ?></li>
{% endif %}
        <li><?= \$this->Html->link(__('List {{ pluralHumanName }}'), ['action' => 'index']) ?></li>
        {{- \"\\n\" }}
{%- set done = [] %}
{% for type, data in associations %}
    {%- for alias, details in data %}
        {%- if details.controller is not same as(_view.name) and details.controller not in done %}
        <li><?= \$this->Html->link(__('List {{ alias|underscore|humanize }}'), ['controller' => '{{ details.controller }}', 'action' => 'index']) ?></li>
        <li><?= \$this->Html->link(__('New {{ alias|singularize|underscore|humanize }}'), ['controller' => '{{ details.controller }}', 'action' => 'add']) ?></li>
        {{- \"\\n\" }}
        {%- set done = done|merge([details.controller]) %}
        {%- endif %}
    {%- endfor %}
{% endfor %}
    </ul>
</nav>
<div class=\"{{ pluralVar }} form large-9 medium-8 columns content\">
    <?= \$this->Form->create(\${{ singularVar }}) ?>
    <fieldset>
        <legend><?= __('{{ action|humanize }} {{ singularHumanName }}') ?></legend>
        <?php
{% for field in fields if field not in primaryKey %}
    {%- if keyFields[field] %}
        {%- set fieldData = Bake.columnData(field, schema) %}
        {%- if fieldData.null %}
            echo \$this->Form->control('{{ field }}', ['options' => \${{ keyFields[field] }}, 'empty' => true]);
            {{- \"\\n\" }}
        {%- else %}
            echo \$this->Form->control('{{ field }}', ['options' => \${{ keyFields[field] }}]);
            {{- \"\\n\" }}
        {%- endif %}
    {%- elseif field not in ['created', 'modified', 'updated'] %}
        {%- set fieldData = Bake.columnData(field, schema) %}
        {%- if fieldData.type in ['date', 'datetime', 'time'] and fieldData.null %}
            echo \$this->Form->control('{{ field }}', ['empty' => true]);
            {{- \"\\n\" }}
        {%- else %}
            echo \$this->Form->control('{{ field }}');
    {{- \"\\n\" }}
        {%- endif %}
    {%- endif %}
{%- endfor %}

{%- if associations.BelongsToMany %}
    {%- for assocName, assocData in associations.BelongsToMany %}
            echo \$this->Form->control('{{ assocData.property }}._ids', ['options' => \${{ assocData.variable }}]);
    {{- \"\\n\" }}
    {%- endfor %}
{% endif %}
        ?>
    </fieldset>
    <?= \$this->Form->button(__('Submit')) ?>
    <?= \$this->Form->end() ?>
</div>
", "C:\\xampp\\htdocs\\celke\\vendor\\cakephp\\bake\\src\\Template\\Bake\\Element\\form.twig", "C:\\xampp\\htdocs\\celke\\vendor\\cakephp\\bake\\src\\Template\\Bake\\Element\\form.twig");
    }
}
