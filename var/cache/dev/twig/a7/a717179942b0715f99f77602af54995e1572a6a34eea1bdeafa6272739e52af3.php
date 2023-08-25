<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* invoice/invoiceTicket.html.twig */
class __TwigTemplate_c1bb99a61d14116051c1a77abeddcfc2b9403af46565476d6113448c70ed7f35 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "invoice/invoiceTicket.html.twig"));

        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
    

    <style>
        body{
            background: #f1f0f5;
        }
        .page-core{
            width: 100%;
            margin: auto;
            max-width: 500px;
            /*border: 1px solid rgb(60,66,87);*/
            padding: 50px;
            padding-top: 25px;
            padding-bottom: 25px;
            background: #fff;
        }
        .page-core p{
            margin-top: 5px;
            margin-bottom: 5px;
        }
        .flex{
            display: flex;
        }
        .titre-ticket{
            display: flex; 
            justify-content: center;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .date-ticket{
            justify-content: space-between;
        }
        .list-ticket li{
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .list-ticket li span {
            width: 100px;
            display: flex;
            justify-content: end;
        }
        
        .ticket-footer{
            display: flex; 
            flex-direction: column;
            text-align: center;
        }
        .total-ticket{
            display: flex; 
            justify-content: end;
            flex-direction: column;
            align-items: end;
        }
        .align-right{
            text-align: right;
        }
        .align-left{
            text-align: left;
        }
        table{
            width: 100%;
        }
        table,td,th,tr{
            border-collapse: collapse;
            border: 1px solid #000;
        }
        th{
            text-align: center;
            padding: 2px;
        }
        td {
            text-align: center;
            padding: 2px;
        }
        .question{
            text-align: center;
        }
    </style>
    </head>
    <body>
        <div class=\"page-core\">
            <div class=\"titre-ticket\">
                <h2>B.A.D.G.E Département Natoraly Fish</h2>
            </div>
            <div class=\"align-left\">
                <p>ADRESSE : Lot VT 68M Andohanimandroseza, Antananarivo 101</p>
                <p>TELEPHONE : <strong>034 46 900 00</strong> - <strong>098 98 982 47</strong></p>
            </div>
            <div class=\"date-ticket flex\">
                <div class=\"left-col\">
                    <p>POINT DE VENTE : ";
        // line 96
        echo twig_escape_filter($this->env, (isset($context["pointOfSale"]) || array_key_exists("pointOfSale", $context) ? $context["pointOfSale"] : (function () { throw new RuntimeError('Variable "pointOfSale" does not exist.', 96, $this->source); })()), "html", null, true);
        echo "</p>
                    <p>DATE : ";
        // line 97
        echo twig_escape_filter($this->env, (isset($context["date"]) || array_key_exists("date", $context) ? $context["date"] : (function () { throw new RuntimeError('Variable "date" does not exist.', 97, $this->source); })()), "html", null, true);
        echo " </p>
                </div>
                
            </div>
            <div class=\"right-col\">
                <p class=\"align-right\">TICKET : ";
        // line 102
        echo twig_escape_filter($this->env, (isset($context["reference"]) || array_key_exists("reference", $context) ? $context["reference"] : (function () { throw new RuntimeError('Variable "reference" does not exist.', 102, $this->source); })()), "html", null, true);
        echo "</p>
                <br/>
            </div>

            <div class=\"list-ticket\">
                <table>
                    <thead>
                        <th>DESIGNATION</th>
                        <th>QUANTITE</th>
                        <th>P.U</th>
                        <th>MONTANT</th> 
                    </thead>
                    <tbody>
                    ";
        // line 115
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["articles"]) || array_key_exists("articles", $context) ? $context["articles"] : (function () { throw new RuntimeError('Variable "articles" does not exist.', 115, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 116
            echo "                        <tr class=\"\">
                            <td>";
            // line 117
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["item"], "name", [], "any", false, false, false, 117), "html", null, true);
            echo "</td>
                            <td>";
            // line 118
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["item"], "quantity", [], "any", false, false, false, 118), "html", null, true);
            echo "</td>
                            <td>";
            // line 119
            echo twig_escape_filter($this->env, twig_number_format_filter($this->env, twig_get_attribute($this->env, $this->source, $context["item"], "unit_price", [], "any", false, false, false, 119), 3, ",", " "), "html", null, true);
            echo "</td>
                            <td>";
            // line 120
            echo twig_escape_filter($this->env, twig_number_format_filter($this->env, twig_get_attribute($this->env, $this->source, $context["item"], "amount", [], "any", false, false, false, 120), 3, ",", " "), "html", null, true);
            echo "</td>
                        </tr>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 123
        echo "                        <tr>
                            <td colspan=\"3\"><strong>TOTAL</strong></td> 
                            <td><strong>";
        // line 125
        echo twig_escape_filter($this->env, twig_number_format_filter($this->env, (isset($context["total"]) || array_key_exists("total", $context) ? $context["total"] : (function () { throw new RuntimeError('Variable "total" does not exist.', 125, $this->source); })()), 3, ",", " "), "html", null, true);
        echo "</strong></td>
                        </tr>
                    </tbody>
                </table> 
            </div>
           
            <div class=\"ticket-footer\">
                <h2>B.A.D.G.E</h2>
                <p><strong>VOUS REMERCIE DE VOTRE VISITE</strong></p>
            </div>

            <p class=\"question\">Si vous-avez des questions sur ce ticket, n'hésitez pas à nous contacter.\t</p>
        </div>
    </body>
</html>";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "invoice/invoiceTicket.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  197 => 125,  193 => 123,  184 => 120,  180 => 119,  176 => 118,  172 => 117,  169 => 116,  165 => 115,  149 => 102,  141 => 97,  137 => 96,  40 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!DOCTYPE html>
<html>
    <head>
    

    <style>
        body{
            background: #f1f0f5;
        }
        .page-core{
            width: 100%;
            margin: auto;
            max-width: 500px;
            /*border: 1px solid rgb(60,66,87);*/
            padding: 50px;
            padding-top: 25px;
            padding-bottom: 25px;
            background: #fff;
        }
        .page-core p{
            margin-top: 5px;
            margin-bottom: 5px;
        }
        .flex{
            display: flex;
        }
        .titre-ticket{
            display: flex; 
            justify-content: center;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .date-ticket{
            justify-content: space-between;
        }
        .list-ticket li{
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .list-ticket li span {
            width: 100px;
            display: flex;
            justify-content: end;
        }
        
        .ticket-footer{
            display: flex; 
            flex-direction: column;
            text-align: center;
        }
        .total-ticket{
            display: flex; 
            justify-content: end;
            flex-direction: column;
            align-items: end;
        }
        .align-right{
            text-align: right;
        }
        .align-left{
            text-align: left;
        }
        table{
            width: 100%;
        }
        table,td,th,tr{
            border-collapse: collapse;
            border: 1px solid #000;
        }
        th{
            text-align: center;
            padding: 2px;
        }
        td {
            text-align: center;
            padding: 2px;
        }
        .question{
            text-align: center;
        }
    </style>
    </head>
    <body>
        <div class=\"page-core\">
            <div class=\"titre-ticket\">
                <h2>B.A.D.G.E Département Natoraly Fish</h2>
            </div>
            <div class=\"align-left\">
                <p>ADRESSE : Lot VT 68M Andohanimandroseza, Antananarivo 101</p>
                <p>TELEPHONE : <strong>034 46 900 00</strong> - <strong>098 98 982 47</strong></p>
            </div>
            <div class=\"date-ticket flex\">
                <div class=\"left-col\">
                    <p>POINT DE VENTE : {{pointOfSale}}</p>
                    <p>DATE : {{date}} </p>
                </div>
                
            </div>
            <div class=\"right-col\">
                <p class=\"align-right\">TICKET : {{reference}}</p>
                <br/>
            </div>

            <div class=\"list-ticket\">
                <table>
                    <thead>
                        <th>DESIGNATION</th>
                        <th>QUANTITE</th>
                        <th>P.U</th>
                        <th>MONTANT</th> 
                    </thead>
                    <tbody>
                    {% for item in articles %}
                        <tr class=\"\">
                            <td>{{item.name }}</td>
                            <td>{{item.quantity }}</td>
                            <td>{{item.unit_price | number_format(3, ',', ' ')}}</td>
                            <td>{{item.amount | number_format(3, ',', ' ')}}</td>
                        </tr>
                    {% endfor %}
                        <tr>
                            <td colspan=\"3\"><strong>TOTAL</strong></td> 
                            <td><strong>{{ total | number_format(3, ',', ' ')}}</strong></td>
                        </tr>
                    </tbody>
                </table> 
            </div>
           
            <div class=\"ticket-footer\">
                <h2>B.A.D.G.E</h2>
                <p><strong>VOUS REMERCIE DE VOTRE VISITE</strong></p>
            </div>

            <p class=\"question\">Si vous-avez des questions sur ce ticket, n'hésitez pas à nous contacter.\t</p>
        </div>
    </body>
</html>", "invoice/invoiceTicket.html.twig", "D:\\Projet trav\\makee-back\\templates\\invoice\\invoiceTicket.html.twig");
    }
}
