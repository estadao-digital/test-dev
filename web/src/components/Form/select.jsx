import React from 'react'
import Grid from 'components/Layout/grid'
import If from 'components/Operator/if'

export default props => {
    return (
        <Grid cols={props.cols}>
            <div className='form-group'>
                <If test={props.label}>
                    <label htmlFor={props.name}>{props.label}</label>
                </If>
                
                <select {...props.input} className='form-control'>
                    <If test={props.defaultName}>
                        <option value={props.defaultValue}>
                            {props.defaultName}
                        </option>
                    </If>

                    {props.options && props.options.map((item, index) => (
                        <option key={index} value={item.value}>
                            {item.name}
                        </option>
                    ))}
                </select>
            </div>
        </Grid>
    )
}