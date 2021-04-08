import React from 'react'

import Content from 'components/Content'
import ContentHeader from 'components/Content/contentHeader'

export default () => (
    <div>
        <ContentHeader title='Dashboard' small='teste Estadão' />
        <Content>
            <h2>Bem vindo ao meu teste!</h2>
            <p>Olá! Meu nome é <b>Anderson de Souza</b>, é com muito prazer que participo desse teste com vocês, fico feliz pela oportunidade desse desafio.</p>

            <h3>Qual é o desafio?</h3>
            <p>Esse teste consiste em 2 etapas, uma em <b>PHP</b> e outra em <b>Front-End</b> (HTML5, CSS e JavaScript)</p>
        </Content>
    </div>
)