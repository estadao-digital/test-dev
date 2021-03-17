import { useState, useLayoutEffect } from 'react';
import { Link } from 'react-router-dom';

import Footer from '../../components/Footer';
import Navbar from '../../components/Navbar';
import api from '../../services/api';

function CarList() {
    const [listaCarros, setListaCarros] = useState([]);

    useLayoutEffect(() => {
        api.get('carros').then(response => {
            setListaCarros(response.data);
        });
    }, []);

    function handleDeleteCar(id: number) {

        api.delete(`carros/${id}`).then(() => {
            alert('Cadastro excluído com sucesso!');
        }).catch(() => {
            alert('Erro na exclusão!');
        });
    }

    return (
        <div className="d-flex flex-column h-100">
            <Navbar />
            
            <main className="flex-shrink-0 mt-5">
                <div className="container">
                    <div className="row">
                        <div className="col-md-6 offset-md-3">
                            <h1 className="mt-5">Carros</h1>
                            <Link to="/novo" className="btn btn-secondary">Novo carro</Link>

                            <table className="table table-sm table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th className="text-center">#</th>
                                        <th className="w-50">Marca</th>
                                        <th className="w-50">Modelo</th>
                                        <th className="text-center">Ano</th>
                                        <th className="text-center">Ação</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    {listaCarros.map(carro => {
                                        return (
                                            <tr key={carro['id']}>
                                                <td className="align-middle text-center">{carro['id']}</td>
                                                <td className="align-middle">{carro['marca']}</td>
                                                <td className="align-middle">{carro['modelo']}</td>
                                                <td className="align-middle">{carro['ano']}</td>
                                                <td className="align-middle text-center">
                                                    <div className="btn-group">
                                                        <a href="#" className="btn btn-dark btn-sm"><i className="fas fa-pen fa-fw"></i></a>
                                                        <a href="#" className="btn btn-dark btn-sm" onClick={() => handleDeleteCar(carro['id'])}><i className="fas fa-trash fa-fw"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        )
                                    })}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>

            <Footer />
        </div>
    )
}

export default CarList;