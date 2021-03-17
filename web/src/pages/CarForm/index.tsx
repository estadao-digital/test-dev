import { FormEvent, useEffect, useState } from 'react';
import { useHistory } from 'react-router-dom';

import Input from '../../components/Input';
import Select from '../../components/Select';
import Footer from '../../components/Footer';
import Navbar from '../../components/Navbar';
import api from '../../services/api';

function CarForm() {
    const history = useHistory();

    const [todasMarcas, setTodasMarcas] = useState([]);
    
    const[marca, setMarca] = useState('');
    const[modelo, setModelo] = useState('');
    const[ano, setAno] = useState('');

    useEffect(() => {
        api.get('marcas').then(response => {
            let marcas = response.data;

            marcas = marcas.map( function (val: string, index: string) {
                return { "value": val, "label": val }
            });

            setTodasMarcas(marcas);
        })
    }, []);

    function handleCreateClass(e: FormEvent) {
        e.preventDefault();

        api.post('carros', {
            marca,
            modelo,
            ano
        }).then(() => {
            alert('Cadastro realizado com sucesso!');
        }).catch(() => {
            alert('Erro no cadastro!');
        });
        
        history.push('/carros');
    }

    return (
        <div className="d-flex flex-column h-100">
            <Navbar />
            
            <main className="flex-shrink-0 mt-5">
                <div className="container">
                    <div className="row">
                        <div className="offset-md-3 col-md-6">
                            <h1 className="mt-5">Formulário</h1>

                            <form className="form" onSubmit={handleCreateClass}>

                                <Select
                                    name="marca"
                                    label="Marca"
                                    options={todasMarcas}
                                    value={marca}
                                    onChange={(e) => setMarca(e.target.value)}
                                />
                                
                                <Input
                                    name="modelo"
                                    label="Modelo"
                                    value={modelo}
                                    onChange={(e) => setModelo(e.target.value)}
                                />

                                <Input
                                    name="ano"
                                    label="Ano"
                                    value={ano}
                                    onChange={(e) => setAno(e.target.value)}
                                />

                                <div className="form-group text-end">
                                    <button className="btn btn-primary">Aplicar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>

            <Footer />
        </div>
    )
}

export default CarForm;