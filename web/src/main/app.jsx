import '../common/template/dependencies'
import React from 'react'

import Header from '../common/template/header'
import SideBar from '../common/template/sideBar'
import Footer from '../common/template/footer'

export default () => (
    <div className="wrapper">
        <Header />
        <SideBar />
        <div className='content-wrapper'> 
            <h1>Conteúdo Aqui</h1>
        </div>
        <Footer />
    </div>
)