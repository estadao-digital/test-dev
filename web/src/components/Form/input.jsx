import React from 'react'
import Grid from 'components/Layout/grid'
import If from 'components/Operator/if'

export default props => (
    <Grid cols={props.cols}>
        <div className='form-group'>
            <If test={props.label}>
                <label htmlFor={props.name}>{props.label}</label>
            </If>
            
            <input {...props.input}
                className='form-control'
                placeholder={props.placeholder}
                readOnly={props.readOnly}
                type={props.type} />
        </div>
    </Grid>
)