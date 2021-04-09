import React, { useEffect } from 'react'
import { useDispatch, useSelector } from 'react-redux'

import Content from 'components/Content'
import ContentHeader from 'components/Content/contentHeader'

import { getList } from 'actions/carsActions'

export default () => {
    const dispatch = useDispatch()
    const { list } = useSelector(state => state.cars)

    useEffect(() => dispatch(getList()), [])

    const renderRows = () => {
        return list.map(item => (
            <tr key={item.id}>
                <td>{item.marca}</td>
                <td>{item.modelo}</td>
                <td>{item.ano}</td>
                <td>
                    <button 
                        className='btn btn-warning'>
                        <i className='fa fa-pencil'></i>
                    </button>
                    <button className='btn btn-danger'>
                        <i className='fa fa-trash-o'></i>
                    </button>
                </td>
            </tr>
        ))
    }
 
    return (
        <div>
            <ContentHeader title='Carros' small='Listar' />
            <Content>        
                <table className='table'>
                    <thead>
                        <tr>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Ano</th>
                            <th className='table-actions'>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        {renderRows()}
                    </tbody>
                </table>
            </Content>
        </div>
    )
}