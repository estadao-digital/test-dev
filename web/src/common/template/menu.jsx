import React from 'react'
import MenuItem from './menuItem'
import MenuTree from './menuTree'

export default props => (
    <ul className='sidebar-menu'>
        <MenuItem path='/' label='Dashboard' icon='dashboard' />
        <MenuTree label='Carros' icon='car'> 
            <MenuItem path='cars' label='Listar' icon='list' />
            <MenuItem path='cars/add' label='Cadastrar' icon='plus' />
        </MenuTree>
    </ul>
)