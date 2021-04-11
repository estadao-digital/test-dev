import React from 'react'
import Grid from 'components/Layout/grid'
import If from 'components/Operator/if'

export default props => {
    const {
        input,
        label,        
        name,
        cols,
        children,
        meta: { touched, error, warning }
    } = props

    return (
        <Grid cols={cols}>
            <div className='form-group'>
                <If test={label}>
                    <label htmlFor={name}>{label}</label>
                </If>
                
                <select {...input} className='form-control'>
                   {children}
                </select>

                {touched &&
                    ((error && <span>{error}</span>) ||
                    (warning && <span>{warning}</span>))}
            </div>
        </Grid>
    )
}