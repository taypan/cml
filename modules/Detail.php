<?php
class Detail extends Modul{

var $acl = array(	"test" => "guest",
					"get_default" => "guest",
					"test2" => "administrator",
					"nevim" => "administrator");

function get_default(){

return "<img width=\"310px\" height=\"600px\" id=\"imgMain\" />

<div id=\"productInfo\">

<h2>produkt</h2>

</div>

<div class=\"zboziContPrice\">

  <div class=\"popis\">s DPH<strong> 543</strong> Kč</div>

    <div class=\"add\"><a href=\"index.php?page=Feeder&id=84\">Přidat do košíku</a></div>

    </div>

    <h3>nadpis</h3>

    <p>&nbsp;</p>

    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque at libero eget tortor lacinia cursus eget sit amet leo. Curabitur leo magna, ultricies nec varius vel, vehicula pretium sem. Suspendisse potenti. Maecenas eros elit, luctus et vehicula a, interdum at velit. Nullam tincidunt accumsan sollicitudin. Nullam varius vehicula dignissim. Ut varius vulputate ante, volutpat pellentesque magna dictum quis. Aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut iaculis nisi. Etiam eget nulla urna. Sed vitae orci odio, ac dignissim tellus. Cras at eros id leo blandit venenatis.</p>";

}

function get_title(){
return "Detail";
}


}
?>