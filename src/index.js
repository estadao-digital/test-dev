// Importação de Módulos 
import React, {Component} from "react";

import axios from 'axios';
import uuidv4 from 'uuid/v4';
import serialize from 'form-serialize';

import InfoCarro from './components/InfoCarro';
import Botao from './components/Botao';

import '../css/main.scss';

const marcas = [
    "VW",
    "Chevrolet",
    "FIAT",
    "Ford",
    "Nissan",
    "Mitsubishi",
    "Volvo",
    "BMW"
];

class App extends React.Component {
    formRef;
    inputModeloRef;

    constructor(props){
        super(props);

        this.state = {
            exibirForm: false,
            novoCadastro: false,
            exibirMsg: false,
            tipoMsg: '',
            textoMsg: '',
            modelo: '',
            marca: '',
            ano: '',
            id: '',
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
        this.handleChangeSelect = this.handleChangeSelect.bind(this);
        this.handleClickVoltar = this.handleClickVoltar.bind(this);
        this.removeMsg = this.removeMsg.bind(this);

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
                if(res.data['carros']){
                    this.setState({
                        carros: res.data['carros']
                    });
                }else{
                    this.setState({
                        exibirForm: true,
                        novoCadastro: false,
                        modelo: res.data.modelo,
                        marca: res.data.marca,
                        ano: res.data.ano,
                        id: res.data.id
                    }, () => {
                        this.inputModeloRef.current.focus();
                    });
                }
            })
            .catch(error => {
                console.error(error);
                this.setState({
                    exibirMsg: true,
                    tipoMsg: 'erro',
                    textoMsg: 'Não foi possível carregar os dados.'
                }, () => {
                    this.removeMsg();
                })
            });
    }

    removeMsg() {
        setTimeout(() => {
            this.setState({
                exibirMsg: false,
                tipoMsg: '',
                textoMsg: ''
            })
        }, 3000);
    }

    handleChangeSelect(e) {
        this.setState({
            marca: e.target.value
        })
    }

    handleClickNovo(e) {
        this.setState({
            exibirForm: true,
            novoCadastro: true,
            id: '',
            modelo: '',
            marca: '',
            ano: ''
        }, () => {
            this.inputModeloRef.current.focus();
        });
    }

    handleClickCadastrar(e) {
        var headers = {
            'Content-Type': 'application/json'
        }
        let dataCarro = serialize(this.formRef.current, { hash: true, empty: true});
        axios.post(`http://localhost:8080/estadao/api.php?path=carros`, dataCarro, {headers: headers})
            .then(res => {
                if (res.status === 200) {
                    this.setState({
                        exibirForm: false,
                        exibirMsg: true,
                        tipoMsg: 'sucesso',
                        textoMsg: 'Cadastrado com Sucesso'
                    }, () => {
                        this.removeMsg()
                        this.getCarros();
                    });
                }
            })
            .catch(error => {
                console.error(error);
                this.setState({
                    exibirMsg: true,
                    tipoMsg: 'erro',
                    textoMsg: 'Não foi possível fazer o cadastro.'
                }, () => {
                    this.removeMsg();
                })
            });
    }

    handleClickSave(e, id) {
        var headers = {
            'Content-Type': 'application/json'
        }
        let dataCarro = serialize(this.formRef.current, { hash: true, empty: true});
        axios.put(`http://localhost:8080/estadao/api.php?path=carros/${id}`, dataCarro, {headers: headers})
            .then(res => {
                if (res.status === 200) {
                    this.setState({
                        exibirForm: false,
                        exibirMsg: true,
                        tipoMsg: 'sucesso',
                        textoMsg: 'Editado com Sucesso'
                    }, () => {
                        this.removeMsg()
                        this.getCarros();
                    });
                }
            })
            .catch(error => {
                console.error(error);
                this.setState({
                    exibirMsg: true,
                    tipoMsg: 'erro',
                    textoMsg: 'Não foi possível editar o registro.'
                }, () => {
                    this.removeMsg();
                })
            });
    }

    handleClickEditar(e, id) {
        this.getCarros(id);
    }

    handleClickDelete(e, id) {
        var headers = {
            'Content-Type': 'application/json'
        }
        axios.delete(`http://localhost:8080/estadao/api.php?path=carros/${id}`, {headers: headers})
            .then(res => {
                if (res.status === 200) {
                    this.setState({
                        exibirForm: false,
                        novoCadastro: false,
                        exibirMsg: true,
                        tipoMsg: 'sucesso',
                        textoMsg: 'Registro foi excluído.',
                        modelo: '',
                        marca: '',
                        ano: '',
                        id: ''
                    }, () => {
                        this.removeMsg();
                        this.getCarros();
                    });
                } 
            })
            .catch(err => {
                console.error(err);
                this.setState({
                    exibirMsg: true,
                    tipoMsg: 'erro',
                    textoMsg: 'Não foi possível deletar o registro.'
                }, () => {
                    this.removeMsg();
                })
            });
    }

    handleChangeInput(e) {
        let partialState = {};
        partialState = this.state;
        partialState[e.target.name] = e.target.value;

        this.setState(partialState);
    }

    handleClickVoltar(e) {
        this.setState({
            exibirForm: false
        });
    }

    render() {
        return (
            <div className="caixaPrincipal">
                <header>
                    <div className="caixaBotaoNovo">
                        { !this.state.exibirForm &&
                            <Botao
                                classeContainer='containerBotaoNovo'
                                classe='botaoNovo' 
                                nome='botaoNovo' 
                                valor='Novo' 
                                click={(e) => this.handleClickNovo(e)}
                                />
                        }
                        { this.state.exibirForm &&
                            <Botao
                                classeContainer='containerBotaoVoltar'
                                classe='botaoVoltar' 
                                nome='botaoVoltar' 
                                valor='Voltar' 
                                click={(e) => this.handleClickVoltar(e)}
                                />
                        }
                    </div>
                    Carros
                </header>
                <main>
                    {this.state.exibirMsg &&
                        <div className="caixaMsg">
                            <span className={"msgSistema "+this.state.tipoMsg}>{this.state.textoMsg}</span>
                        </div>
                    }
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
                                <select name="marca" value={this.state.marca} onChange={(e) => this.handleChangeSelect(e)} className="selectMarcaFabricante">
                                    <option value=''>Selecione</option>
                                    {marcas.map((option) => {
                                        return <option key={uuidv4()} className="optionsMarca" value={option}>{option}</option>;
                                    })}
                                </select>
                                <input type='text' name='ano' placeholder="ano" value={this.state.ano} className='input inputAno' onChange={(e) => this.handleChangeInput(e)} />
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
                                            click={(e) => this.handleClickSave(e, this.state.id)}
                                            />
                                        <Botao
                                            classeContainer='containerBotaoExcluir'
                                            classe='botaoExcluir' 
                                            nome='botaoExcluir' 
                                            valor='Excluir' 
                                            click={(e) => this.handleClickDelete(e, this.state.id)}
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
