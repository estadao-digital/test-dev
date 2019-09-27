import Home from "./components/Home";
import NovoCarro from "./components/Carros/NovoCarro";
import DetalharCarro from "./components/Carros/DetalharCarro";

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
    }
];
