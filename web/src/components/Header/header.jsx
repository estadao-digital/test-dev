import React from 'react'
import { Link } from 'react-router-dom'

export default props => (
    <header className='main-header'>
        <Link to='/' className='logo'>
            <span className='logo-mini'><b>Te</b>E</span>
            <span className='logo-lg'>
                <i className='fa fa-newspaper-o'></i>
                <b> Teste</b> Estadão
            </span>        
        </Link>
        <nav className='navbar navbar-static-top'>
            <Link to="#" className='sidebar-toggle' data-toggle='offcanvas'></Link>
        </nav>
    </header>
)