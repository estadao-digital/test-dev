{{-- pegando o layout para o arquivo que está localizado --}}
@extends('estrutura.dashboard')
{{-- utilizando a sessão content do layout --}}
@section('content')
    <div id="home">
        <todos-carros-component></todos-carros-component>
    </div>
@endsection
<script>
    //Importando o component para ser utilizado dentro do layout
    import TodosCarrosComponent from "../js/components/TodosCarrosComponent";

    export default {
        components: {TodosCarrosComponent}
    }
</script>