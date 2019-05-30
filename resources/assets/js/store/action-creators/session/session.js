import axios from 'axios'

import { userActions } from 'store/actions'

export const getCurrentUserInfo = () => dispatch => {
  return axios.get('/api/v1/auth/user').then(response => {
    dispatch({ type: userActions.SET_CURRENT_USER_INFO, user: response.data })
    return response
  })
}

export const logIn = loginDetails => async dispatch => {
  const response = await axios.post('/api/v1/auth/login', loginDetails)

  dispatch({ type: userActions.SET_CURRENT_USER_INFO, user: response.data })

  return response
}
