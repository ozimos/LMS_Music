import React from 'react'
import { Field } from 'redux-form'
import { RadioFormLineItem } from 'components'

const RadioField = ({value, labelText, name}) => (
  <Field
    component={RadioFormLineItem}
    type="radio"
    value={value}
    name={name}
    labelText={labelText}
    labelText={labelText}
    key={labelText}
  />)

export const RadioGroup = ({radios}) => (
  <div>
    {radios.map(radio => <RadioField {...radio} />)}
  </div>
)
