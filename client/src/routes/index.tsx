import React from 'react';
import { Switch, Route } from 'react-router-dom';

import Home from '../pages/Home';
import Cars from '../pages/Cars';
import AddCar from '../pages/AddCar';
import EditCar from '../pages/EditCar';

const Routes: React.FC = () => {
  return (
    <Switch>
      <Route path="/cars/add" component={AddCar} />
      <Route path="/cars/edit" component={EditCar} />
      <Route path="/cars" component={Cars} />
      <Route path="/" component={Home} />
    </Switch>
  );
};

export default Routes;
