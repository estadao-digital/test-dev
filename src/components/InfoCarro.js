import React, {Component} from 'react';

export default class InfoCarro extends Component {

    handleClick(e) {
        if (typeof this.props.click == 'function')
            this.props.click(e, this.props.id); 
    }

    render() {
        return(
            <div className="infoCarro" onClick={(e) => this.handleClick(e)}>
                <span>Modelo: {this.props.modelo}</span>
                <span>Marca: {this.props.marca}</span>
                <span>Ano: {this.props.ano}</span>
            </div>
        );
    }
}