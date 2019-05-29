import React from 'react'

const textInputClasses =
  'block w-full border border-grey-light bg-grey-lightest rounded'

export const TextInput = props => (
  <input className={`${textInputClasses} h-12 px-2`} {...props} type="text" />
)

export const RadioInput = props => (
  <label className="block text-grey-dark text-md" htmlFor={name}>
      <span className="inline-block mb-2">{labelText}</span>
  <input className="h-12 px-2" {...props} type="radio" />
)

export const PasswordInput = props => (
  <input
    className={`${textInputClasses} h-12 px-2`}
    {...props}
    type="password"
  />
)

export const TextArea = props => (
  <textarea className={`${textInputClasses} h-48 p-2`} {...props} />
)
