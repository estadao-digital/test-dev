<?php

/* C:\xampp\htdocs\celke\vendor\cakephp\bake\src\Template\Bake\Template\view.twig */
class __TwigTemplate_0739cd3aed863619cbf6fd233ca8effd2a49ec70563faf81313546ad24ad2a0b extends Twig_Template
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
        $__internal_770edd655cdeb606afc443e4edb1f19b4248a91788cb82e88bf8b9495a7c5cfa->enter($__internal_770edd655cdeb606afc443e4edb1f19b4248a91788cb82e88bf8b9495a7c5cfa_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "C:\\xampp\\htdocs\\celke\\vendor\\cakephp\\bake\\src\\Template\\Bake\\Template\\view.twig"));

        // line 16
        echo "<?php
/**
 * @var \\";
        // line 18
        echo twig_escape_filter($this->env, ($context["namespace"] ?? null), "html", null, true);
        echo "\\View\\AppView \$this
 * @var \\";
        // line 19
        echo twig_escape_filter($this->env, ($context["entityClass"] ?? null), "html", null, true);
        echo " \$";
        echo twig_escape_filter($this->env, ($context["singularVar"] ?? null), "html", null, true);
        echo "
 */
?>
";
        // line 22
        $context["associations"] = twig_array_merge(array("BelongsTo" => array(), "HasOne" => array(), "HasMany" => array(), "BelongsToMany" => array()), ($context["associations"] ?? null));
        // line 23
        $context["fieldsData"] = $this->getAttribute(($context["Bake"] ?? null), "getViewFieldsData", array(0 => ($context["fields"] ?? null), 1 => ($context["schema"] ?? null), 2 => ($context["associations"] ?? null)), "method");
        // line 24
        $context["associationFields"] = $this->getAttribute(($context["fieldsData"] ?? null), "associationFields", array());
        // line 25
        $context["groupedFields"] = $this->getAttribute(($context["fieldsData"] ?? null), "groupedFields", array());
        // line 26
        $context["pK"] = ((("\$" . ($context["singularVar"] ?? null)) . "->") . $this->getAttribute(($context["primaryKey"] ?? null), 0, array(), "array"));
        // line 27
        echo "<nav class=\"large-3 medium-4 columns\" id=\"actions-sidebar\">
    <ul class=\"side-nav\">
        <li class=\"heading\"><?= __('Actions') ?></li>
        <li><?= \$this->Html->link(__('Edit ";
        // line 30
        echo twig_escape_filter($this->env, ($context["singularHumanName"] ?? null), "html", null, true);
        echo "'), ['action' => 'edit', ";
        echo ($context["pK"] ?? null);
        echo "]) ?> </li>
        <li><?= \$this->Form->postLink(__('Delete ";
        // line 31
        echo twig_escape_filter($this->env, ($context["singularHumanName"] ?? null), "html", null, true);
        echo "'), ['action' => 'delete', ";
        echo ($context["pK"] ?? null);
        echo "], ['confirm' => __('Are you sure you want to delete # {0}?', ";
        echo ($context["pK"] ?? null);
        echo ")]) ?> </li>
        <li><?= \$this->Html->link(__('List ";
        // line 32
        echo twig_escape_filter($this->env, ($context["pluralHumanName"] ?? null), "html", null, true);
        echo "'), ['action' => 'index']) ?> </li>
        <li><?= \$this->Html->link(__('New ";
        // line 33
        echo twig_escape_filter($this->env, ($context["singularHumanName"] ?? null), "html", null, true);
        echo "'), ['action' => 'add']) ?> </li>
";
        // line 34
        $context["done"] = array();
        // line 35
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["associations"] ?? null));
        foreach ($context['_seq'] as $context["type"] => $context["data"]) {
            // line 36
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($context["data"]);
            foreach ($context['_seq'] as $context["alias"] => $context["details"]) {
                // line 37
                if (( !($this->getAttribute($context["details"], "controller", array()) === $this->getAttribute(($context["_view"] ?? null), "name", array())) && !twig_in_filter($this->getAttribute($context["details"], "controller", array()), ($context["done"] ?? null)))) {
                    // line 38
                    echo "        <li><?= \$this->Html->link(__('List ";
                    echo twig_escape_filter($this->env, Cake\Utility\Inflector::humanize(Cake\Utility\Inflector::underscore($context["alias"])), "html", null, true);
                    echo "'), ['controller' => '";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["details"], "controller", array()), "html", null, true);
                    echo "', 'action' => 'index']) ?> </li>
        <li><?= \$this->Html->link(__('New ";
                    // line 39
                    echo twig_escape_filter($this->env, Cake\Utility\Inflector::humanize(Cake\Utility\Inflector::singularize(Cake\Utility\Inflector::underscore($context["alias"]))), "html", null, true);
                    echo "'), ['controller' => '";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["details"], "controller", array()), "html", null, true);
                    echo "', 'action' => 'add']) ?> </li>
";
                    // line 40
                    $context["done"] = twig_array_merge(($context["done"] ?? null), array(0 => "controller"));
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['alias'], $context['details'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['type'], $context['data'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 44
        echo "    </ul>
</nav>
<div class=\"";
        // line 46
        echo twig_escape_filter($this->env, ($context["pluralVar"] ?? null), "html", null, true);
        echo " view large-9 medium-8 columns content\">
    <h3><?= h(\$";
        // line 47
        echo twig_escape_filter($this->env, ($context["singularVar"] ?? null), "html", null, true);
        echo "->";
        echo twig_escape_filter($this->env, ($context["displayField"] ?? null), "html", null, true);
        echo ") ?></h3>
    <table class=\"vertical-table\">
";
        // line 49
        if ($this->getAttribute(($context["groupedFields"] ?? null), "string", array(), "array")) {
            // line 50
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["groupedFields"] ?? null), "string", array(), "array"));
            foreach ($context['_seq'] as $context["_key"] => $context["field"]) {
                // line 51
                if ($this->getAttribute(($context["associationFields"] ?? null), $context["field"], array(), "array")) {
                    // line 52
                    $context["details"] = $this->getAttribute(($context["associationFields"] ?? null), $context["field"], array(), "array");
                    // line 53
                    echo "        <tr>
            <th scope=\"row\"><?= __('";
                    // line 54
                    echo twig_escape_filter($this->env, Cake\Utility\Inflector::humanize($this->getAttribute(($context["details"] ?? null), "property", array())), "html", null, true);
                    echo "') ?></th>
            <td><?= \$";
                    // line 55
                    echo twig_escape_filter($this->env, ($context["singularVar"] ?? null), "html", null, true);
                    echo "->has('";
                    echo twig_escape_filter($this->env, $this->getAttribute(($context["details"] ?? null), "property", array()), "html", null, true);
                    echo "') ? \$this->Html->link(\$";
                    echo twig_escape_filter($this->env, ($context["singularVar"] ?? null), "html", null, true);
                    echo "->";
                    echo twig_escape_filter($this->env, $this->getAttribute(($context["details"] ?? null), "property", array()), "html", null, true);
                    echo "->";
                    echo twig_escape_filter($this->env, $this->getAttribute(($context["details"] ?? null), "displayField", array()), "html", null, true);
                    echo ", ['controller' => '";
                    echo twig_escape_filter($this->env, $this->getAttribute(($context["details"] ?? null), "controller", array()), "html", null, true);
                    echo "', 'action' => 'view', \$";
                    echo twig_escape_filter($this->env, ($context["singularVar"] ?? null), "html", null, true);
                    echo "->";
                    echo twig_escape_filter($this->env, $this->getAttribute(($context["details"] ?? null), "property", array()), "html", null, true);
                    echo "->";
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["details"] ?? null), "primaryKey", array()), 0, array(), "array"), "html", null, true);
                    echo "]) : '' ?></td>
        </tr>
";
                } else {
                    // line 58
                    echo "        <tr>
            <th scope=\"row\"><?= __('";
                    // line 59
                    echo twig_escape_filter($this->env, Cake\Utility\Inflector::humanize($context["field"]), "html", null, true);
                    echo "') ?></th>
            <td><?= h(\$";
                    // line 60
                    echo twig_escape_filter($this->env, ($context["singularVar"] ?? null), "html", null, true);
                    echo "->";
                    echo twig_escape_filter($this->env, $context["field"], "html", null, true);
                    echo ") ?></td>
        </tr>
";
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['field'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 65
        if ($this->getAttribute(($context["associations"] ?? null), "HasOne", array())) {
            // line 66
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["associations"] ?? null), "HasOne", array()));
            foreach ($context['_seq'] as $context["alias"] => $context["details"]) {
                // line 67
                echo "        <tr>
            <th scope=\"row\"><?= __('";
                // line 68
                echo twig_escape_filter($this->env, Cake\Utility\Inflector::humanize(Cake\Utility\Inflector::singularize(Cake\Utility\Inflector::underscore($context["alias"]))), "html", null, true);
                echo "') ?></th>
            <td><?= \$";
                // line 69
                echo twig_escape_filter($this->env, ($context["singularVar"] ?? null), "html", null, true);
                echo "->has('";
                echo twig_escape_filter($this->env, $this->getAttribute($context["details"], "property", array()), "html", null, true);
                echo "') ? \$this->Html->link(\$";
                echo twig_escape_filter($this->env, ($context["singularVar"] ?? null), "html", null, true);
                echo "->";
                echo twig_escape_filter($this->env, $this->getAttribute($context["details"], "property", array()), "html", null, true);
                echo "->";
                echo twig_escape_filter($this->env, $this->getAttribute($context["details"], "displayField", array()), "html", null, true);
                echo ", ['controller' => '";
                echo twig_escape_filter($this->env, $this->getAttribute($context["details"], "controller", array()), "html", null, true);
                echo "', 'action' => 'view', \$";
                echo twig_escape_filter($this->env, ($context["singularVar"] ?? null), "html", null, true);
                echo "->";
                echo twig_escape_filter($this->env, $this->getAttribute($context["details"], "property", array()), "html", null, true);
                echo "->";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["details"], "primaryKey", array()), 0, array(), "array"), "html", null, true);
                echo "]) : '' ?></td>
        </tr>
";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['alias'], $context['details'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 73
        if ($this->getAttribute(($context["groupedFields"] ?? null), "number", array())) {
            // line 74
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["groupedFields"] ?? null), "number", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["field"]) {
                // line 75
                echo "        <tr>
            <th scope=\"row\"><?= __('";
                // line 76
                echo twig_escape_filter($this->env, Cake\Utility\Inflector::humanize($context["field"]), "html", null, true);
                echo "') ?></th>
            <td><?= \$this->Number->format(\$";
                // line 77
                echo twig_escape_filter($this->env, ($context["singularVar"] ?? null), "html", null, true);
                echo "->";
                echo twig_escape_filter($this->env, $context["field"], "html", null, true);
                echo ") ?></td>
        </tr>
";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['field'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 81
        if ($this->getAttribute(($context["groupedFields"] ?? null), "date", array())) {
            // line 82
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["groupedFields"] ?? null), "date", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["field"]) {
                // line 83
                echo "        <tr>
            <th scope=\"row\"><?= __('";
                // line 84
                echo twig_escape_filter($this->env, Cake\Utility\Inflector::humanize($context["field"]), "html", null, true);
                echo "') ?></th>
            <td><?= h(\$";
                // line 85
                echo twig_escape_filter($this->env, ($context["singularVar"] ?? null), "html", null, true);
                echo "->";
                echo twig_escape_filter($this->env, $context["field"], "html", null, true);
                echo ") ?></td>
        </tr>
";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['field'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 89
        if ($this->getAttribute(($context["groupedFields"] ?? null), "boolean", array())) {
            // line 90
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["groupedFields"] ?? null), "boolean", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["field"]) {
                // line 91
                echo "        <tr>
            <th scope=\"row\"><?= __('";
                // line 92
                echo twig_escape_filter($this->env, Cake\Utility\Inflector::humanize($context["field"]), "html", null, true);
                echo "') ?></th>
            <td><?= \$";
                // line 93
                echo twig_escape_filter($this->env, ($context["singularVar"] ?? null), "html", null, true);
                echo "->";
                echo twig_escape_filter($this->env, $context["field"], "html", null, true);
                echo " ? __('Yes') : __('No'); ?></td>
        </tr>
";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['field'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 97
        echo "    </table>
";
        // line 98
        if ($this->getAttribute(($context["groupedFields"] ?? null), "text", array())) {
            // line 99
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["groupedFields"] ?? null), "text", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["field"]) {
                // line 100
                echo "    <div class=\"row\">
        <h4><?= __('";
                // line 101
                echo twig_escape_filter($this->env, Cake\Utility\Inflector::humanize($context["field"]), "html", null, true);
                echo "') ?></h4>
        <?= \$this->Text->autoParagraph(h(\$";
                // line 102
                echo twig_escape_filter($this->env, ($context["singularVar"] ?? null), "html", null, true);
                echo "->";
                echo twig_escape_filter($this->env, $context["field"], "html", null, true);
                echo ")); ?>
    </div>
";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['field'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 106
        $context["relations"] = twig_array_merge($this->getAttribute(($context["associations"] ?? null), "BelongsToMany", array()), $this->getAttribute(($context["associations"] ?? null), "HasMany", array()));
        // line 107
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["relations"] ?? null));
        foreach ($context['_seq'] as $context["alias"] => $context["details"]) {
            // line 108
            $context["otherSingularVar"] = Cake\Utility\Inflector::variable($context["alias"]);
            // line 109
            $context["otherPluralHumanName"] = Cake\Utility\Inflector::humanize(Cake\Utility\Inflector::underscore($this->getAttribute($context["details"], "controller", array())));
            // line 110
            echo "    <div class=\"related\">
        <h4><?= __('Related ";
            // line 111
            echo twig_escape_filter($this->env, ($context["otherPluralHumanName"] ?? null), "html", null, true);
            echo "') ?></h4>
        <?php if (!empty(\$";
            // line 112
            echo twig_escape_filter($this->env, ($context["singularVar"] ?? null), "html", null, true);
            echo "->";
            echo twig_escape_filter($this->env, $this->getAttribute($context["details"], "property", array()), "html", null, true);
            echo ")): ?>
        <table cellpadding=\"0\" cellspacing=\"0\">
            <tr>
";
            // line 115
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["details"], "fields", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["field"]) {
                // line 116
                echo "                <th scope=\"col\"><?= __('";
                echo twig_escape_filter($this->env, Cake\Utility\Inflector::humanize($context["field"]), "html", null, true);
                echo "') ?></th>
";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['field'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 118
            echo "                <th scope=\"col\" class=\"actions\"><?= __('Actions') ?></th>
            </tr>
            <?php foreach (\$";
            // line 120
            echo twig_escape_filter($this->env, ($context["singularVar"] ?? null), "html", null, true);
            echo "->";
            echo twig_escape_filter($this->env, $this->getAttribute($context["details"], "property", array()), "html", null, true);
            echo " as \$";
            echo twig_escape_filter($this->env, ($context["otherSingularVar"] ?? null), "html", null, true);
            echo "): ?>
            <tr>
";
            // line 122
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["details"], "fields", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["field"]) {
                // line 123
                echo "                <td><?= h(\$";
                echo twig_escape_filter($this->env, ($context["otherSingularVar"] ?? null), "html", null, true);
                echo "->";
                echo twig_escape_filter($this->env, $context["field"], "html", null, true);
                echo ") ?></td>
";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['field'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 125
            $context["otherPk"] = ((("\$" . ($context["otherSingularVar"] ?? null)) . "->") . $this->getAttribute($this->getAttribute($context["details"], "primaryKey", array()), 0, array(), "array"));
            // line 126
            echo "                <td class=\"actions\">
                    <?= \$this->Html->link(__('View'), ['controller' => '";
            // line 127
            echo twig_escape_filter($this->env, $this->getAttribute($context["details"], "controller", array()), "html", null, true);
            echo "', 'action' => 'view', ";
            echo ($context["otherPk"] ?? null);
            echo "]) ?>
                    <?= \$this->Html->link(__('Edit'), ['controller' => '";
            // line 128
            echo twig_escape_filter($this->env, $this->getAttribute($context["details"], "controller", array()), "html", null, true);
            echo "', 'action' => 'edit', ";
            echo ($context["otherPk"] ?? null);
            echo "]) ?>
                    <?= \$this->Form->postLink(__('Delete'), ['controller' => '";
            // line 129
            echo twig_escape_filter($this->env, $this->getAttribute($context["details"], "controller", array()), "html", null, true);
            echo "', 'action' => 'delete', ";
            echo ($context["otherPk"] ?? null);
            echo "], ['confirm' => __('Are you sure you want to delete # {0}?', ";
            echo ($context["otherPk"] ?? null);
            echo ")]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['alias'], $context['details'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 137
        echo "</div>
";
        
        $__internal_770edd655cdeb606afc443e4edb1f19b4248a91788cb82e88bf8b9495a7c5cfa->leave($__internal_770edd655cdeb606afc443e4edb1f19b4248a91788cb82e88bf8b9495a7c5cfa_prof);

    }

    public function getTemplateName()
    {
        return "C:\\xampp\\htdocs\\celke\\vendor\\cakephp\\bake\\src\\Template\\Bake\\Template\\view.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  428 => 137,  410 => 129,  404 => 128,  398 => 127,  395 => 126,  393 => 125,  382 => 123,  378 => 122,  369 => 120,  365 => 118,  356 => 116,  352 => 115,  344 => 112,  340 => 111,  337 => 110,  335 => 109,  333 => 108,  329 => 107,  327 => 106,  315 => 102,  311 => 101,  308 => 100,  304 => 99,  302 => 98,  299 => 97,  287 => 93,  283 => 92,  280 => 91,  276 => 90,  274 => 89,  262 => 85,  258 => 84,  255 => 83,  251 => 82,  249 => 81,  237 => 77,  233 => 76,  230 => 75,  226 => 74,  224 => 73,  198 => 69,  194 => 68,  191 => 67,  187 => 66,  185 => 65,  172 => 60,  168 => 59,  165 => 58,  143 => 55,  139 => 54,  136 => 53,  134 => 52,  132 => 51,  128 => 50,  126 => 49,  119 => 47,  115 => 46,  111 => 44,  100 => 40,  94 => 39,  87 => 38,  85 => 37,  81 => 36,  77 => 35,  75 => 34,  71 => 33,  67 => 32,  59 => 31,  53 => 30,  48 => 27,  46 => 26,  44 => 25,  42 => 24,  40 => 23,  38 => 22,  30 => 19,  26 => 18,  22 => 16,);
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
<?php
/**
 * @var \\{{ namespace }}\\View\\AppView \$this
 * @var \\{{ entityClass }} \${{ singularVar }}
 */
?>
{% set associations = {'BelongsTo': [], 'HasOne': [], 'HasMany': [], 'BelongsToMany': []}|merge(associations) %}
{% set fieldsData = Bake.getViewFieldsData(fields, schema, associations) %}
{% set associationFields = fieldsData.associationFields %}
{% set groupedFields = fieldsData.groupedFields %}
{% set pK = '\$' ~ singularVar ~ '->' ~ primaryKey[0] %}
<nav class=\"large-3 medium-4 columns\" id=\"actions-sidebar\">
    <ul class=\"side-nav\">
        <li class=\"heading\"><?= __('Actions') ?></li>
        <li><?= \$this->Html->link(__('Edit {{ singularHumanName }}'), ['action' => 'edit', {{ pK|raw }}]) ?> </li>
        <li><?= \$this->Form->postLink(__('Delete {{ singularHumanName }}'), ['action' => 'delete', {{ pK|raw }}], ['confirm' => __('Are you sure you want to delete # {0}?', {{ pK|raw }})]) ?> </li>
        <li><?= \$this->Html->link(__('List {{ pluralHumanName }}'), ['action' => 'index']) ?> </li>
        <li><?= \$this->Html->link(__('New {{ singularHumanName }}'), ['action' => 'add']) ?> </li>
{% set done = [] %}
{% for type, data in associations %}
{% for alias, details in data %}
{% if details.controller is not same as(_view.name) and details.controller not in done %}
        <li><?= \$this->Html->link(__('List {{ alias|underscore|humanize }}'), ['controller' => '{{ details.controller }}', 'action' => 'index']) ?> </li>
        <li><?= \$this->Html->link(__('New {{ alias|underscore|singularize|humanize }}'), ['controller' => '{{ details.controller }}', 'action' => 'add']) ?> </li>
{% set done = done|merge(['controller']) %}
{% endif %}
{% endfor %}
{% endfor %}
    </ul>
</nav>
<div class=\"{{ pluralVar }} view large-9 medium-8 columns content\">
    <h3><?= h(\${{ singularVar }}->{{ displayField }}) ?></h3>
    <table class=\"vertical-table\">
{% if groupedFields['string'] %}
{% for field in groupedFields['string'] %}
{% if associationFields[field] %}
{% set details = associationFields[field] %}
        <tr>
            <th scope=\"row\"><?= __('{{ details.property|humanize }}') ?></th>
            <td><?= \${{ singularVar }}->has('{{ details.property }}') ? \$this->Html->link(\${{ singularVar }}->{{ details.property }}->{{ details.displayField }}, ['controller' => '{{ details.controller }}', 'action' => 'view', \${{ singularVar }}->{{ details.property }}->{{ details.primaryKey[0] }}]) : '' ?></td>
        </tr>
{% else %}
        <tr>
            <th scope=\"row\"><?= __('{{ field|humanize }}') ?></th>
            <td><?= h(\${{ singularVar }}->{{ field }}) ?></td>
        </tr>
{% endif %}
{% endfor %}
{% endif %}
{% if associations.HasOne %}
{% for alias, details in associations.HasOne %}
        <tr>
            <th scope=\"row\"><?= __('{{ alias|underscore|singularize|humanize }}') ?></th>
            <td><?= \${{ singularVar }}->has('{{ details.property }}') ? \$this->Html->link(\${{ singularVar }}->{{ details.property }}->{{ details.displayField }}, ['controller' => '{{ details.controller }}', 'action' => 'view', \${{ singularVar }}->{{ details.property }}->{{ details.primaryKey[0] }}]) : '' ?></td>
        </tr>
{% endfor %}
{% endif %}
{% if groupedFields.number %}
{% for field in groupedFields.number %}
        <tr>
            <th scope=\"row\"><?= __('{{ field|humanize }}') ?></th>
            <td><?= \$this->Number->format(\${{ singularVar }}->{{ field }}) ?></td>
        </tr>
{% endfor %}
{% endif %}
{% if groupedFields.date %}
{% for field in groupedFields.date %}
        <tr>
            <th scope=\"row\"><?= __('{{ field|humanize }}') ?></th>
            <td><?= h(\${{ singularVar }}->{{ field }}) ?></td>
        </tr>
{% endfor %}
{% endif %}
{% if groupedFields.boolean %}
{% for field in groupedFields.boolean %}
        <tr>
            <th scope=\"row\"><?= __('{{ field|humanize }}') ?></th>
            <td><?= \${{ singularVar }}->{{ field }} ? __('Yes') : __('No'); ?></td>
        </tr>
{% endfor %}
{% endif %}
    </table>
{% if groupedFields.text %}
{% for field in groupedFields.text %}
    <div class=\"row\">
        <h4><?= __('{{ field|humanize }}') ?></h4>
        <?= \$this->Text->autoParagraph(h(\${{ singularVar }}->{{ field }})); ?>
    </div>
{% endfor %}
{% endif %}
{% set relations = associations.BelongsToMany|merge(associations.HasMany) %}
{% for alias, details in relations %}
{% set otherSingularVar = alias|variable %}
{% set otherPluralHumanName = details.controller|underscore|humanize %}
    <div class=\"related\">
        <h4><?= __('Related {{ otherPluralHumanName }}') ?></h4>
        <?php if (!empty(\${{ singularVar }}->{{ details.property }})): ?>
        <table cellpadding=\"0\" cellspacing=\"0\">
            <tr>
{% for field in details.fields %}
                <th scope=\"col\"><?= __('{{ field|humanize }}') ?></th>
{% endfor %}
                <th scope=\"col\" class=\"actions\"><?= __('Actions') ?></th>
            </tr>
            <?php foreach (\${{ singularVar }}->{{ details.property }} as \${{ otherSingularVar }}): ?>
            <tr>
{% for field in details.fields %}
                <td><?= h(\${{ otherSingularVar }}->{{ field }}) ?></td>
{% endfor %}
{% set otherPk = '\$' ~ otherSingularVar ~ '->' ~ details.primaryKey[0] %}
                <td class=\"actions\">
                    <?= \$this->Html->link(__('View'), ['controller' => '{{ details.controller }}', 'action' => 'view', {{ otherPk|raw }}]) ?>
                    <?= \$this->Html->link(__('Edit'), ['controller' => '{{ details.controller }}', 'action' => 'edit', {{ otherPk|raw }}]) ?>
                    <?= \$this->Form->postLink(__('Delete'), ['controller' => '{{ details.controller }}', 'action' => 'delete', {{ otherPk|raw }}], ['confirm' => __('Are you sure you want to delete # {0}?', {{ otherPk|raw }})]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
{% endfor %}
</div>
", "C:\\xampp\\htdocs\\celke\\vendor\\cakephp\\bake\\src\\Template\\Bake\\Template\\view.twig", "C:\\xampp\\htdocs\\celke\\vendor\\cakephp\\bake\\src\\Template\\Bake\\Template\\view.twig");
    }
}
