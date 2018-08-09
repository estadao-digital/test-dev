
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>teste apenas</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="css/estilo.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

</head>
<body>

    <div id="app" class="container">
	  
	       <router-link to="/" class='btn btn-sm btn-success'>home page</router-link>
		   <router-link to="/novo" class='btn btn-sm btn-success'>novo</router-link>
	       <router-view></router-view>
	  	   
    </div>

	<script src="https://unpkg.com/vue/dist/vue.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
	<script src="https://unpkg.com/vue-router"></script>

	<script src="js/home-page-component.js"></script>
	<script src="js/detalhe-component.js"></script>
	<script src="js/novo-component.js"></script>
	<script src="js/delete-component.js"></script>
	<script src="js/routes.js"></script>

	<script>
	var app = new Vue({
			el: '#app',
		router:myRouter,
		data:{
			 id:''
		}
    })
	</script>
</body>

</html>