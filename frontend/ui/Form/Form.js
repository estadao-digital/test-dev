import * as React from 'react'

import { Form as BaseForm } from '../../base-components'
import { MakersSelect, ModelName, ModelYear } from '.'

function Form ({ isEditing, selectOptions }) {
  return (
    <BaseForm id='new-addition' className='form-container'>
      <fieldset>
        <legend className='form-title'>
          {!isEditing ? 'New addition' : 'Editing model'}
        </legend>

        <MakersSelect makers={selectOptions} />

        <ModelName />

        <ModelYear />
      </fieldset>

      <button className='button'>
        {!isEditing ? 'Save entry' : 'Update entry'}
      </button>
    </BaseForm>
  )
}

export default Form
