

    const HOST = 'http://localhost:8080';


    export const Api = {


        getCarros: () => {
            return axios( HOST + '/Carros')
        },
        
        getMarcas: () => {
            return axios( HOST + '/Marcas');
        },
        
        getModelos: (id) => {
            return axios( HOST + '/Modelos/' + id);
        },
        
        postCarro: (data) => {
            return axios.post(HOST + '/Carros', data);
        },
        
        putCarro: (id, data) => {
            return axios.put(HOST + '/Carros/' + id, data);
        },
        
        deleteCarro: (id) => {
            return axios.delete( HOST + '/Carros/' + id);
        },
    }