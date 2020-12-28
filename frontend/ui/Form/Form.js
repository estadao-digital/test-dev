import * as React from 'react'

import useFormReducer from '../../hooks/useFormReducer'
import { Form as BaseForm } from '../../base-components'
import { MakersSelect, ModelName, ModelYear } from '.'

function Form ({ formData, isEditing, selectOptions }) {
  const initialState = {
    makerId: null,
    model: '',
    year: ''
  }
  const [state, dispatch] = useFormReducer(formData || initialState)

  const handleChange = value => {
    dispatch(value)
  }

  const handleSubmit = e => {
    e.preventDefault()

    console.log(state)
  }

  return (
    <BaseForm id='new-addition' className='form-container'>
      <fieldset>
        <legend className='form-title'>
          {!isEditing ? 'New addition' : 'Editing model'}
        </legend>

        <MakersSelect makers={selectOptions} onChange={handleChange} />

        <ModelName onChange={handleChange} />

        <ModelYear onChange={handleChange} />
      </fieldset>

      <button className='button' onClick={handleSubmit}>
        {!isEditing ? 'Save entry' : 'Update entry'}
      </button>
    </BaseForm>
  )
}

export default Form
