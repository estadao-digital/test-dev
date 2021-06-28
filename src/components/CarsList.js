import React from "react"
import { Link } from "react-router-dom"
import PropTypes from "prop-types";

const CarsList = (props) => {
  return (
    <table className="table">
      <thead>
        <tr>
          <th>Modelo</th>
          <th>Ano</th>
          <th>Marca</th>
          <th>Remover</th>
        </tr>
      </thead>
      <tbody>
        {props.cars.map(car => {
          return (
            <tr key={car.id}>
              <td><Link to={`/carro/${car.id}`}>{car.title}</Link></td>
              <td>{car.year}</td>
              <td>{car.brandName}</td>
              <td><button type="button" className="btn btn-danger" onClick={() => props.onDelete(car.id)}>X</button></td>
            </tr>
          )
        })}
      </tbody>
    </table>
  )
}

CarsList.prototype = {
  cars: PropTypes.arrayOf(
    PropTypes.shape({
      id: PropTypes.number.isRequired,
      title: PropTypes.string.isRequired,
      year: PropTypes.number.isRequired,
      brandId: PropTypes.number.isRequired,
      brandName: PropTypes.string.isRequired
    })
  ).isRequired,
  onDelete: PropTypes.func.isRequired
}

export default CarsList
