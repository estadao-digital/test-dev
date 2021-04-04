// const teste = () => console.log('olar');

const HOST = 'http://localhost:8080';

export const service = {

    get: async (resource) => {
        fetch(HOST + resource)
        .then(function(response){
            if (!response.ok) throw new Error('Falha ao acessar API');

            return response.json();
        })
        .then(function(data){
            return data.data;
        })
        .catch(function(error){
            console.error(error);
        })
    },

    get2: async (resource) => {
        try {
            const response = await fetch( HOST + resource);

            if (!response.ok) throw new Error('Falha ao buscar veículos!');

            const data = await response.json();

            return data.data;

        } catch (error) {
            console.error(error);
        }
    }
};

