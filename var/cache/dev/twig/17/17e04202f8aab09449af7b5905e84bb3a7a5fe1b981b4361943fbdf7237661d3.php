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

/* invoice/invoiceFacture.html.twig */
class __TwigTemplate_743ef328fc8409b299466e9587467328e95455fea1c2428f41c1a24a658bba4c extends Template
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
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "invoice/invoiceFacture.html.twig"));

        // line 1
        echo "<!DOCTYPE html>
<html>
\t<head>
\t\t<style>
\t\t\t.body {
\t\t\t\tfont-size: 16px;
                display: flex;
                 margin: auto;
\t\t\t}

\t\t\t.container {
\t\t\t\t
                 position: relative;
                margin: auto;
                padding:0;
\t\t\t}
            .reference {
\t\t\t\tposition: absolute;
                top : 150px;
                left: 20px;
\t\t\t}

            .designation {
\t\t\t\tposition: absolute;
                top : 280px;
                left: 20px;
\t\t\t}
\t\t\t.left {
\t\t\t\tfloat: left;
\t\t\t}
\t\t\t.right {
\t\t\t\tfloat: right;
\t\t\t\tmargin-left: 90px;

\t\t\t}
            .center {
                text-align: center;
            }
            .column{
                border: 1px solid #000;
            }
            .remarque-wrap{
                position: absolute;
                top : 600px;
                left: 20px;
                text-align: center;
            }
            .remarque{
                margin-top: 10px;
                width: 300px;
                background-color:#f2f5f7;
                border: 1px solid #000;
            }
            .mode-paiement{
                background: var(--mode-paiement);
                padding: 10px;
                text-align: justify;
                margin-top: -10px;
            }
            .bold{
                font-weight: bold;
            }

             .signature {
\t\t\t\tmargin-top : 20px;
                left: 550px;
\t\t\t}
           
\t\t</style>
\t</head>
\t<body>

\t\t<div class=\"container\">
\t\t\t<table>
       
             <thead>
              <th>B.A.D.G.E Département Natoraly Fish
               </th>
               <th>
               </th>
             <thead>
\t\t\t\t<tr>
\t\t\t\t\t<td>
\t\t\t\t\t\t<div class=\"address left\">
\t\t\t\t\t
\t\t\t\t\t\t\t<span>Lot VT 68 M Andohanimandroseza, </span>
\t\t\t\t\t\t\t<span>Antananarivo 101</span>
\t\t\t\t\t\t\t<div class=\"container\">
\t\t\t\t\t\t\t\t<div> 
\t\t\t\t\t\t\t\t\t<span>034 46 900 00 - </span>
\t\t\t\t\t\t\t\t\t<span>038 98 982 47 - </span>
\t\t\t\t\t\t\t\t\t<span>034 51 435 45 </span>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</td>
\t\t\t\t\t</td>

\t\t\t\t\t<td class=\"right\">
\t\t\t\t\t\t<div class=\"right\">
\t\t\t\t\t\t\t<span>Client : ";
        // line 100
        echo twig_escape_filter($this->env, (isset($context["customer"]) || array_key_exists("customer", $context) ? $context["customer"] : (function () { throw new RuntimeError('Variable "customer" does not exist.', 100, $this->source); })()), "html", null, true);
        echo "</span></br>
\t\t\t\t\t\t\t<span>Adresse : ";
        // line 101
        echo twig_escape_filter($this->env, (isset($context["adresse"]) || array_key_exists("adresse", $context) ? $context["adresse"] : (function () { throw new RuntimeError('Variable "adresse" does not exist.', 101, $this->source); })()), "html", null, true);
        echo "</span></br>
                            <span>Contact : ";
        // line 102
        echo twig_escape_filter($this->env, (isset($context["contact"]) || array_key_exists("contact", $context) ? $context["contact"] : (function () { throw new RuntimeError('Variable "contact" does not exist.', 102, $this->source); })()), "html", null, true);
        echo "</span></br>
\t\t\t\t\t\t\t<span>NIF : ";
        // line 103
        echo twig_escape_filter($this->env, (isset($context["nif"]) || array_key_exists("nif", $context) ? $context["nif"] : (function () { throw new RuntimeError('Variable "nif" does not exist.', 103, $this->source); })()), "html", null, true);
        echo "</span></br>
\t\t\t\t\t\t\t<span>RCS : ";
        // line 104
        echo twig_escape_filter($this->env, (isset($context["stat"]) || array_key_exists("stat", $context) ? $context["stat"] : (function () { throw new RuntimeError('Variable "stat" does not exist.', 104, $this->source); })()), "html", null, true);
        echo "</span></br>
\t\t\t\t\t\t</div>
\t\t\t\t\t</td>
\t\t\t\t</tr>
\t\t\t</table>

            <div class=\"reference\">
                <span> DATE : ";
        // line 111
        echo twig_escape_filter($this->env, (isset($context["date"]) || array_key_exists("date", $context) ? $context["date"] : (function () { throw new RuntimeError('Variable "date" does not exist.', 111, $this->source); })()), "html", null, true);
        echo "</span><br/>
                <span> POINT DE VENTE : ";
        // line 112
        echo twig_escape_filter($this->env, (isset($context["pointOfSale"]) || array_key_exists("pointOfSale", $context) ? $context["pointOfSale"] : (function () { throw new RuntimeError('Variable "pointOfSale" does not exist.', 112, $this->source); })()), "html", null, true);
        echo "</span><br/>
                <span> FACTURE : ";
        // line 113
        echo twig_escape_filter($this->env, (isset($context["reference"]) || array_key_exists("reference", $context) ? $context["reference"] : (function () { throw new RuntimeError('Variable "reference" does not exist.', 113, $this->source); })()), "html", null, true);
        echo "</span>
            </div>

            <div class=\"designation\">
                <table style=\" border-collapse: collapse;
                border: 1px solid #000; width:100%;\" >
                <colgroup>
        <col span=\"1\" style=\"width: 40%;\">
        <col span=\"1\" style=\"width: 20%;\">
        <col span=\"1\" style=\"width: 20%;\">
        <col span=\"1\" style=\"width: 20%;\">
      </colgroup>
                    <thead>
                        <tr>
                            <th class=\"column\" style=\"width:300px; background-color:#5d7079; color: white;\">Description</th>
                            <th class=\"column\" style=\"width:100px; background-color:#5d7079; color: white;\">Quantité (kg)</th>
                            <th class=\"column\" style=\"width:100px; background-color:#5d7079; color: white;\">Prix unitaire</th>
                            <th class=\"column\" style=\"width:100px; background-color:#5d7079; color: white;\">Prix Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        ";
        // line 134
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["articles"]) || array_key_exists("articles", $context) ? $context["articles"] : (function () { throw new RuntimeError('Variable "articles" does not exist.', 134, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 135
            echo "                        <tr class=\"\">
                            <td class=\"column center\">";
            // line 136
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["item"], "name", [], "any", false, false, false, 136), "html", null, true);
            echo "</td>
                            <td class=\"column center\">";
            // line 137
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["item"], "quantity", [], "any", false, false, false, 137), "html", null, true);
            echo "</td>
                            <td class=\"column center\">";
            // line 138
            echo twig_escape_filter($this->env, twig_number_format_filter($this->env, twig_get_attribute($this->env, $this->source, $context["item"], "unit_price", [], "any", false, false, false, 138), 3, ",", " "), "html", null, true);
            echo "</td>
                            <td class=\"column center\">";
            // line 139
            echo twig_escape_filter($this->env, twig_number_format_filter($this->env, twig_get_attribute($this->env, $this->source, $context["item"], "amount", [], "any", false, false, false, 139), 3, ",", " "), "html", null, true);
            echo "</td>
                        </tr>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 142
        echo "                    ";
        if ((0 !== twig_compare((isset($context["remise"]) || array_key_exists("remise", $context) ? $context["remise"] : (function () { throw new RuntimeError('Variable "remise" does not exist.', 142, $this->source); })()), 0))) {
            // line 143
            echo "                         <tr>
                                <td></td>
                                <td></td>
                                <td class=\"column center bold\"> Sous-total</td>
                                <td class=\"column center\">";
            // line 147
            echo twig_escape_filter($this->env, twig_number_format_filter($this->env, (isset($context["total"]) || array_key_exists("total", $context) ? $context["total"] : (function () { throw new RuntimeError('Variable "total" does not exist.', 147, $this->source); })()), 3, ",", " "), "html", null, true);
            echo "</td>
                        </tr>
                         <tr>
                                <td></td>
                                <td></td>
                                <td class=\"column center bold\"> Remise</td>
                                <td class=\"column center\">0</td>
                        </tr>
                    ";
        }
        // line 156
        echo "                       
                         <tr>
                          <td></td>
                            <td></td>
                            <td class=\"column center bold\"> Total à payer</td>
                            <td class=\"column center\">";
        // line 161
        echo twig_escape_filter($this->env, twig_number_format_filter($this->env, (isset($context["total"]) || array_key_exists("total", $context) ? $context["total"] : (function () { throw new RuntimeError('Variable "total" does not exist.', 161, $this->source); })()), 3, ",", " "), "html", null, true);
        echo "</td>
                           
                        </tr>
                        ";
        // line 164
        if ((1 === twig_compare((isset($context["paymentReceived"]) || array_key_exists("paymentReceived", $context) ? $context["paymentReceived"] : (function () { throw new RuntimeError('Variable "paymentReceived" does not exist.', 164, $this->source); })()), 0))) {
            // line 165
            echo "                             <tr>
                                    <td></td>
                                    <td></td>
                                    <td class=\"column center bold\"> Montant payé</td>
                                    <td class=\"column center\">";
            // line 169
            echo twig_escape_filter($this->env, twig_number_format_filter($this->env, (isset($context["paymentReceived"]) || array_key_exists("paymentReceived", $context) ? $context["paymentReceived"] : (function () { throw new RuntimeError('Variable "paymentReceived" does not exist.', 169, $this->source); })()), 3, ",", " "), "html", null, true);
            echo "</td>
                            </tr>
                        ";
        }
        // line 172
        echo "
                        ";
        // line 173
        if (((1 === twig_compare((isset($context["leftToPay"]) || array_key_exists("leftToPay", $context) ? $context["leftToPay"] : (function () { throw new RuntimeError('Variable "leftToPay" does not exist.', 173, $this->source); })()), 0)) && (0 !== twig_compare((isset($context["leftToPay"]) || array_key_exists("leftToPay", $context) ? $context["leftToPay"] : (function () { throw new RuntimeError('Variable "leftToPay" does not exist.', 173, $this->source); })()), (isset($context["total"]) || array_key_exists("total", $context) ? $context["total"] : (function () { throw new RuntimeError('Variable "total" does not exist.', 173, $this->source); })()))))) {
            // line 174
            echo "                             <tr>
                                    <td></td>
                                    <td></td>
                                    <td class=\"column center bold\"> Reste à payer</td>
                                    <td class=\"column center\">";
            // line 178
            echo twig_escape_filter($this->env, twig_number_format_filter($this->env, (isset($context["leftToPay"]) || array_key_exists("leftToPay", $context) ? $context["leftToPay"] : (function () { throw new RuntimeError('Variable "leftToPay" does not exist.', 178, $this->source); })()), 3, ",", " "), "html", null, true);
            echo "</td>
                            </tr>
                        ";
        }
        // line 181
        echo "                       
                    </tbody>
                </table>
                    <div class=\"remarque\">
                        <span style=\"background-color:#5d7079; padding : 5px; color: white;\">Remarques et instructions de paiement :</span>
                        <i style=\"background-color:#f2f5f7;\"></br>
                            Le mode de paiement est par chèque
                            bancaire ou virement bancaire au compte
                            BFV-SG (TOGNONAVELO Alexandre)
                            n° 00008 00005 05003020222 68
                        <i>
                    </div>

                    <div class=\"signature left\">
                        <i> Responsable Facturation</i>
                    </div>
                </div>
        
         <div class=\"remarque-wrap\">
        
        <div class=\"questions\">
            <p>Si vous avez des questions sur cette facture, n'hésitez pas à nous contacter.</p>
        </div>
     </div>
\t\t</div>

\t\t
\t</body>
</html>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "invoice/invoiceFacture.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  292 => 181,  286 => 178,  280 => 174,  278 => 173,  275 => 172,  269 => 169,  263 => 165,  261 => 164,  255 => 161,  248 => 156,  236 => 147,  230 => 143,  227 => 142,  218 => 139,  214 => 138,  210 => 137,  206 => 136,  203 => 135,  199 => 134,  175 => 113,  171 => 112,  167 => 111,  157 => 104,  153 => 103,  149 => 102,  145 => 101,  141 => 100,  40 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!DOCTYPE html>
<html>
\t<head>
\t\t<style>
\t\t\t.body {
\t\t\t\tfont-size: 16px;
                display: flex;
                 margin: auto;
\t\t\t}

\t\t\t.container {
\t\t\t\t
                 position: relative;
                margin: auto;
                padding:0;
\t\t\t}
            .reference {
\t\t\t\tposition: absolute;
                top : 150px;
                left: 20px;
\t\t\t}

            .designation {
\t\t\t\tposition: absolute;
                top : 280px;
                left: 20px;
\t\t\t}
\t\t\t.left {
\t\t\t\tfloat: left;
\t\t\t}
\t\t\t.right {
\t\t\t\tfloat: right;
\t\t\t\tmargin-left: 90px;

\t\t\t}
            .center {
                text-align: center;
            }
            .column{
                border: 1px solid #000;
            }
            .remarque-wrap{
                position: absolute;
                top : 600px;
                left: 20px;
                text-align: center;
            }
            .remarque{
                margin-top: 10px;
                width: 300px;
                background-color:#f2f5f7;
                border: 1px solid #000;
            }
            .mode-paiement{
                background: var(--mode-paiement);
                padding: 10px;
                text-align: justify;
                margin-top: -10px;
            }
            .bold{
                font-weight: bold;
            }

             .signature {
\t\t\t\tmargin-top : 20px;
                left: 550px;
\t\t\t}
           
\t\t</style>
\t</head>
\t<body>

\t\t<div class=\"container\">
\t\t\t<table>
       
             <thead>
              <th>B.A.D.G.E Département Natoraly Fish
               </th>
               <th>
               </th>
             <thead>
\t\t\t\t<tr>
\t\t\t\t\t<td>
\t\t\t\t\t\t<div class=\"address left\">
\t\t\t\t\t
\t\t\t\t\t\t\t<span>Lot VT 68 M Andohanimandroseza, </span>
\t\t\t\t\t\t\t<span>Antananarivo 101</span>
\t\t\t\t\t\t\t<div class=\"container\">
\t\t\t\t\t\t\t\t<div> 
\t\t\t\t\t\t\t\t\t<span>034 46 900 00 - </span>
\t\t\t\t\t\t\t\t\t<span>038 98 982 47 - </span>
\t\t\t\t\t\t\t\t\t<span>034 51 435 45 </span>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</td>
\t\t\t\t\t</td>

\t\t\t\t\t<td class=\"right\">
\t\t\t\t\t\t<div class=\"right\">
\t\t\t\t\t\t\t<span>Client : {{customer}}</span></br>
\t\t\t\t\t\t\t<span>Adresse : {{adresse}}</span></br>
                            <span>Contact : {{contact}}</span></br>
\t\t\t\t\t\t\t<span>NIF : {{nif}}</span></br>
\t\t\t\t\t\t\t<span>RCS : {{stat}}</span></br>
\t\t\t\t\t\t</div>
\t\t\t\t\t</td>
\t\t\t\t</tr>
\t\t\t</table>

            <div class=\"reference\">
                <span> DATE : {{date}}</span><br/>
                <span> POINT DE VENTE : {{pointOfSale}}</span><br/>
                <span> FACTURE : {{reference}}</span>
            </div>

            <div class=\"designation\">
                <table style=\" border-collapse: collapse;
                border: 1px solid #000; width:100%;\" >
                <colgroup>
        <col span=\"1\" style=\"width: 40%;\">
        <col span=\"1\" style=\"width: 20%;\">
        <col span=\"1\" style=\"width: 20%;\">
        <col span=\"1\" style=\"width: 20%;\">
      </colgroup>
                    <thead>
                        <tr>
                            <th class=\"column\" style=\"width:300px; background-color:#5d7079; color: white;\">Description</th>
                            <th class=\"column\" style=\"width:100px; background-color:#5d7079; color: white;\">Quantité (kg)</th>
                            <th class=\"column\" style=\"width:100px; background-color:#5d7079; color: white;\">Prix unitaire</th>
                            <th class=\"column\" style=\"width:100px; background-color:#5d7079; color: white;\">Prix Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for item in articles %}
                        <tr class=\"\">
                            <td class=\"column center\">{{item.name }}</td>
                            <td class=\"column center\">{{item.quantity }}</td>
                            <td class=\"column center\">{{item.unit_price | number_format(3, ',', ' ')}}</td>
                            <td class=\"column center\">{{item.amount | number_format(3, ',', ' ')}}</td>
                        </tr>
                    {% endfor %}
                    {% if remise != 0 %}
                         <tr>
                                <td></td>
                                <td></td>
                                <td class=\"column center bold\"> Sous-total</td>
                                <td class=\"column center\">{{ total | number_format(3, ',', ' ')}}</td>
                        </tr>
                         <tr>
                                <td></td>
                                <td></td>
                                <td class=\"column center bold\"> Remise</td>
                                <td class=\"column center\">0</td>
                        </tr>
                    {% endif %}
                       
                         <tr>
                          <td></td>
                            <td></td>
                            <td class=\"column center bold\"> Total à payer</td>
                            <td class=\"column center\">{{ total | number_format(3, ',', ' ')}}</td>
                           
                        </tr>
                        {% if paymentReceived > 0 %}
                             <tr>
                                    <td></td>
                                    <td></td>
                                    <td class=\"column center bold\"> Montant payé</td>
                                    <td class=\"column center\">{{ paymentReceived | number_format(3, ',', ' ')}}</td>
                            </tr>
                        {% endif %}

                        {% if leftToPay > 0 and leftToPay !=  total %}
                             <tr>
                                    <td></td>
                                    <td></td>
                                    <td class=\"column center bold\"> Reste à payer</td>
                                    <td class=\"column center\">{{ leftToPay | number_format(3, ',', ' ')}}</td>
                            </tr>
                        {% endif %}
                       
                    </tbody>
                </table>
                    <div class=\"remarque\">
                        <span style=\"background-color:#5d7079; padding : 5px; color: white;\">Remarques et instructions de paiement :</span>
                        <i style=\"background-color:#f2f5f7;\"></br>
                            Le mode de paiement est par chèque
                            bancaire ou virement bancaire au compte
                            BFV-SG (TOGNONAVELO Alexandre)
                            n° 00008 00005 05003020222 68
                        <i>
                    </div>

                    <div class=\"signature left\">
                        <i> Responsable Facturation</i>
                    </div>
                </div>
        
         <div class=\"remarque-wrap\">
        
        <div class=\"questions\">
            <p>Si vous avez des questions sur cette facture, n'hésitez pas à nous contacter.</p>
        </div>
     </div>
\t\t</div>

\t\t
\t</body>
</html>
", "invoice/invoiceFacture.html.twig", "D:\\Projet trav\\makee-back\\templates\\invoice\\invoiceFacture.html.twig");
    }
}
