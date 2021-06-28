import React from "react"
import { Route, Switch, Redirect } from "react-router-dom"
import { ToastContainer } from 'react-toastify'

// * * * * * Page Components * * * * *
import HomePage from "./HomePage"
import CarsPage from "./CarsPage"
import NotFoundPage from "./NotFoundPage"
import ManageCarPage from "./ManageCarPage"
// * * * * * Common Components * * * * *
import Header from "./common/Header"

const App = () => {
  return (
    <div className="container">
      <ToastContainer autoClose={3000} hideProgressBar />
      <Header />
      <Switch>
        <Route exact path="/" component={HomePage} />
        <Route path="/carros" component={CarsPage} />
        <Route path="/carro/:id" component={ManageCarPage} />
        <Route path="/carro" component={ManageCarPage} />
        <Route path="/404" component={NotFoundPage} status={404} />
        <Route component={NotFoundPage} status={404} />
      </Switch>
    </div>
  )
}

export default App
