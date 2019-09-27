import Home from "./components/Home";
import NovoCarro from "./components/Carros/NovoCarro";

export const routes = [
    {
        path: '/',
        component: Home
    },
    {
        path: '/carro/novo',
        component: NovoCarro
    },
];
