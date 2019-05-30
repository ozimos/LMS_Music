import React from 'react'

const textInputClasses =
  'block w-full border border-grey-light bg-grey-lightest rounded'

export const TextInput = props => (
  <input className={`${textInputClasses} h-12 px-2`} {...props} type="text" />
)

export const RadioInput = ({input, radio}) => (
  <label className="block text-grey-dark text-md" htmlFor={input.name}>
    <span className="inline-block mb-2">{radio.labelText}</span>
    <input
      className="h-12 px-2"
      {...input}
      type="radio"
      value={radio.value}
      checked={radio.value === input.value} />
  </label>
)

export const RadioGroup = ({radios, input}) => (
  <div>
    {radios.map(radio => <RadioInput radio={radio} input={input} />)}
  </div>
)

export const PasswordInput = props => (
  <input
    className={`${textInputClasses} h-12 px-2`}
    {...props}
    type="password"
  />
)
export const CheckBoxInput = props => (
  <input
    className={`${textInputClasses} h-20 px-4`}
    {...props}
    type="checkbox"
  />
)

export const TextArea = props => (
  <textarea className={`${textInputClasses} h-48 p-2`} {...props} />
)
