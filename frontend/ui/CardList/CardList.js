import * as React from 'react'

function CardList () {
  return (
    <section className='list'>
      <div className='list-item'>
        <div className='list-item__data'>
          <p className='list-item__text list-item__text--title'>
            Camaro amarelo
          </p>
          <p className='list-item__text'>Chevrolet</p>
          <p className='list-item__text'>2007</p>
        </div>
        <div className='list-item__actions'>
          <button
            className='action'
            onClick={() => console.log('{handleEdit}')}
          >
            Edit
          </button>
          <button
            className='action'
            onClick={() => console.log('{handleRemove}')}
          >
            Remove
          </button>
          <button
            className='action'
            onClick={() => console.log('{handleView}')}
          >
            View
          </button>
        </div>
      </div>
    </section>
  )
}

export default CardList
