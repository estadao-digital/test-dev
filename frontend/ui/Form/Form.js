import * as React from 'react'

import useFormReducer from '../../hooks/useFormReducer'
import { AppContext } from '../../contexts'
import { Form as BaseForm } from '../../base-components'
import { MakersSelect, ModelName, ModelYear } from '.'

function Form ({ selectOptions }) {
  const initialState = {
    makerId: null,
    model: '',
    year: ''
  }
  const [state, dispatch] = useFormReducer(initialState)
  const { handleSubmit, isEditing } = React.useContext(AppContext)

  const handleChange = value => {
    dispatch(value)
  }

  const onSubmit = (e, id) => {
    const formData = {
      ...state,
      makerId: +state.makerId
    }

    e.preventDefault()
    handleSubmit(isEditing ? { ...formData, id } : formData)
    dispatch('init')
  }

  return (
    <BaseForm id='new-addition' className='form-container'>
      <fieldset>
        <legend className='form-title'>
          {!isEditing ? 'New addition' : 'Editing model'}
        </legend>

        <MakersSelect
          makers={selectOptions}
          onChange={handleChange}
          value={state.makerId}
        />

        <ModelName onChange={handleChange} value={state.model} />

        <ModelYear onChange={handleChange} value={state.year} />
      </fieldset>

      {!isEditing ? (
        <button className='button' onClick={onSubmit}>
          Save Entry
        </button>
      ) : (
        <button className='button' onClick={e => onSubmit(e, isEditing)}>
          Update Entry
        </button>
      )}
    </BaseForm>
  )
}

export default Form
