import React from "react"
import { NavLink } from "react-router-dom";

const Header = () => {
  const activeStyle = { color: "orange" }
  return (
    <nav>
      <NavLink exact to="/" activeClassName="active" activeStyle={activeStyle}>Home</NavLink>{" | "}
      <NavLink to="/carros" activeClassName="active" activeStyle={activeStyle}>Carros</NavLink>{" | "}
    </nav>
  )
}

export default Header
