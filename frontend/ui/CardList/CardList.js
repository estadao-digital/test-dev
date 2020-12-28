import * as React from 'react'

import { CarsApi } from '../../api'

function CardList ({ listItems }) {
  const handleRemove = async id => {
    await CarsApi.removeEntry(id)
  }

  return (
    <section className='list'>
      {listItems.map(({ model, maker, year, id }) => (
        <div className='list-item' key={id}>
          <div className='list-item__data'>
            <p className='list-item__text list-item__text--title'>{model}</p>
            <p className='list-item__text'>{maker}</p>
            <p className='list-item__text'>{year}</p>
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
