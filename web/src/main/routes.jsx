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
import CarsForm from 'components/Cars/carsForm'

export default () => (
    <HashRouter>
        <App>
            <Switch>
                <Route 
                    exact 
                    path="/" 
                    component={Dashboard} />
                
                <Route 
                    exact 
                    path="/cars" 
                    component={Cars} />
                
                <Route 
                    exact 
                    path="/cars/add" 
                    component={() => <CarsForm type="add" />} />
                
                <Route 
                    exact 
                    path="/cars/edit/:id" 
                    component={() => <CarsForm type="edit" />} />
                
                <Redirect from='*' to='/' />
            </Switch>
        </App>
    </HashRouter>    
)