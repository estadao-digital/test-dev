import { useState, useEffect } from 'react'
import { Nav, Navbar, NavbarBrand } from 'react-bootstrap'

const Menu = () => {
  const [path, setPath] = useState(null)

  useEffect(() => {
    if (typeof window !== 'undefined') {
      setPath(window.location.pathname.replace('/', ''))
    }
  }, [path])

  return (
    <Navbar bg="light" expand="lg">
      <NavbarBrand href="#home">NextCar</NavbarBrand>
      <Navbar.Toggle aria-controls="basic-navbar-nav" />
      <Navbar.Collapse className="justify-content-end">
        <Nav>
          <Nav.Link className={path === 'Home' ? 'active' : ''} href="/">
            Home
          </Nav.Link>
          <Nav.Link
            className={path === 'CarList' ? 'active' : ''}
            href="/CarList"
          >
            Car List
          </Nav.Link>
        </Nav>
      </Navbar.Collapse>
    </Navbar>
  )
}

export default Menu
