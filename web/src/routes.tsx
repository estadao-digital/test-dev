import { BrowserRouter, Route } from 'react-router-dom';

import CarForm from './pages/CarForm';
import CarList from './pages/CarList';
import Home from './pages/Home';

function Routes() {
    return (
        <BrowserRouter>
            <Route path="/" exact component={Home} />
            <Route path="/carros" component={CarList} />
            <Route path="/novo" component={CarForm} />
        </BrowserRouter>
    )
}

export default Routes;