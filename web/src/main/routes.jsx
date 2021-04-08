import React from 'react'
import { Router, Route, IndexRoute, Redirect, hashHistory } from 'react-router'

import App from './app'
import Dashboard from 'components/Dashboard'
import Cars from 'components/Cars'
import CarsAdd from 'components/Cars/carsAdd'

export default () => (
    <Router history={hashHistory}>
        <Route path='/' component={App}>
            <IndexRoute component={Dashboard} />
            <Route path='cars' component={Cars} />
            <Route path='cars/add' component={CarsAdd} />
        </Route>
        <Redirect from='*' to='/' />
    </Router>
)