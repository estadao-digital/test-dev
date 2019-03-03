// Importação de Módulos 
import React, {Component} from "react";

import axios from 'axios';
import uuidv4 from 'uuid/v4';

import InfoCarro from './components/InfoCarro';
import Botao from './components/Botao';

import '../css/main.scss';

class App extends React.Component {
    formRef;
    inputModeloRef;

    constructor(props){
        super(props);

        this.state = {
            exibirForm: false,
            novoCadastro: false,
            modelo: '',
            marca: '',
            ano: '',
            carros: []
        }

        this.formRef = React.createRef();
        this.inputModeloRef = React.createRef();

        this.handleClickNovo = this.handleClickNovo.bind(this);
        this.handleClickCadastrar = this.handleClickCadastrar.bind(this);
        this.handleChangeInput = this.handleChangeInput.bind(this);
        this.handleClickSave = this.handleClickSave.bind(this);
        this.handleClickEditar = this.handleClickEditar.bind(this);
        this.handleClickDelete = this.handleClickDelete.bind(this);

        this.getCarros();
    }


    getCarros(id){
        let url = '';
        if(id){
            url = `http://localhost:8080/estadao/api.php?path=carros/${id}`;
        }else{
            url = `http://localhost:8080/estadao/api.php?path=carros`;
        }
        axios.get(url)
            .then(res => {
                let data = [];
                data = res.data['carros'];
                if(data.length >= 1){
                    this.setState({
                        carros: data
                    });
                }else{
                    this.setState({
                        exibirForm: true,
                        novoCadastro: false,
                        modelo: data.modelo,
                        marca: data.marca,
                        ano: data.ano
                    }, () => {
                        this.inputModeloRef.current.focus();
                    });
                }
            })
            .catch(error => {
                console.error(error);
            });
    }

    handleClickNovo(e) {
        this.setState({
            exibirForm: true,
            novoCadastro: true
        }, () => {
            this.inputModeloRef.current.focus();
        });
    }

    handleClickCadastrar(e) {
        dataCarro = '';
        axios.post(`http://localhost:8080/estadao/api.php?path=carros`, {dataCarro})
            .then(res => {
                console.log(res);
                if (res.status === 200) {
                    this.setState({
                        exibirForm: false
                    });
                }
            })
            .catch(error => {
                console.error(error);
            });
    }

    handleClickSave(e, id) {
        dataCarro = '';
        axios.put(`http://localhost:8080/estadao/api.php?path=carros/${id}`, {dataCarro})
            .then(res => {
                console.log(res);
                if (res.status === 200) {
                    this.setState({
                        exibirForm: false
                    });
                }
            })
            .catch(error => {
                console.error(error);
            });
    }

    handleClickEditar(e, id) {
        this.getCarros(id);
    }

    handleClickDelete(e, id) {
        axios.delete(`http://localhost:8080/estadao/api.php?path=carros/${id}`)
            .then(res => {
                if (res.status === 200) {
                    this.setState({
                        exibirForm: false,
                        novoCadastro: false,
                        modelo: '',
                        marca: '',
                        ano: ''
                    });
                } 
            })
            .catch(err => {
                console.error(err);
            });
    }

    handleChangeInput(e) {
        let partialState = {};
        partialState = this.state;
        partialState[e.target.name] = e.target.value;

        this.setState(partialState);
    }

    render() {
        return (
            <div className="caixaPrincipal">
                <header>
                    <div className="caixaBotaoNovo">
                        <Botao
                            classeContainer='containerBotaoNovo'
                            classe='botaoNovo' 
                            nome='botaoNovo' 
                            valor='Novo' 
                            click={(e) => this.handleClickNovo(e)}
                            />
                    </div>
                    Carros
                </header>
                <main>
                    { !this.state.exibirForm &&
                        <div className="listaCarros">
                            {this.state.carros.map((carro) => {
                                return <InfoCarro key={uuidv4()} {...carro}
                                                click={this.handleClickEditar} />;
                            })
                            }
                        </div>
                    }
                    { this.state.exibirForm &&
                        <div className="formCarros">
                            <form ref={this.formRef} className="formularioDetalhe">
                                <input ref={this.inputModeloRef} type='text' name='modelo' placeholder="modelo" value={this.state.modelo} className='input inputModelo' onChange={(e) => this.handleChangeInput(e)} />
                                <input type='text' name='marca' placeholder="marca" value={this.state.marca} className='input inputMarca' onChange={(e) => this.handleChangeInput(e)} />
                                <input type='number' name='ano' placeholder="ano" value={this.state.ano} className='input inputAno' onChange={(e) => this.handleChangeInput(e)} />
                                { this.state.novoCadastro &&
                                    <Botao
                                        classeContainer='containerBotaoSalvar'
                                        classe='botaoSalvar' 
                                        nome='botaoSalvar' 
                                        valor='Salvar' 
                                        click={(e) => this.handleClickCadastrar(e)}
                                        />
                                }
                                { !this.state.novoCadastro &&
                                    <div>
                                        <Botao
                                            classeContainer='containerBotaoSalvar'
                                            classe='botaoSalvar' 
                                            nome='botaoSalvar' 
                                            valor='Salvar' 
                                            click={(e) => this.handleClickSave(e)}
                                            />
                                        <Botao
                                            classeContainer='containerBotaoExcluir'
                                            classe='botaoExcluir' 
                                            nome='botaoExcluir' 
                                            valor='Excluir' 
                                            click={(e) => this.handleClickDelete(e)}
                                            />
                                    </div>
                                }
                            </form>
                        </div>
                    }
                </main>
            </div>
        );
    }
}

export default App;
