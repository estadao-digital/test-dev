import '../common/template/dependencies'
import React from 'react'

import Header from 'components/Header'
import SideBar from 'components/SideBar'
import Footer from 'components/Footer'

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