import '../common/template/dependencies'
import React from 'react'

import Header from 'components/Header'
import SideBar from 'components/SideBar'
import Footer from 'components/Footer'
import Messages from 'components/Messages'

export default props => (
    <div className="wrapper">
        <Header />
        <SideBar />
        <div className='content-wrapper'> 
            {props.children}
        </div>
        <Footer />
        <Messages />
    </div>
)