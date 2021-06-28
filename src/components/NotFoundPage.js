import React from "react"
import { Link } from "react-router-dom";

const NotFoundPage = (props) => {
  if (props.match.path !== "/404") {
    window.location.replace("/404");
  }

  return (
    <div className="py-5">
      <h2>Página não encontrada</h2>
      <p className="mt-5"><Link to="/" className="btn btn-primary">Voltar para home</Link></p>
    </div>
  )
}

export default NotFoundPage
