import React from 'react'

import Content from 'components/Content'
import ContentHeader from 'components/Content/contentHeader'

export default () => (
    <div>
        <ContentHeader title='Dashboard' small='teste Estadão' />
        <Content>
            <img src="https://assine.estadao.com.br/assets/assine/logo-estadao-cavalo.svg" />
            <h2>Seja bem-vindo ao meu teste!</h2>
            <p>
                Olá, meu nome é <b>Anderson de Souza</b>! É com imenso prazer que participo desse teste com vocês e desde já agradeço a oportunidade que me foi concedida para realizar esse desafio.
                Estou muito entusiasmado com a possibilidade de me juntar à empresa e de poder dar a minha contribuição.
            </p>

            <h3>Qual é o desafio?</h3>
            
            <p>
                Esse teste foi concretizado em 2 etapas, sendo a primeira em <b>PHP</b> e segunda em <b>Front-End (HTML5, CSS e JavaScript)</b>.
            </p>
        </Content>
    </div>
)