import React from 'react'
import Grid from 'components/Layout/grid'
import Input from 'components/Form/input'

export default props => (
    <Grid cols={props.cols}>
        <div className='form-group'>
            <label htmlFor={props.name}>{props.label}</label>
            <Input {...props} />
        </div>
    </Grid>
)