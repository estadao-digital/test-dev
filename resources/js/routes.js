import Home from "./components/Home";
import NovoCarro from "./components/Carros/NovoCarro";
import DetalharCarro from "./components/Carros/DetalharCarro";
import EditarCarro from "./components/Carros/EditarCarro";

export const routes = [
    {
        path: '/',
        component: Home
    },
    {
        path: '/carro/novo',
        component: NovoCarro
    },
    {
        path: '/carro/:id',
        component: DetalharCarro
    },
    {
        path: '/carro/editar/:id',
        component: EditarCarro
    }
];
