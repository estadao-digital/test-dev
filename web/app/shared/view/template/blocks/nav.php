<style>
	<?
	require_once('/www/lws2012/core/util/rede-segura/css/serviceMenu.css');
	?>
</style>
<script>
	<?
	//require_once('/www/lws2012/core/util/global/js/jquery.menu.js');
	require_once('/www/lws2012/includes/funcoes/plugins/menuTriggers.js');
	?>
	$(document).on("click",".companyReference",	function()
	{
		$('#selectChooseCompany').slideToggle();
		$('.searchCompany').slideToggle();
		setItemSelected(customer_id);
		$("#companySearch").focus();
	});
	function setItemSelected(customerID)
	{
		var _object       = $("a.unitChoice[value='"+customerID+"']");

		if ( typeof(_object.offset()) !== "undefined" )
		{
			$("#selectChooseCompany").__scrollTo(_object,250);

			$(_object).attr('href','###');
			$(_object).attr('value','0');
			$(_object).css({'font-weight': 'bold','background': '#483838'});
		}
	}
</script>
<ul class="nav" ng-controller="MenuCtrl as vm">
<?
$wafRequest = true;
require_once('/www/lws2012/includes/globalConfig.php');
require_once('/www/lws2012/includes/funcoes/basic.php');
require_once('/www/lws2012/includes/funcoes/plugins/menuController.php');
echo '<script>';
require_once('/www/lws2012/includes/funcoes/plugins/menuTriggers.js');
echo '</script>';
?>
</ul>