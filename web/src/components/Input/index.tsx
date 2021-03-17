import React, { InputHTMLAttributes } from 'react';

interface InputProps extends InputHTMLAttributes<HTMLInputElement> {
    name: string;
    label: string;
}

const Input: React.FC<InputProps> = ({ name, label, ...rest }) => {
    return (
        <div className="form-group mb-3">
            <label htmlFor={name}>{label}</label>
            <input type="text" className="form-control" name={name} id={name} {...rest} />
        </div>
    )
}

export default Input;