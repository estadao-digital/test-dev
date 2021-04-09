import React from 'react'

import {     
    HashRouter, 
    Switch, 
    Route,    
    Redirect
} from 'react-router-dom'

import App from './app'
import Dashboard from 'components/Dashboard'
import Cars from 'components/Cars'
import CarsAdd from 'components/Cars/carsAdd'

export default () => (
    <HashRouter>
        <App>
            <Switch>
                <Route exact path="/" component={Dashboard} />
                <Route exact path="/cars" component={Cars} />
                <Route exact path="/cars/add" component={CarsAdd} />
                <Redirect from='*' to='/' />
            </Switch>
        </App>
    </HashRouter>    
)