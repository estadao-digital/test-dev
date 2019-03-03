import React, {Component} from 'react';

import classNames from 'classnames';
import uuidv4 from 'uuid/v4';

export default class Botao extends Component {

    handleClick(e) {
        if (typeof this.props.click == 'function')
            this.props.click(e); 
    }

    render() {
        let classeContainer = classNames('containerBotao', (typeof this.props.classeContainer === 'string' ? this.props.classeContainer : ''))
        let classe  = classNames('botao', (typeof this.props.classe === 'string') ? this.props.classe : '');
        let nome    = (typeof this.props.nome === 'string') ? this.props.nome : 'botao';
        let valor   = (typeof this.props.valor === 'string') ? this.props.valor : 'botao';
        let desabilitado = typeof this.props.desabilitado === 'boolean' ? this.props.desabilitado : false;
        return(
            <div className={classeContainer}>
                {
                    desabilitado ?
                        <input type="button" key={uuidv4()} disabled name={nome} value={valor} className={classe} onClick={(e) => this.handleClick(e)} />
                    :
                        <input type="button" key={uuidv4()} name={nome} value={valor} className={classe} onClick={(e) => this.handleClick(e)} />
                }
            </div>
        );
    }
}