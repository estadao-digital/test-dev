import * as React from 'react'
import { useSelector } from 'react-redux'

import { AppContext } from '../../contexts'

function CardList () {
  const { handleEdit, handleRemove } = React.useContext(AppContext)
  const cars = useSelector(state => state.cars)

  return (
    <section className='list'>
      {cars.data.map(({ model, maker, year, id }) => (
        <div className='list-item' key={id}>
          <div className='list-item__data'>
            <p className='list-item__text list-item__text--title'>{model}</p>
            <p className='list-item__text list-item__text--maker'>{maker}</p>
            <p className='list-item__text list-item__text--year'>{year}</p>
          </div>
          <div className='list-item__actions'>
            <button className='action edit' onClick={() => handleEdit(id)}>
              Edit
            </button>
            <button className='action remove' onClick={() => handleRemove(id)}>
              Remove
            </button>
          </div>
        </div>
      ))}
    </section>
  )
}

export default CardList
