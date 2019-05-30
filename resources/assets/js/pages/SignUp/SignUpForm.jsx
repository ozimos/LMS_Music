import React from 'react'
import { Link } from 'react-router-dom'
import { reduxForm, Field } from 'redux-form'

import { PasswordFormLine, TextFormLine, CheckBoxFormLine, NeutralButton } from 'components'
import { email as emailRegex } from 'constants/regexes'
import { linkStyle } from 'constants/styles'

const validateSignUp = values => {
  let errors = {}

  if (!values.email) {
    errors.email = 'This field is required'
  } else if (!emailRegex.test(values.email)) {
    errors.email = 'Invalid email address'
  }

  if (!values.password) {
    errors.password = 'This field is required'
  }
  if (values.password_confirmation !== values.password) {
    errors.password = 'Passwords do not match'
  }

  return errors
}

const SignUpForm = props => {
  const { handleSubmit } = props

  return (
    <form onSubmit={handleSubmit}>
      <Field
        component={TextFormLine}
        type="text"
        name="email"
        labelText="Email"
      />
      <Field
        component={PasswordFormLine}
        type="password"
        name="password"
        labelText="Password"
      />
      <Field
        component={PasswordFormLine}
        type="password"
        name="password_confirmation"
        labelText="Confirm your Password"
      />
      <Field
        component={TextFormLine}
        type="text"
        name="name"
        labelText="Your name (optional)"
      />
      <Field
        component={CheckBoxFormLine}
        type="checkbox"
        checked={false}
        name="isArtiste"
        labelText="Are you an artiste (optional)"
      />
      <div className="flex items-center">
        <Link className={linkStyle} to="/login">
          Or Login
        </Link>
        <NeutralButton className="ml-auto" type="submit">
          Sign Up
        </NeutralButton>
      </div>
    </form>
  )
}

export default reduxForm({
  form: 'signup',
  validate: validateSignUp
})(SignUpForm)
