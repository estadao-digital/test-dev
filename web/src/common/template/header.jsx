import React from 'react'

export default props => (
    <header className='main-header'>
        <a href='/#/' className='logo'>
            <span className='logo-mini'><b>Teste</b>E</span>
            <span className='logo-lg'>
                <i className='fa fa-newspaper-o'></i>
                <b> Teste</b> Estadão
            </span>        
        </a>
        <nav className='navbar navbar-static-top'>
            <a href className='sidebar-toggle' data-toggle='offcanvas'></a>
        </nav>
    </header>
)