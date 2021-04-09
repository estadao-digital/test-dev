import React, { useEffect } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { reduxForm, Field } from 'redux-form'
import Grid from 'components/Layout/grid'

import Content from 'components/Content'
import ContentHeader from 'components/Content/contentHeader'

import LabelAndInput from 'components/Form/labelAndInput'

let CarsAdd = props => {
    const dispatch = useDispatch()
    const { handleSubmit } = props

    return (
        <div>
            <ContentHeader title='Carros' small='Adicionar' />
            <Content>
                <form role='form' onSubmit={handleSubmit}>
                    <div className='box-body'>
                        <Field 
                            name='marca' 
                            component={LabelAndInput}
                            label='Marca' 
                            cols='12 4' 
                            placeholder='Informe a marca' />

                        <Field 
                            name='modelo' 
                            component={LabelAndInput}                             
                            label='Modelo' 
                            cols='12 4' 
                            placeholder='Informe o modelo' />
                        
                        <Field 
                            name='ano' 
                            component={LabelAndInput} 
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

CarsAdd = reduxForm({
    form: 'carsAdd'
})(CarsAdd)

export default CarsAdd