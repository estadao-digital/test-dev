import React, { useEffect } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { useHistory } from 'react-router-dom'

import Content from 'components/Content'
import ContentHeader from 'components/Content/contentHeader'

import { remove, getList } from 'actions/carsActions'

export default () => {
    const dispatch = useDispatch()
    const history = useHistory()
    const { list } = useSelector(state => state.cars)

    useEffect(() => dispatch(getList()), [])

    const handleUpdate = id => history.push(`/cars/edit/${id}`)
    const handleDelete = id => dispatch([remove(id)])
 
    const renderRows = () => {
        return list.map(item => (
            <tr key={item.id}>
                <td>{item.marca}</td>
                <td>{item.modelo}</td>
                <td>{item.ano}</td>
                <td>
                    <button
                        onClick={() => handleUpdate(item.id)} 
                        className='btn btn-warning'>
                        <i className='fa fa-pencil'></i>
                    </button>
                    <button
                        onClick={() => handleDelete(item.id)} 
                        className='btn btn-danger'>
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