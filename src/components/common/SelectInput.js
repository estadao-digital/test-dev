import React from "react"
import PropTypes from "prop-types"

const SelectInput = (props) => {
  let wrapperClass = "form-group"
  if (props.error.length > 0) {
    wrapperClass += " has-error"
  }

  return (
    <div className={wrapperClass}>
      <label htmlFor={props.id}>{props.label}</label>
      <div className="field">
        <select name={props.name} value={props.value} onChange={props.onChange} className="form-control">
          <option value="">{props.defaultOption}</option>
          {props.options.map(option => <option key={option.value} value={option.value}>{option.text}</option>)}
        </select>
      </div>
      {props.error && <div className="alert alert-danger">{props.error}</div>}
    </div>
  )
}

SelectInput.prototype = {
  name         : PropTypes.string.isRequired,
  label        : PropTypes.string.isRequired,
  onChange     : PropTypes.func.isRequired,
  value        : PropTypes.string,
  error        : PropTypes.string,
  defaultOption: PropTypes.string,
  options      : PropTypes.arrayOf(PropTypes.object)
}

SelectInput.defaultProps = { error: "" }

export default SelectInput
