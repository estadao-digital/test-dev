import request from './request'

function put (url, data) {
  return request(url, {
    method: 'PUT',
    body: JSON.stringify(data)
  })
}

export default put
