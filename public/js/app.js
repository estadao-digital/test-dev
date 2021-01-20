$(function()
{

    new Vue({

        el: '#app',

        data: function()
        {
            return {

                carros: [],
                dados: {},
                erros: {}

            }
        },

        mounted: function()
        {
            this.novo_carro();
            this.carregar_carros();
        },

        methods:
            {
                carregar_carros: function()
                {
                    let Vue = this;

                    $.get('/carros')
                        .done(function(data)
                        {
                            Vue.carros = data;
                        })
                },

                novo_carro: function()
                {
                    this.dados = {
                        id:     0,
                        nome:   '',
                        marca:  '',
                        model:  '',
                        ano:    ''
                    };
                },

                adicionar: function()
                {
                    this.novo_carro();
                    this.erros = {};
                    $(this.$refs.modal).modal('show');
                },

                editar: function(carro)
                {
                    this.erros = {};

                    this.dados.id       = carro.id;
                    this.dados.nome     = carro.nome;
                    this.dados.marca    = carro.marca;
                    this.dados.modelo   = carro.modelo;
                    this.dados.ano      = carro.ano;

                    $(this.$refs.modal).modal('show');
                },

                salvar: function(){

                    let Vue   = this;
                    let dados = this.dados;
                    let post  = false;

                    if(dados.id==0)
                        post = $.post('/carro',dados);
                    else
                        post = $.post('/carro/' + dados.id, $.extend({'_method': 'PUT'}, dados));

                    post.done(function(data)
                    {
                        Vue.carros = data;
                        $(Vue.$refs.modal).modal('hide');
                    });

                    post.fail(function(e)
                    {
                        let erros = {};

                        for(var i in e.responseJSON)
                        {
                            erros[i] = e.responseJSON[i].join('<br>');
                        }

                        Vue.erros = erros;
                    });

                },

                deletar: function(carro)
                {
                    let Vue = this;

                    $.ajax({
                        url: '/carro/' + carro.id,
                        type: 'DELETE',
                        success: function(data)
                        {
                            Vue.carros = data;
                        }
                    });
                }
            }

    });

});
