import React, { useEffect } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { useHistory, useParams } from 'react-router-dom'
import { reduxForm, Field } from 'redux-form'

import Grid from 'components/Layout/grid'
import Content from 'components/Content'
import ContentHeader from 'components/Content/contentHeader'
import Input from 'components/Form/input'
import Select from 'components/Form/select'
import { required, maxLength } from 'components/Form/validation'

import { create, update, view } from 'actions/carsActions'
import { getList as getBrands } from 'actions/brandsActions'

const handleProperty = {
    add: {
        headerSmall: 'Cadastrar',
        btn: 'Incluir',
        action: data => create(data)
    },
    edit: {
        headerSmall: 'Editar',
        btn: 'Salvar',
        action: data => update(data)
    }
}

const maxLength4 = maxLength(4)

const CarsForm = props => {
    const dispatch = useDispatch()
    const history = useHistory()
    const params = useParams()
    
    const { handleSubmit, valid, type } = props
    const { save } = useSelector(state => state.cars)
    const brands = useSelector(state => state.brands.list)

    // Save
    const handleSave = data => {
        dispatch([
            handleProperty[type].action(data)
        ])
    }

    useEffect(() => {
        if (save) history.push("/cars")
    }, [save])

    // View
    const handleView = () => {
        if (type == 'edit') {
            let { id } = params
            dispatch(view(id))
        }
    }

    // Load Init
    useEffect(() => {
        dispatch(getBrands())
        handleView()
    }, [])

    return (
        <div>
            <ContentHeader 
                title='Carros' 
                small={handleProperty[type].headerSmall} />

            <Content>
                <form role='form' onSubmit={handleSubmit(handleSave)}>
                    <div className='box-body'>
                        <Field 
                            name='marca' 
                            component={Select}                            
                            label='Marca'
                            validate={required}
                            cols='12 4'>
                            <option value='' disabled>Escolha uma marca</option>
                            {brands && brands.map((item, index) => (
                                <option key={index} value={item.value}>
                                    {item.name}
                                </option>
                            ))}
                        </Field>

                        <Field 
                            name='modelo' 
                            component={Input}
                            label='Modelo' 
                            cols='12 4'
                            validate={required}
                            placeholder='Informe um modelo' />
                        
                        <Field 
                            name='ano' 
                            component={Input} 
                            type='number'
                            label='Ano' 
                            cols='12 4'
                            validate={[required, maxLength4]} 
                            placeholder='Informe o ano' />                                        
                    </div>

                    <Grid cols="12">
                        <button 
                            type='submit' 
                            disabled={!valid}
                            className='btn btn-primary'>
                            {handleProperty[type].btn}
                        </button>                        
                    </Grid>
                </form>
            </Content>
        </div>
    )
}

export default reduxForm({
    form: 'carsForm'
})(CarsForm)