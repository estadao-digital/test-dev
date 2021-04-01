import React from 'react';
import { Switch, Route } from 'react-router-dom';

import Dashboard from '../pages/Dashboard';

export default function Routes() {
  return (
    <Switch>
      <Route path="/" exact component={Dashboard} />
    </Switch>
  );
}
