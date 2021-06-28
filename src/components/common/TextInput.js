import React from "react"
import PropTypes from "prop-types"

const TextInput = (props) => {
  let wrapperClass = "form-group"
  if (props.error.length > 0) {
    wrapperClass += " has-error"
  }

  return (
    <div className={wrapperClass}>
      <label htmlFor={props.id}>{props.label}</label>
      <div className="field">
        <input type="text" id={props.id} name={props.name} className="form-control" value={props.value} onChange={props.onChange}/>
      </div>
      {props.error && <div className="alert alert-danger">{props.error}</div>}
    </div>
  )
}

TextInput.prototype = {
  id      : PropTypes.string.isRequired,
  name    : PropTypes.string.isRequired,
  label   : PropTypes.string.isRequired,
  onChange: PropTypes.func.isRequired,
  value   : PropTypes.string,
  error   : PropTypes.string,
}

TextInput.defaultProps = { error: "" }

export default TextInput
