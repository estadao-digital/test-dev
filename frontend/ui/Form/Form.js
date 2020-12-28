import * as React from 'react'

import { Form as BaseForm } from '../../base-components'
import { MakersSelect, ModelName, ModelYear } from '.'

function Form ({ isEditing }) {
  return (
    <BaseForm id='new-addition' className='form-container'>
      <fieldset>
        <legend className='form-title'>
          {!isEditing ? 'New addition' : 'Editing model'}
        </legend>

        <MakersSelect />

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
