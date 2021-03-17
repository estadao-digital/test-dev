import React, { InputHTMLAttributes } from 'react';

interface SelectProps extends InputHTMLAttributes<HTMLSelectElement> {
    name: string;
    label: string;
    options: Array<{
        value: string;
        label: string;
    }>
}

const Select: React.FC<SelectProps> = ({ name, label, options, ...rest }) => {
    return (
        <div className="form-group mb-3">
            <label htmlFor={name}>{label}</label>
            <select className="form-select" defaultValue="" name={name} id={name} {...rest}>
                <option value="" disabled hidden>Selecione</option>

                {
                    options.map(option => {
                        return <option key={option.value} value={option.value}>{option.label}</option>
                    })
                }
            </select>
        </div>
    )
}

export default Select;