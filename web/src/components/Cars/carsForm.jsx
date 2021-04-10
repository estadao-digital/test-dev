import React, { useEffect } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { useHistory } from 'react-router-dom'
import { reduxForm, Field, actionTypes } from 'redux-form'

import Grid from 'components/Layout/grid'
import Content from 'components/Content'
import ContentHeader from 'components/Content/contentHeader'
import Input from 'components/Form/input'
import Select from 'components/Form/select'

import { create } from 'actions/carsActions'
import { getList as getBrands } from 'actions/brandsActions'

const CarsForm = props => {
    const dispatch = useDispatch()
    const history = useHistory()

    const { handleSubmit } = props

    const handleCreate = data => {
        dispatch([
            create(data)
        ])
    }

    const { save } = useSelector(state => state.cars)

    useEffect(() => {
        if (save) history.push("/cars")
    }, [save])

    // Brands
    useEffect(() => dispatch(getBrands()), [])

    let brands = useSelector(state => state.brands.list)

    brands = brands.map(item => {
        return {
            value: item.nome,
            name: item.nome
        }
    })

    return (
        <div>
            <ContentHeader title='Carros' small='Adicionar' />
            <Content>
                <form role='form' onSubmit={handleSubmit(handleCreate)}>
                    <div className='box-body'>
                        <Field 
                            name='marca' 
                            component={Select}
                            options={brands}
                            defaultName="Informe uma marca"
                            label='Marca' 
                            cols='12 4' />

                        <Field 
                            name='modelo' 
                            component={Input}
                            label='Modelo' 
                            cols='12 4'
                            placeholder='Informe um modelo' />
                        
                        <Field 
                            name='ano' 
                            component={Input} 
                            type='number'
                            label='Ano' 
                            cols='12 4' 
                            placeholder='Informe o ano' />                                        
                    </div>

                    <Grid cols="12">
                        <button type='submit' className='btn btn-primary'>Incluir</button>                        
                    </Grid>
                </form>
            </Content>
        </div>
    )
}

export default reduxForm({
    form: 'carsForm'
})(CarsForm)