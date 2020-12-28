import * as React from 'react'

function Form () {
  return (
    <form id='new-addition' className='form-container'>
      <fieldset>
        <legend className='form-title'>New addition</legend>

        <div className='select-input-group'>
          <label className='input-label' htmlFor='maker-select'>
            Who makes this model?
          </label>
          <select name='makerId' id='maker-select'>
            <option value=''>Choose an option</option>
          </select>
        </div>

        <div className='text-input-group'>
          <label className='input-label' htmlFor='model-name'>
            What's its name?
          </label>
          <input id='model-name' name='model' type='text' />
        </div>

        <div className='text-input-group'>
          <label className='input-label' htmlFor='model-year'>
            What is the model's year?
          </label>
          <input id='model-year' name='year' type='text' />
        </div>
      </fieldset>

      <button className='button'>Save entry</button>
    </form>
  )
}

export default Form
