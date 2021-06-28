import React from "react"
import PropTypes from "prop-types"

import TextInput from "./common/TextInput"
import SelectInput from "./common/SelectInput"

const CarForm = (props) => {
  return (
    <form onSubmit={props.onSubmit}>
      <TextInput id="title" name="title" label="Modelo" value={props.car.title} onChange={props.onChange} error={props.errors.title}/>

      <TextInput id="year" name="year" label="Ano" value={props.car.year} onChange={props.onChange} error={props.errors.year} />

      {/* <div className="form-group">
        <label htmlFor="brand">Marca</label>
        <div className="field">
          <select name="brandId" id="brand" className="form-control" value={props.car.brandId || ""} onChange={props.onChange}>
            <option value=""/>
            <option value="1">Cory House</option>
            <option value="2">Scott Allen</option>
          </select>
        </div>
        {props.errors.brandId && <div className="alert alert-danger">{props.errors.brandId}</div>}
      </div> */}

      <SelectInput name="brandId" label="Marca" value={props.car.brandId || ""} defaultOption="Selecione uma marca" options={props.brands.map(brand => ({ value: brand.id, text: brand.name }))} onChange={props.onChange} error={props.errors.brandId} />

      <input type="submit" value="Salvar" className="btn btn-primary"/>
    </form>
  )
}

CarForm.prototype = {
  car  : PropTypes.object.isRequired,
  onSubmit: PropTypes.func.isRequired,
  onChange: PropTypes.func.isRequired,
  errors  : PropTypes.object.isRequired
}

export default CarForm
