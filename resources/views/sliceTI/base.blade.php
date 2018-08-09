
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>teste apenas</title>
</head>
<body>

    <div id="app">
    <router-view></router-view>
    </div>

	<script src="https://unpkg.com/vue/dist/vue.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
	<script src="https://unpkg.com/vue-router"></script>

	<script src="{{$url}}js/home-page-component.js"></script>
	<script src="{{$url}}js/detalhe-component.js"></script>
	<script src="{{$url}}js/routes.js"></script>

	<script>
	var app = new Vue({
			el: '#app',
		router:myRouter,
		data:{
			 id:"2xx"
		}
})
	</script>
</body>

</html>