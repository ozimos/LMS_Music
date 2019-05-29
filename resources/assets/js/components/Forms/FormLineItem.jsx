import React from 'react'
import { RadioInput } from 'components'

export const FormLineItem = ({
  labelText,
  name,
  children,
  className = ''
}) => (
  <div className={`inline-block py-4 ${className}`}>
    <label className="inline-block text-grey-dark text-md" htmlFor={name}>
      <span className="inline-block mb-2">{labelText}</span>
      {children}
    </label>
  </div>
)

export const RadioFormLineItem = ({ input, ...wrapperProps }) => (
  <FormLineItem {...wrapperProps}>
    <RadioInput {...input} />
  </FormLineItem>
)
