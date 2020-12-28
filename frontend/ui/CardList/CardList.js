import * as React from 'react'
import { useDispatch as useReduxDispatch } from 'react-redux'

import { CarsApi } from '../../api'
import { refreshCarsList } from '../../store/thunks'

function CardList ({ listItems }) {
  const dispatch = useReduxDispatch()

  const handleRemove = async id => {
    try {
      await CarsApi.removeEntry(id)
    } finally {
      const newList = listItems.filter(({ id: carId }) => id !== carId)

      dispatch(refreshCarsList({ data: newList }))
    }
  }

  return (
    <section className='list'>
      {listItems.map(({ model, maker, year, id }) => (
        <div className='list-item' key={id}>
          <div className='list-item__data'>
            <p className='list-item__text list-item__text--title'>{model}</p>
            <p className='list-item__text list-item__text--maker'>{maker}</p>
            <p className='list-item__text list-item__text--year'>{year}</p>
          </div>
          <div className='list-item__actions'>
            <button
              className='action'
              onClick={() => console.log('{handleEdit}')}
            >
              Edit
            </button>
            <button className='action' onClick={() => handleRemove(id)}>
              Remove
            </button>
          </div>
        </div>
      ))}
    </section>
  )
}

export default CardList
