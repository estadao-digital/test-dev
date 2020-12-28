import request from './request'

function post (url, data) {
  return request(url, {
    method: 'POST',
    body: JSON.stringify(data)
  })
}

export default post
